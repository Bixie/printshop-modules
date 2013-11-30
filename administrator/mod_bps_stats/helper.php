<?php

defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_content/models', 'ContentModel');

jimport('joomla.application.categories');

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_latest
 */
abstract class modbps_statsHelper {
	/**
	 * Get the alternate title for the module
	 *
	 * @param	JObject	The module parameters.
	 * @return	string	The alternate title for the module.
	 */
	public static function getTitle($params) {
		$who = $params->get('user_id');
		$catid = (int)$params->get('catid');
		$type = $params->get('ordering') == 'c_dsc' ? '_CREATED' : '_MODIFIED';
		if ($catid)
		{
			$category = JCategories::getInstance('Content')->get($catid);
			if ($category) {
				$title = $category->title;
			}
			else {
				$title = JText::_('MOD_POPULAR_UNEXISTING');
			}
		}
		else
		{
			$title = '';
		}
		return JText::plural('MOD_LATEST_TITLE'.$type.($catid ? "_CATEGORY" : '').($who!='0' ? "_$who" : ''), (int)$params->get('count'), $title);
	}
	
	public static function showstats($params) {
		$app = JFactory::getApplication();
		$app->setUserState('com_bixprintshop.mod_bps_stats.periode',$params['periode']);
		$app->setUserState('com_bixprintshop.mod_bps_stats.dataType',$params['dataType']);
		$sStartDatum = JArrayHelper::getValue($params,'startDatum',JFactory::getDate()->format('Y-m-d'));
		$app->setUserState('com_bixprintshop.mod_bps_stats.startDatum',$sStartDatum);
		$sRapportageDag = $params['rapportageDag'];
		$date1 = JFactory::getDate($sStartDatum);
		$aStats = array();
		$aInfos = array();
		$aGraphInfo = array();
		switch ($params['dataType']) {
			case 'omzet':
				$sStatFunction = 'getBestelTotals';
				$aGraphInfo['titelBase'] = 'MOD_BPS_STATS_GRAPHTITLE_OMZET_DATES_SPR';
				$aGraphInfo['titelvAxis'] = JText::_('MOD_BPS_STATS_TOTALEN');
				$aGraphInfo['titelhAxis'] = JText::_('MOD_BPS_STATS_DAGEN');
				$aGraphInfo['lineCol'] = 1;
			break;
			case 'factuur':
				$sStatFunction = 'getFactuurTotals';
				$aGraphInfo['titelBase'] = 'MOD_BPS_STATS_GRAPHTITLE_FACTUUR_DATES_SPR';
				$aGraphInfo['titelvAxis'] = JText::_('MOD_BPS_STATS_TOTALEN');
				$aGraphInfo['titelhAxis'] = JText::_('MOD_BPS_STATS_DAGEN');
			break;
		}
		$aTotalQueries = array();
		//get juiste startmoment en eindmoment
		switch ($params['periode']) {
			case 'week':
				//begindag bepalen
				$dagNu = $date1->format('N');
				if ($dagNu > $sRapportageDag) { //rapp.dag al voorbij
					$diff = new DateInterval('P'. (($sRapportageDag-$dagNu)+ 7) . 'D');
				} else {
					$diff = new DateInterval('P'. ($sRapportageDag-$dagNu) . 'D');
				}
				$date1->add($diff);
				$date1->setTime(22,59,59); //TODO voor de volgende zomertijd...
				//totalen periode
				$aQueryData['dateBegin'] = clone($date1);
				$aQueryData['dateBegin']->sub(new DateInterval('P7D'));
				$aQueryData['dateEind'] = clone($date1);
				$aQueryData['labelInfo'] = array(
					'date'=>false,
					'format'=>'total',
					'formatted'=>JText::_('FIELD_TOTALS')
				);
				//formats
				$eenheid = 'dag';
				$aGraphInfo['titel'] = JText::sprintf($aGraphInfo['titelBase'],'week '.$aQueryData['dateEind']->format('W'),$aQueryData['dateBegin']->format('d M Y'),$aQueryData['dateEind']->format('d M Y'));
				$aGraphInfo['dateBegin'] = $aQueryData['dateBegin']->format('c');
				$aGraphInfo['dateEind'] = $aQueryData['dateEind']->format('c');
				$aTotalQueries['dag8'] = $aQueryData;
				//subtotalen
				for ($d=7;$d>0;$d--) {
					$aQueryData['dateBegin'] = clone($date1);
					$aQueryData['dateBegin']->sub(new DateInterval('P'.$d.'D'));
					$aQueryData['dateEind'] = clone($date1);
					$aQueryData['dateEind']->sub(new DateInterval('P'.($d-1).'D'));
					$aQueryData['labelInfo'] = array(
						'date'=>$aQueryData['dateEind']->format('c'),
						'format'=>'D d-m',
						'formatted'=>$aQueryData['dateEind']->format('D d-m')
					);
					$aTotalQueries['dag'.$d] = $aQueryData;
				}
				
			break;
			case 'maand':
				//begindag bepalen
				$date1 = $date1->add(new DateInterval('P'.($date1->format('t') - $date1->format('j')).'D'));
				$date1->setTime(22,59,59); //TODO voor de volgende zomertijd...
				//totalen periode
				$aQueryData['dateBegin'] = clone($date1);
				$aQueryData['dateBegin']->sub(new DateInterval('P'.$date1->format('t').'D'));
				$aQueryData['dateEind'] = clone($date1);
				$aQueryData['labelInfo'] = array(
					'date'=>false,
					'format'=>'total',
					'formatted'=>JText::_('FIELD_TOTALS')
				);
				//formats
				$eenheid = 'datum';
				$aGraphInfo['titel'] = JText::sprintf($aGraphInfo['titelBase'],$aQueryData['dateEind']->format('F'),$aQueryData['dateBegin']->add(new DateInterval('PT5H'))->format('d M Y'),$aQueryData['dateEind']->format('d M Y'));
				$aGraphInfo['dateBegin'] = $aQueryData['dateBegin']->format('c');
				$aGraphInfo['dateEind'] = $aQueryData['dateEind']->format('c');
				$aTotalQueries['dag99'] = $aQueryData;
				//subtotalen
				for ($d=$date1->format('t');$d>0;$d--) {
					$aQueryData['dateBegin'] = clone($date1);
					$aQueryData['dateBegin']->sub(new DateInterval('P'.$d.'D'));
					$aQueryData['dateEind'] = clone($date1);
					$aQueryData['dateEind']->sub(new DateInterval('P'.($d-1).'D'));
					$aQueryData['labelInfo'] = array(
						'date'=>$aQueryData['dateEind']->format('c'),
						'format'=>'j',
						'formatted'=>$aQueryData['dateEind']->format('j')
					);
					$aTotalQueries['dag'.$d] = $aQueryData;
				}
			break;
			case 'kwart':
				//formats
				$eenheid = 'week';
				$date2 = JFactory::getDate($date1->toSql());
				$date2->sub(new DateInterval('P3M'));
			break;
			case 'jaar':
				//formats
				$eenheid = 'maand';
				$date2 = JFactory::getDate($date1->toSql());
				$date2->sub(new DateInterval('P2Y'));
			break;
		}
		$browseRange = modbps_statsHelper::getBrowseRange($params['periode']);

	// pr($aTotalQueries,$date1->toSql());
		foreach ($aTotalQueries as $key=>$aQueryData) {
			$sDatumEind = $aQueryData['dateEind']->toSql();
			$sDatumBegin = $aQueryData['dateBegin']->toSql();
			$aStats[$key] = self::$sStatFunction($sDatumBegin,$sDatumEind);
			$aInfos[$key] = $aQueryData['labelInfo'];
		}
		//uit laatste object velden pakken
		$aFields = array_keys($aStats[$key]);
		$aFieldInfos = self::getFieldInfos($eenheid,$aFields);
	// pr($aStats);
	// pr($aInfos);
		$output = json_encode(array('stats'=>$aStats,'infos'=>$aInfos,'fields'=>$aFieldInfos,'graphInfo'=>$aGraphInfo,'browseRange'=>$browseRange,'params'=>$params)); 
		return $output;
	}
	
	public static function getBestelTotals($sDatumBegin,$sDatumEind) {
		$db = JFactory::getDbo();
		$results = new JRegistry;
		$aValidBestelStatussen = self::getValidBestelStatussen();
		$query = $db->getQuery(true);
		$query->from("#__bps_bestelling AS b")
			->where("b.bestelStatus IN ('".implode("','",$aValidBestelStatussen)."')")
			->where("b.created BETWEEN '$sDatumBegin' AND '$sDatumEind'");
		//select besteltotals
		$queryBestel = clone($query);
		$queryBestel->select("SUM(b.administratieInkoop) AS administratieInkoop")
			->select("SUM(b.ordersNetto) AS ordersNetto")
			->select("SUM(b.administratiePrijs) AS administratiePrijs")
			->select("SUM(b.totaalKorting) AS totaalKorting")
			->select("SUM(b.totaalNetto) AS totaalNetto")
			->select("SUM(b.totaalBtw) AS totaalBtw")
			->select("SUM(b.totaalBruto) AS totaalBruto");
		$db->setQuery($queryBestel);
		$dbResult = $db->loadObject();
		$results->loadObject($dbResult);
		//join orders voor overig inkoop
		$queryOrder = clone($query);
		$queryOrder->select("SUM(o.planoInkoop) AS planoInkoop")
			->select("SUM(o.afwerkInkoop) AS afwerkInkoop")
			->select("SUM(o.orderInkoop) AS orderInkoop")
			->select("SUM(o.cartInkoop) AS cartInkoop")
			->select("SUM(o.nettoInkoop) AS nettoInkoop")
			->leftjoin("#__bps_order AS o ON o.bestelID = b.bestelID")
			->where("o.orderStatus NOT IN ('ANNULEE','CART_DELETE')");
		$db->setQuery($queryOrder);
		$dbResult = $db->loadObject();
		$results->loadObject($dbResult);
		$margePerc = round((($results->get('totaalNetto') - $results->get('nettoInkoop')) / $results->get('nettoInkoop',1))*100,1);
		$results->set('margePerc',(string)$margePerc);
		$results->set('margeNetto',(string)($results->get('totaalNetto') - $results->get('nettoInkoop')));
	// pr($results->toObject());	
		return $results->toArray();
	}
	
	public static function getFactuurTotals($sDatumBegin,$sDatumEind) {
		$db = JFactory::getDbo();
		$results = new JRegistry;
		$aValidBestelStatussen = array('FACTUUR_INITIEEL','FACTUUR_CREDITFACTUUR');
		$query = $db->getQuery(true);
		$query->from("#__bps_factuur AS f")
			->where("f.factuurStatus IN ('".implode("','",$aValidBestelStatussen)."')")
			->where("f.created BETWEEN '$sDatumBegin' AND '$sDatumEind'");
		//select factuurtotals
		$query->select("SUM(f.totaalNetto) AS totaalNetto")
			->select("SUM(f.totaalBtw) AS totaalBtw")
			->select("SUM(f.totaalBruto) AS totaalBruto");
		$db->setQuery($query);
		$dbResult = $db->loadObject();
		$results->loadObject($dbResult);
	// pr($results->toObject());	
		return $results->toArray();
	}
	
	public static function getFieldInfos($eenheid,$aFields) {
		$aFieldInfos = array();
		$aActiveFields = array($eenheid,'nettoInkoop','totaalNetto','totaalBruto','margeNetto','margePerc');
		foreach ($aActiveFields as $fieldName) {
			if ($fieldName == $eenheid || in_array($fieldName,$aFields)) {
				$aFieldInfos[$fieldName] = array(
					'name'=>$fieldName,
					'label'=>JText::_('FIELD_'.strtoupper($fieldName)),
					'format'=>'euro'
				);
				if ($fieldName == $eenheid) $aFieldInfos[$fieldName]['format'] = 'label';
				if ($fieldName == 'margePerc') $aFieldInfos[$fieldName]['format'] = 'perc';
			}
		}
	
		return $aFieldInfos;
	}
	
	public static function getBrowseRange($periode) {
		$db = JFactory::getDbo();
		$aValidBestelStatussen = self::getValidBestelStatussen();
		$query = $db->getQuery(true);
		$query->select("MAX(b.created) AS lastDate, MIN(b.created) AS firstDate")
			->from("#__bps_bestelling AS b")
			->where("b.bestelStatus IN ('".implode("','",$aValidBestelStatussen)."')");
		$db->setQuery($query);
		$dbResult = $db->loadObject();
		$lastDate = JFactory::getDate($dbResult->lastDate);
		$firstDate = JFactory::getDate($dbResult->firstDate);
		switch ($periode) {
			case 'week':
				$format = 'Y-W';
				$diff = new DateInterval('P7D');
			break;
			case 'maand':
				$format = 'M-Y';
				$diff = new DateInterval('P1M');
			break;
			default:
				$format = 'd-m-Y';
				$diff = new DateInterval('P1Y');
			break;
		}
		$aBrowseRange = array();
		while ($firstDate < $lastDate) {
			$aBrowseRange[] = (object)array('value'=>$firstDate->format('Y-m-d'),'text'=>$firstDate->format($format));
			$firstDate->add($diff);
		}
		$aBrowseRange = array_reverse($aBrowseRange);
	// pr($aBrowseRange);
		return $aBrowseRange;
	}
	
	public static function getValidBestelStatussen() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("statusCode")
			->from("#__bps_bestelstatus")
			->where('params LIKE \'%"confirmed":"1"%\''); //fishy
		$db->setQuery($query);
		return $db->loadColumn();
	}
	
}

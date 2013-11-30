<?php

defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_content/models', 'ContentModel');

jimport('joomla.application.categories');

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_latest
 */
abstract class modbps_statsHelper
{
	/**
	 * Get a list of articles.
	 *
	 * @params	JObject		The module parameters.
	 *
	 * @return	mixed		An array of articles, or false on error.
	 */
	public static function getList($params)	{
		// Initialise variables
		$user = JFactory::getuser();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select("o.orderID AS id, o.productNaam, o.orderNetto, o.created, o.checked_out, o.checked_out_time");
		// Join over the user
		$query->select("CONCAT(ou.name,' (',ou.username,')') AS userNaam");
		$query->from('#__bps_order AS o');
		$query->join('INNER', '#__users AS ou ON ou.id=o.userID');
		//orderstatus
		$query->select('os.statusName AS orderStatusName');
		$query->join('LEFT', '#__bps_orderstatus AS os ON os.statusCode = o.orderStatus');
		// Join over the users for the checked out user.
		$query->select('up.name AS editor');
		$query->join('LEFT', '#__users AS up ON up.id=o.checked_out');
	
		$query->where('o.bestelID > 0');
		$query->order('o.created DESC');
		
		$db->setQuery($query,0,$params->get('count', 5));
		$items = $db->loadObjectList();

		if ($error = $db->getError()) {
			JError::raiseError(500, $error);
			return false;
		}

		// Set the links
		foreach ($items as &$item) {
			if ($user->authorise('core.edit', 'com_bixprintshop.order.'.$item->id)){
				$item->link = JRoute::_('index.php?option=com_bixprintshop&task=order.edit&orderID='.$item->id);
			} else {
				$item->link = '';
			}
		}

		return $items;
	}

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
		$app->getUserState('com_bixprintshop.mod_bps_stats.periode',$params['periode']);
		$sStartDatum = '2013-11-29 12:29:59';
		$sRapportageDag = $params['rapportageDag'];
		$date1 = JFactory::getDate($sStartDatum);
		$aStats = array();
		$aInfos = array();
		$aGraphInfo = array();
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
				$aGraphInfo['titel'] = JText::sprintf('MOD_BPS_STATS_GRAPHTITLE_OMZET_DATES_SPR',$aQueryData['dateBegin']->format('d M Y'),$aQueryData['dateEind']->format('d M Y'));
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
				//formats
				$eenheid = 'datum';
				$date2 = JFactory::getDate($date1->toSql());
				$date2->sub(new DateInterval('P1M'));
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
		
	// pr($aTotalQueries);
		foreach ($aTotalQueries as $key=>$aQueryData) {
			$sDatumEind = $aQueryData['dateEind']->toSql();
			$sDatumBegin = $aQueryData['dateBegin']->toSql();
			$aStats[$key] = self::getTotals($sDatumBegin,$sDatumEind);
			$aInfos[$key] = $aQueryData['labelInfo'];
		}
		//uit laatste object velden pakken
		$aFields = array_keys($aStats[$key]);
		$aFieldInfos = self::getFieldInfos($eenheid,$aFields);
	// pr($aStats);
	// pr($aInfos);
		$output = json_encode(array('stats'=>$aStats,'infos'=>$aInfos,'fields'=>$aFieldInfos,'graphInfo'=>$aGraphInfo)); 
		return $output;
	}
	
	public static function getTotals($sDatumBegin,$sDatumEind) {
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

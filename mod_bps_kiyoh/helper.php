<?php
/**
 * Bixie Printshop Usermode Module
 * (c) 2011 Matthijs Alles All rights reserved
 */

jimport('joomla.application.module.helper');

class modBPSKiyohHelper {
	public static function readXML($params) { 
		$temppath = JPATH_BASE.DS."cache/mod_bps_kiyoh/";
		if (!is_dir($temppath)) {
			mkdir($temppath);
		}
		$xmlUrl = $params->get('xmlUrl','');
		$cacheTime = (int)$params->get('cacheTime',480) * 60;
		$filename = md5($xmlUrl.$params->toString());
		$tempfile = $temppath.$filename;
		if (file_exists($tempfile)) {
			$mtime = filemtime($tempfile);
			if ((time() - $mtime) < $cacheTime) {
				$aXmlData = unserialize(file_get_contents($tempfile));
				return $aXmlData;
			}
		}
		if (!$oXml = simplexml_load_file($xmlUrl)) {
			echo 'Geen xml geladen';
			return false;
		}
		$oXmlInfo = new JObject;
		$oXmlInfo->set('naam',(string)$oXml->company->name);
		$oXmlInfo->set('kiyohLink',(string)$oXml->company->url);
		$oXmlInfo->set('total_score',(float)$oXml->company->total_score);
		$oXmlInfo->set('total_reviews',(int)$oXml->company->total_reviews);
		$oXmlInfo->set('total_views',(int)$oXml->company->total_views);
		$aReviews = array();
		$iReviewCount = 0;
		foreach ($oXml->review_list->review as $oReview) {
			$oReviewInfo = new JObject;
			$oReviewInfo->set('naam',(string)$oReview->customer->name);
			$oReviewInfo->set('place',(string)$oReview->customer->place);
			$oReviewInfo->set('date',JHtml::_('date',(string)$oReview->customer->date,'%d %b'));
			$oReviewInfo->set('dateRaw',JHtml::_('date',(string)$oReview->customer->date,'%Y-%m-%d'));
			$oReviewInfo->set('total_score',(int)$oReview->total_score);
			$oReviewInfo->set('recommendation',(string)$oReview->recommendation);
			$oReviewInfo->set('positive',(string)$oReview->positive);
			$oReviewInfo->set('negative',(string)$oReview->negative);
			$iReviewCount++;
			if ($params->get('reviewOnly',false) && ($oReviewInfo->positive == '' && $oReviewInfo->negative == '')) {
				continue;
			}
			$aReviews[] = $oReviewInfo->getProperties();
		}
		$oXmlInfo->set('reviewCount',$iReviewCount);
		$oXmlInfo->set('aReviews',$aReviews);
		
		$aXmlData = $oXmlInfo->getProperties();
		
		//in file zetten
		$file = fopen($tempfile, 'w');
		fwrite($file, serialize($aXmlData));
		fclose($file);

// print_r_pre($aXmlData);		
// print_r_pre($oXml->review_list);		
		return $aXmlData;
	}
	public static function round_to_half($num) {
	  if($num >= ($half = ($ceil = ceil($num))- 0.5) + 0.25) return $ceil;
	  else if($num < $half - 0.25) return floor($num);
	  else return $half;
	}
	
}
?>
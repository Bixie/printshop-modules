<?php
/** 
 * Bixie Printshop Kiyoh Module
 * (c) 2013 Matthijs Alles All rights reserved
 */

	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	// Include the helper functions only once
	require_once( dirname(__FILE__).DS.'helper.php' );
	$document	= & JFactory::getDocument();
	$template = $params->get('template','default');
	JHTML::stylesheet('mod_bps_kiyoh.css','modules/mod_bps_kiyoh/assets/');
	$aXmlInfo = modBPSKiyohHelper::readXML($params);
	$sLogoUrl = $params->get('logoUrl','');
	$iBest = (int)$params->get('best',10);
	if ($iBest == 0) {
		echo 'beste score mag niet nul zijn!';
		return false;
	}
	if ($aXmlInfo !== false) {
		require( JModuleHelper::getLayoutPath( 'mod_bps_kiyoh',$template ) );
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>
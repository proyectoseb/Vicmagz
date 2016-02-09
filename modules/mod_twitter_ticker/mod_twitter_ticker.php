<?php
/*------------------------------------------------------------------------
# Twitter Ticker - Version 1.0
# Copyright (C) 2009-2010 YouTechClub.Com. All Rights Reserved.
# @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Author: YouTechClub.Com
# Websites: http://www.youtechclub.com
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );


$module_width 				= $params->get("module_width", '200');
$module_height 				= $params->get("module_height", '300');
$tweetUsers 			= $params->get("tweetUsers", '');
$tweet_title 			= $params->get("tweet_title", '');

JHTML::script('jquery.min.js', JURI::base() . '/modules/'.$module->module.'/assets/');		
JHTML::script('noconflict.js', JURI::base() . '/modules/'.$module->module.'/assets/');
JHTML::script('jquery.mousewheel.js', JURI::base() . '/modules/'.$module->module.'/assets/');
JHTML::script('jScrollPane-1.2.3.min.js', JURI::base() . '/modules/'.$module->module.'/assets/');
JHTML::script('script.js', JURI::base() . '/modules/'.$module->module.'/assets/');		
JHTML::stylesheet('style.css', JURI::base() . '/modules/'.$module->module.'/assets/');
JHTML::stylesheet('jScrollPane.css', JURI::base() . '/modules/'.$module->module.'/assets/');	

$path = JModuleHelper::getLayoutPath( 'mod_twitter_ticker');
if (file_exists($path)) {
	require($path);
}
?>

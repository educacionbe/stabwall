<?php
/**
 * @package Sj Megamenu
 * @version 3.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/core/helper.php';
require_once dirname(__FILE__) .'/core/Mobile_Detect.php';

// include jQuery.



$list		= SjMegamenuHelper::getList($params);
$active		= SjMegamenuHelper::getActive($params);
$active_id 	= $active->id;
$path		= $active->tree;

$showAll	= $params->get('showAllChildren');

$menu_class_sfx	= htmlspecialchars($params->get('class_sfx'));
$menu_tag_id = htmlspecialchars($params->get('tag_id'));

$layout = $params->get('layout', 'default');
if( count($list) ) {
	require JModuleHelper::getLayoutPath('mod_sj_megamenu_res', $layout);
}

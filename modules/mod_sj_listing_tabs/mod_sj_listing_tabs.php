<?php
/**
 * @package SJ Listing Tabs for Content
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

// Include the helper functions only once
require_once dirname(__FILE__) . '/core/helper.php';

$layout = $params->get('layout', 'default');

$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$is_ajax = $is_ajax || JRequest::getInt('is_ajax_listing_tabs', 0);
if($is_ajax){
	$listing_tabs_moduleid	= JRequest::getVar('listing_tabs_moduleid', null);
	if($params->get('type_source') == "filter_categories")
	{
		$categoryid	= JRequest::getVar('categoryid', null);
		$child_items = SjListingTabsHelper::getArticles($categoryid, $params);
	}
	else {
		$article_filter =  JRequest::getVar('categoryid',null);
		$child_items = SjListingTabsHelper::getArticles($params->get('catid'), $params,$article_filter);
	}

	if($listing_tabs_moduleid == $module->id){
		$result = new stdClass();
		ob_start();
		require  JModuleHelper::getLayoutPath($module->module, $layout.'_items');
		$buffer = ob_get_contents();
		$result->items_markup = preg_replace(
				array(
						'/ {2,}/',
						'/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
				),
				array(
						' ',
						''
				),
				$buffer
		);
		ob_end_clean();
		die (json_encode($result));
	}
}else{
	if($params->get('type_source') == 'filter_categories')
		$list = SjListingTabsHelper::getListCategoriesFilter($params);
	else
		$list = SjListingTabsHelper::getListArticlesFilter($params);
	require JModuleHelper::getLayoutPath($module->module, $layout);
	require JModuleHelper::getLayoutPath($module->module, $layout.'_js');
}
?>

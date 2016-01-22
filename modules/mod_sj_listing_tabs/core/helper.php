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

$com_path = JPATH_SITE . '/components/com_content/';
require_once $com_path . 'router.php';
require_once $com_path . 'helpers/route.php';
if (!class_exists('JModelLegacy')) {
	class JModelLegacy extends JModel
	{
	}
}
JModelLegacy::addIncludePath($com_path . '/models', 'ContentModel');
include_once dirname(__FILE__) . '/helper_base.php';

class SjListingTabsHelper extends SjListingTabsBaseHelper
{
	public static function getListCategoriesFilter($params)
	{
		$categories = JCategories::getInstance('Content');
		$catids = $params->get('catid');
		settype($catids, 'array');
		$cat_order_by = $params->get('cat_order_by');
		$list = array();
		$cats = array();
		if (empty($catids)) return;
		$_catids = (array)self::processCategory($catids);
		if (empty($_catids)) return;
		foreach ($_catids as $cid) {
			$category = $categories->get($cid);
			$cats[] = $category;
			switch ($cat_order_by) {
				default:
				case 'title':
					usort($cats, create_function('$a, $b', 'return strnatcasecmp( $a->title, $b->title);'));
					break;
				case 'lft':
					usort($cats, create_function('$a, $b', 'return $a->lft < $b->lft;'));
					break;
				case 'random':
					shuffle($cats);
					break;
			}
		}

		if (empty($cats)) return;
		foreach ($cats as $cat) {
			$cat->count = self::getModel($cat->id, $params)->getTotal();
		}

		if ($params->get('tab_all_display', 1)) {
			$all = new stdClass();
			$all->id = '*';
			$all->count = self::getModel($_catids, $params)->getTotal();
			$all->title = JText::_('ALL_LABEL');
			array_unshift($cats, $all);
		}

		$catidpreload = $params->get('catid_preload');
		$selected = false;
		foreach ($cats as $cat) {
			if(isset($cat->sel)) {
				unset($cat->sel);
			}
			if ($cat->count > 0) {
				if ($cat->id == $catidpreload) {
					$cat->sel = 'sel';
					$cat->child = self::getArticles($catidpreload, $params);
					$selected = true;
				}
				$list[$cat->id] = $cat;
			}
		}
		// first tab is active
		if (!$selected) {
			foreach ($cats as $cat) {
				if ($cat->count > 0) {
					$cat->sel = 'sel';
					$cat->child = self::getArticles($cat->id, $params);
					$list[$cat->id] = $cat;
					break;
				}
			}
		}

		return $list;
	}
	private static function getLabel($filter){
		switch ($filter) {
			case 'title' : return JText::_('TITLE');
			case 'hits' : return JText::_('MOST_VIEW');
			case 'created' : return JText::_('RECENTLY_ADDED');
			case 'featured' : return JText::_('FEATURED');
			case 'ordering' : return JText::_('ORDERING');
		}
	}
	public static function getListArticlesFilter($params)
	{
		$categories = JCategories::getInstance('Content');
		$catids = $params->get('catid');
		$list = array();
		$cats = array();
		$_catids = (array)self::processCategory($catids);
		$filters = $params->get('filter_order_by');
		$articles_filter = array();
		$filter_preload = $params->get('field_preload');
		if(empty($filters)) return;
		if(!in_array($filter_preload,$filters)) {
			foreach ($filters as $filter) {
				$filter_preload = $filter;
				break;
			}
		}
		foreach ($filters as $filter) {
			$aritles = new stdClass();
			$aritles->count = self::getModel($_catids, $params,$filter)->getTotal();
			$aritles->id = $filter;
			$aritles->title = self::getLabel($filter);
			array_unshift($articles_filter, $aritles);
		}
		foreach ($articles_filter as $filter) {
			if ($filter->count > 0) {
				if ($filter->id == $filter_preload) {
					$filter->sel = 'sel';
					$filter->child = self::getArticles($_catids, $params, $filter_preload);
				}
				$list[$filter->id] = $filter;
			}
		}
		return $list;
	}

	private static function processCategory($catids)
	{
		$catpubid = array();
		if (empty($catids)) return;
		$categories = JCategories::getInstance('Content');
		foreach ($catids as $i => $cid) {
			$category = $categories->get($cid);
			$cats[$i] = $category;
			if (empty($category)) {
				unset($cats[$i]);
			} else {
				$catpubid[] = $category->id;
			}
		}
		return $catpubid;
	}

	public static function getArticles($catids, $params, $filter_order = null)
	{
		if ($filter_order) $catids = self::processCategory($catids);
		if ($catids == '*') {
			$catids = self::processCategory($params->get('catid'));
		}
		!is_array($catids) && settype($catids, 'array');
		$model = self::getModel($catids, $params, $filter_order);

		// $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
		// if($is_ajax){
		// var_dump($catids); die;
		// }
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$items = $model->getItems();
		// Find current Article ID if on an article page
		$app = JFactory::getApplication();
		$appParams = $app->getParams();

		$option = $app->input->get('option');
		$view = $app->input->get('view');

		if ($option === 'com_content' && $view === 'article') {
			$active_article_id = $app->input->getInt('id');
		} else {
			$active_article_id = 0;
		}

		// Prepare data for display using display options
		foreach ($items as &$item) {
			$item->slug = $item->id . ':' . $item->alias;
			$item->catslug = $item->catid ? $item->catid . ':' . $item->category_alias : $item->catid;

			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$app = JFactory::getApplication();
				$menu = $app->getMenu();
				$menuitems = $menu->getItems('link', 'index.php?option=com_users&view=login');
				if (isset($menuitems[0])) {
					$Itemid = $menuitems[0]->id;
				} elseif ($app->input->getInt('Itemid') > 0) {
					// Use Itemid from requesting page only if there is no existing menu
					$Itemid = $app->input->getInt('Itemid');
				}
				$item->link = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $Itemid);
			}
			// Used for styling the active article
			$item->active = $item->id == $active_article_id ? 'active' : '';
			$item->tags = '';
			if (class_exists('JHelperTags')) {
				$item->tags = new JHelperTags;
				$item->tags->getItemTags('com_content.article', $item->id);
			} else {
				$item->tags = '';
			}

			$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_sj_categories_accordion.content');
			self::getAImages($item, $params);
			$item->introtext = self::_cleanText($item->introtext);
			$item->displayIntrotext = self::_cleanText($item->introtext);
		}
		return $items;
	}

	public static function getModel($catids, $params, $filter_order = null)
	{
		$db = JFactory::getDbo();
		// Get an instance of the generic articles model
		$articles = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		// Set application parameters in model

		$articles->setState(
			'list.select',
			'a.id, a.title, a.alias, a.introtext, a.fulltext, ' .
				'a.checked_out, a.checked_out_time, ' .
				'a.catid, a.created, a.created_by, a.created_by_alias, ' .
				// use created if modified is 0
				'CASE WHEN a.modified = ' . $db->q($db->getNullDate()) . ' THEN a.created ELSE a.modified END as modified, ' .
				'a.modified_by, uam.name as modified_by_name,' .
				// use created if publish_up is 0
				'CASE WHEN a.publish_up = ' . $db->q($db->getNullDate()) . ' THEN a.created ELSE a.publish_up END as publish_up,' .
				'a.publish_down, a.images, a.urls, a.attribs, a.metadata, a.metakey, a.metadesc, a.access, ' .
				'a.hits, a.xreference, a.featured'
		);

		$app = JFactory::getApplication();
		$appParams = $app->getParams();

		$articles->setState('params', $appParams);
		// Set the filters based on the module params
		$start = $app->input->getInt('ajax_reslisting_start', 0);
		$articles->setState('list.start', $start);
		$articles->setState('list.limit', (int)$params->get('source_limit', 0));
		$articles->setState('filter.published', 1);

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$articles->setState('filter.access', $access);

		// Category filter
		//$catids = $params->get('catid');
		settype($catids, 'array');
		if (!empty($catids)) {
			if ($params->get('show_child_category_articles', 0) && (int)$params->get('levels', 0) > 0) {
				// Get an instance of the generic categories model
				$categories = JModelLegacy::getInstance('Categories', 'ContentModel', array('ignore_request' => true));
				$categories->setState('params', $appParams);
				$levels = $params->get('levels', 1) ? $params->get('levels', 1) : 9999;
				$categories->setState('filter.get_children', $levels);
				$categories->setState('filter.published', 1);
				$categories->setState('filter.access', $access);
				$additional_catids = array();

				foreach ($catids as $catid) {
					$categories->setState('filter.parentId', $catid);
					$recursive = true;
					$items = $categories->getItems($recursive);
					if ($items) {
						foreach ($items as $category) {
							$condition = (($category->level - $categories->getParent()->level) <= $levels);
							if ($condition) {
								$additional_catids[] = $category->id;
							}
						}
					}
				}

				$catids = array_unique(array_merge($catids, $additional_catids));
			}

			$articles->setState('filter.category_id', $catids);
			// Ordering
			if (!$filter_order) {
				$articles->setState('filter.featured', $params->get('show_front', 'show'));
				$articles->setState('list.ordering', $params->get('article_ordering', 'a.ordering'));
				$articles->setState('list.direction', $params->get('article_ordering_direction', 'ASC'));
			}
			else {
				switch ($filter_order) {
					case 'featured': $articles->setState('filter.featured', 'only'); break;
					case 'title' :
						$articles->setState('list.ordering', $filter_order);
						$articles->setState('list.direction', 'ASC');
						break;
					case 'featured':
						$articles->setState('filter.featured', 'only');
						$articles->setState('list.ordering', 'fp.ordering');
						break;
					case 'created':
						$articles->setState('list.ordering', $filter_order);
						$articles->setState('list.direction', 'DESC');
						break;
					case 'hits':
						$articles->setState('list.ordering', $filter_order);
						$articles->setState('list.direction', 'DESC');
						break;
				}
			}

			// Filter by language
			$articles->setState('filter.language', $app->getLanguageFilter());

			return $articles;
		}
	}
}




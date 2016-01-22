<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// includes placehold
$yt_temp = JFactory::getApplication()->getTemplate();
include (JPATH_BASE . '/templates/'.$yt_temp.'/includes/placehold.php');

// Create a shortcut for params.
$params = $this->item->params;
$images = json_decode($this->item->images);
$canEdit = $this->item->params->get('access-edit');
$info    = $this->item->params->get('info_block_position', 0);


global $leadingFlag;
$doc = JFactory::getDocument();
$app = JFactory::getApplication();

?>

<?php if ($this->item->state == 0) : ?>
<div class="system-unpublished">
<?php endif; ?> 

<div class="media">
	<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
	<div class="article-text media-body">
		<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
	
		<?php if (!$params->get('show_intro')) : ?>
			<?php echo $this->item->event->afterDisplayTitle; ?>
		<?php endif; ?>

		<aside class="article-aside">
			<?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
			<?php // Todo Not that elegant would be nice to group the params ?>
			<?php $useDefList = ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit || 
			  $params->get('show_author') || $params->get('show_category') || $params->get('show_create_date') || 
			  $params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_parent_category') || 
			  $params->get('show_hits') ); ?>

			<?php if ($useDefList) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
			<?php endif; ?>
		</aside>
		
		<?php echo $this->item->event->beforeDisplayContent; ?>
	
		<?php if ($params->get('show_intro')) : ?>
			<div class="article-intro">
				<?php //echo $this->item->introtext; ?>
				<?php echo substr($this->item->introtext,  0, 140); ?>
			</div>
		<?php endif; ?>
    
		<?php if ($params->get('show_readmore') && $this->item->readmore) :
			if ($params->get('access-view')) :
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
			else :
				$menu = JFactory::getApplication()->getMenu();
				$active = $menu->getActive();
				$itemId = $active->id;
				$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
				$link->setVar('return', base64_encode(JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language), false)));
			endif; ?>

			<?php echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

		<?php endif; ?>

		<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
			<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
			<?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
				<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
			<?php endif; ?>
		<?php endif; ?>
		
	</div>
</div>
<?php if ($this->item->state == 0) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>

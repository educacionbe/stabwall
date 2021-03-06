<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

$isSingleTag = (count($this->item) == 1);
$doc = JFactory::getDocument();
$app = JFactory::getApplication(); 
$templateParams = JFactory::getApplication()->getTemplate(true)->params;

?>

<div class="blog tag-category <?php echo $this->pageclass_sfx; ?>">
<?php  if ($this->params->get('show_page_heading')) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif;  ?>
<?php if($this->params->get('show_tag_title', 1)) : ?>
	<h2 class="heading-category"> 				
			<span class="subheading-category"><?php echo JHtml::_('content.prepare', $this->document->title, '', 'com_tag.tag'); ?></span>
	</h2>
<?php endif; ?>

<?php // We only show a tag description if there is a single tag. ?>
<?php  if (count($this->item) == 1 && (($this->params->get('tag_list_show_tag_image', 1)) || $this->params->get('tag_list_show_tag_description', 1))) : ?>
	<?php $images = json_decode($this->item[0]->images); ?>
	<?php if ($this->params->get('tag_list_show_tag_image', 1) == 1 && !empty($images->image_fulltext)||
		$this->params->get('tag_list_show_tag_description') == 1 && $this->item[0]->description) : ?>
	<div class="category-desc">
	<?php if ($this->params->get('tag_list_show_tag_image', 1) == 1 && !empty($images->image_fulltext)) : ?>
		<img src="<?php echo htmlspecialchars($images->image_fulltext);?>">
	<?php endif; ?>
	<?php if ($this->params->get('tag_list_show_tag_description') == 1 && $this->item[0]->description) : ?>
		<?php echo JHtml::_('content.prepare', $this->item[0]->description, '', 'com_tags.tag'); ?>
	<?php endif; ?>
	
	<div class="clr"></div>
	</div>
	<?php endif; ?>
<?php endif; ?>
<?php // If there are multiple tags and a description or image has been supplied use that. ?>
<?php if ($this->params->get('tag_list_show_tag_description', 1) || $this->params->get('show_description_image', 1)): ?>
		<?php if ($this->params->get('show_description_image', 1) == 1 && $this->params->get('tag_list_image')) :?>
			<img src="<?php echo $this->params->get('tag_list_image');?>">
		<?php endif; ?>
		<?php if ($this->params->get('tag_list_description', '') > '') :?>
			<?php echo JHtml::_('content.prepare', $this->params->get('tag_list_description'), '', 'com_tags.tag'); ?>
		<?php endif; ?>

<?php endif; ?>

<?php echo $this->loadTemplate('items'); ?>
	<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
	<div class="pagination">
		<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
		<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php  endif; ?>

</div>

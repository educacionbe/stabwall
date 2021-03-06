<?php
/**
 * @package SJ Listing Tabs for Content
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
if (!empty($list)) {
	JHtml::stylesheet('modules/' . $module->module . '/assets/css/sj-listing-tabs.css');
	JHtml::stylesheet('modules/' . $module->module . '/assets/css/animate.css');
	if (!defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1") {
		JHtml::script('modules/' . $module->module . '/assets/js/jquery-1.8.2.min.js');
		JHtml::script('modules/' . $module->module . '/assets/js/jquery-noconflict.js');
		define('SMART_JQUERY', 1);
	}


	ImageHelper::setDefault($params);

	$instance = rand() . time();
	$tag_id = 'sj_listing_tabs_' . rand() . time();
	$options = $params->toObject();
	$class_ltabs = 'ltabs00-' . $params->get('nb-column1', 6) . ' ltabs01-' . $params->get('nb-column1', 6) . ' ltabs02-' . $params->get('nb-column2', 4) . ' ltabs03-' . $params->get('nb-column3', 2) . ' ltabs04-' . $params->get('nb-column4', 1)
	?>
	<!--[if lt IE 9]>
	<div id="<?php echo $tag_id; ?>" class="sj-listing-tabs msie lt-ie9 first-load"><![endif]-->
	<!--[if IE 9]>
	<div id="<?php echo $tag_id; ?>" class="sj-listing-tabs msie first-load"><![endif]-->
	<!--[if gt IE 9]><!-->
	<div id="<?php echo $tag_id; ?>" class="sj-listing-tabs style first-load"><!--<![endif]-->
		<?php if (!empty($options->pretext)) { ?>
			<div class="pre-text"><?php echo $options->pretext; ?></div>
		<?php } ?>
		<div class="ltabs-wrap ">
			<div class="ltabs-tabs-container" data-delay="<?php echo $params->get('delay', 300); ?>"
				 data-duration="<?php echo $params->get('duration', 600); ?>"
				 data-effect="<?php echo $params->get('effect'); ?>"
				 data-ajaxurl="<?php echo (string)JURI::getInstance(); ?>" data-modid="<?php echo $module->id; ?>">
				<!--Begin Tabs-->
				<?php require JModuleHelper::getLayoutPath($module->module, $layout . '_tabs'); ?>
			</div>
			<!-- End Tabs-->
			<div class="ltabs-items-container"><!--Begin Items-->
				<?php foreach ($list as $items) {
				$child_items = isset($items->child) ? $items->child : '';
				$cls_device = $class_ltabs;
				$cls_animate = $params->get('effect');
				$cls = (isset($items->sel) && $items->sel == "sel") ? ' ltabs-items-selected ltabs-items-loaded' : '';
				$cls .= ($items->id == "*") ? ' items-category-all' : ' items-category-' . $items->id;
				?>
				<div class="ltabs-items <?php echo $cls; ?>">
					<div class="ltabs-items-inner <?php echo $cls_device . ' ';
					echo $cls_animate; ?>"
					">
					<?php if (!empty($child_items)) {
						require JModuleHelper::getLayoutPath($module->module, $layout . '_items');
					} else {
						?>
						<div class="ltabs-loading"></div>
					<?php } ?>
				</div>
				<?php $classloaded = ($params->get('source_limit', 2) >= $items->count || $params->get('source_limit', 2) == 0) ? 'loaded' : ''; ?>
				<div class="ltabs-loadmore"
					 data-active-content=".items-category-<?php echo ($items->id == "*") ? 'all' : $items->id; ?>"
					 data-categoryid="<?php echo $items->id; ?>"
					 data-rl_start="<?php echo $params->get('source_limit', 2) ?>"
					 data-rl_total="<?php echo $items->count ?>"
					 data-rl_allready="<?php echo JText::_('ALL_READY_LABEL'); ?>"
					 data-ajaxurl="<?php echo (string)JURI::getInstance(); ?>" data-modid="<?php echo $module->id; ?>"
					 data-rl_load="<?php echo $params->get('source_limit', 2) ?>">
					<div class="ltabs-loadmore-btn <?php echo $classloaded ?>"
						 data-label="<?php echo ($classloaded) ? JText::_('ALL_READY_LABEL') : JText::_('LOAD_MORE_LABEL'); ?>">
						<span class="ltabs-image-loading"></span>
						<img class="add-loadmore"
							 src="<?php echo JURI::base(); ?>/modules/mod_sj_listing_tabs/assets/images/add.png">
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<!--End Items-->
	</div>
	<?php if (!empty($options->posttext)) { ?>
		<div class="post-text"><?php echo $options->posttext; ?></div>
	<?php } ?>
	</div>
<?php
} else {
	echo JText::_('Has no item to show!');
} ?>




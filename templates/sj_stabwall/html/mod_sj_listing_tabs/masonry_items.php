<?php
/**
 * @package SJ Listing Tabs for Content
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
$small_image_config = array(
	'type' => $params->get('imgcfg_type'),
	'width' => $params->get('imgcfg_width'),
	'height' => $params->get('imgcfg_height'),
	'quality' => 90,
	'function' => ($params->get('imgcfg_function') == 'none') ? null : 'resize',
	'function_mode' => ($params->get('imgcfg_function') == 'none') ? null : substr($params->get('imgcfg_function'), 7),
	'transparency' => $params->get('imgcfg_transparency', 1) ? true : false,
	'background' => $params->get('imgcfg_background'));
if (!empty($child_items)) {
	$app = JFactory::getApplication();
	$k = $app->input->getInt('ajax_reslisting_start', 0);
	foreach ($child_items as $item) {
		$rand = rand();
		$k++; ?>
		<div class="ltabs-item new-ltabs-item">
			<div class="item-inner">
				<?php
				$img0 = SjListingTabsHelper::getAImage($item, $params);
				if ($img0 && (@GetImageSize($img0['src']) || file_exists($img0['src']))) {
					?>
					<div class="item-image">
						<a class="rspl-image" data-src="<?php echo SjListingTabsHelper::imageSrc($img0, $params); ?>"
						   href="<?php echo $item->link ?>" <?php echo SjListingTabsHelper::parseTarget($params->get('link_target', '_self')) ?>
						   title="<?php echo $item->title ?>">
							<?php echo SjListingTabsHelper::imageTag($img0, $small_image_config); ?>
						</a>
					</div>
				<?php } ?>
				<?php if ($params->get('item_title_display', 1) == 1 || $params->get('item_readmore_display', 1) == 1) { ?>
				<div class="item-info">
					<div class="item-info-inner">
						<?php if ($params->get('item_title_display', 1) == 1) { ?>
							<h4 class="item-title ">
								<a href="<?php echo $item->link ?>" <?php echo SjListingTabsHelper::parseTarget($params->get('link_target', '_self')) ?>
								   title="<?php echo $item->title ?>">
									<?php echo SjListingTabsHelper::truncate($item->title, $params->get('item_title_max_characters', 25), ""); ?>
								</a>
							</h4>
						<?php } ?>
						
						<?php if ($params->get('item_readmore_display', 1) == 1) { ?>
							<div class="item_readmore ">
								<a class="btn readmore" href="<?php echo $item->link ?>" <?php echo SjListingTabsHelper::parseTarget($params->get('link_target', '_self')) ?>
								   title="<?php echo $item->title ?>">
									<?php //echo $params->get('item_readmore_text'); ?>
									<i class=" fa fa-link"></i>
								</a>
								<a class="btn mymodal" title="<?php echo JText::_('QUICKVIEW');?>" data-toggle="modal" data-target="#myModal<?php echo $item->id.'-'.$rand ?>">
								  <i class=" fa fa-search"></i>
								</a>
							</div>
						<?php } ?>
						
					</div>
				</div>
				<?php } ?>
				<?php if ($params->get('item_created_display', 1) == 1) { ?>
					<div class="created-date ">
						<?php
						echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3'));
						?>
					</div>
				<?php } ?>
				<?php if ($params->get('item_description_display', 1) == 1) { ?>
					<div class="introtext">
						<?php echo SjListingTabsHelper::truncate($item->introtext, $params->get('item_des_maxlength', 200)); ?>
					</div>
				<?php }
					$tags = '';
					if ($params->get('item_tags_display') == 1 && $item->tags != '' && !empty($item->tags->itemTags)) {
					$item->tagLayout = new JLayoutFile('joomla.content.tags');
					$tags = $item->tagLayout->render($item->tags->itemTags);
					}
					if ($tags != '') {
					?>
				<div class="item-tags">
					<?php echo $tags; ?>
				</div>
				<?php }?>
				<?php if ($params->get('item_hits_display', 1) == 1 || $params->get('item_author_display', 1) == 1) { ?>
				<div class="other-infor">
					<?php if ($params->get('item_hits_display', 1) == 1) { ?>
						<div class="hits">
							<?php echo JText::_('READ', true); ?> <?php if ($item->hits > 1) {
								echo $item->hits.' ' ;
								echo JText::_('TIMES', true);
							} else {
								echo $item->hits .' ' ;
								echo JText::_('TIME', true);
							}?>
						</div>
					<?php } ?>
					<?php if ($params->get('item_author_display', 1) == 1) { ?>
						<div class="author">
							<?php echo JText::_('WRITEN_BY', true); ?> <span
								class="author-text"> <?php echo($item->author); ?> </span>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="myModal<?php echo $item->id.'-'.$rand ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $item->id.'-'.$rand ?>">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel<?php echo $item->id.'-'.$rand ?>"><?php echo $item->title; ?></h4>
				  </div>
				  <div class="modal-body">
					<?php echo SjListingTabsHelper::imageTag($img0, $small_image_config); ?>
				  </div>
				</div>
			  </div>
			</div>
		</div>

		<?php $clear = 'clr1';
		if ($k % 2 == 0) $clear .= ' clr2';
		if ($k % 3 == 0) $clear .= ' clr3';
		if ($k % 4 == 0) $clear .= ' clr4';
		if ($k % 5 == 0) $clear .= ' clr5';
		if ($k % 6 == 0) $clear .= ' clr6';
		?>
		<div class="<?php echo $clear; ?>"></div>
	<?php
	} ?>
<?php
}?>


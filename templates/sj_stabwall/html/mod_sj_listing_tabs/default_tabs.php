<?php
/**
 * @package SJ Listing Tabs for Content
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
$cat_image_config = array(
	'type' => $params->get('imgcfgcat_type'),
	'width' => $params->get('imgcfgcat_width'),
	'height' => $params->get('imgcfgcat_height'),
	'quality' => 90,
	'function' => ($params->get('imgcfgcat_function') == 'none') ? null : 'resize',
	'function_mode' => ($params->get('imgcfgcat_function') == 'none') ? null : substr($params->get('imgcfgcat_function'), 7),
	'transparency' => $params->get('imgcfgcat_transparency', 1) ? true : false,
	'background' => $params->get('imgcfgcat_background'));
?>
<div class="ltabs-tabs-wrap">
	<span class='ltabs-tab-selected'></span>
	<span class='ltabs-tab-arrow'>&#9660</span>
	<ul class="ltabs-tabs cf">
		<?php
		foreach ($list as $tab) {
			if ($params->get('type_source') == "filter_categories") {
				?>
				<li class="ltabs-tab <?php echo isset($tab->sel) ? '  tab-sel tab-loaded' : ''; ?> <?php echo ($tab->id == ('*')) ? ' tab-all' : ''; ?>"
					data-category-id="<?php echo $tab->id; ?>"
					data-active-content=".items-category-<?php echo ($tab->id == "*") ? 'all' : $tab->id; ?>">
				<?php if ($params->get('tab_icon_display', 1)) {
					if ($tab->id != "*") {
						$item_img = SjListingTabsHelper::getCImage($tab, $params, 'imgcfgcat');
						if ($item_img) {
							?>
							<div class="ltabs-tab-img">
								<img src="<?php echo SjListingTabsHelper::imageSrc($item_img, $cat_image_config); ?>"
									 title="<?php echo $tab->title; ?>" alt="<?php echo $tab->title; ?>"
									 style="width: <?php echo $params->get('imgcfgcat_width'); ?>px; height:<?php echo $params->get('imgcfgcat_height') ?>px;"/>
							</div>
						<?php
						}
					} else {
						$item_img = 'modules/mod_sj_listing_tabs/assets/images/icon-catall.png';
						?>
						<div class="ltabs-tab-img">
							<img class="cat-all" src="<?php echo $item_img; ?>"
								 title="<?php echo $tab->title; ?>" alt="<?php echo $tab->title; ?>"
								 style="width: 32px; height:74px;"/>
						</div>
					<?php
					}
					?>

				<?php } ?>
				<span
					class="ltabs-tab-label"><?php echo SjListingTabsHelper::truncate($tab->title, $params->get('tab_max_characters')); ?>
			</span>
			</li>
		<?php }
			else {?>
				<li class="ltabs-tab <?php echo isset($tab->sel) ? '  tab-sel tab-loaded' : ''; ?> <?php echo ($tab->id == ('*')) ? ' tab-all' : ''; ?>"
					data-category-id="<?php echo $tab->id; ?>"
					data-active-content=".items-category-<?php echo $tab->id; ?>">
					<span
						class="ltabs-tab-label"><?php echo SjListingTabsHelper::truncate($tab->title, $params->get('tab_max_characters')); ?>
			</span>
				</li>
			<?php }
		} ?>
	</ul>
</div>

<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :  ?>
	<li itemscope itemtype="http://schema.org/Article" class="media">
		<?php echo JLayoutHelper::render('joomla.content.tabs_image', $item);?>
		<div class="media-body">
			<h4 class="media-heading">
			<a href="<?php echo $item->link; ?>" itemprop="url">
				<span itemprop="name">
					<?php echo $item->title; ?>
				</span>
			</a>
			</h4>
			<?php if ($item->displayDate) : ?>
				<span class="mod-articles-date"><?php echo JHTML::_('date', $item->displayDate ,JText::_('DATE_FORMAT_LC3')); ?></span>
			<?php endif; ?>
		</div>
	</li>
<?php endforeach; ?>
</ul>
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
<div class="row recent-projects <?php echo $moduleclass_sfx; ?>">
<?php $myModalid = 0?>
<?php foreach ($list as $item) :  ?>
	<?php $myModalid++?>
	<div itemscope itemtype="http://schema.org/Article" class="col-sm-4" data-sr='wait 0.4s, scale up 25%, vFactor 0.1'>
		<div class="recent-projects-item">
			<?php echo JLayoutHelper::render('joomla.content.project_image', $item);?>
			<div class="projects-content-inner">
				<div class="projects-content">
					<h4 class="itemtitle">
					<a title="<?php echo $item->title; ?>" href="<?php echo $item->link; ?>">
						<span itemprop="name">
							<?php echo $item->title; ?>
						</span>
					</a>
					</h4>
					<a title="<?php echo JText::_('QUICKVIEW');?>" class="img-circle btn" data-toggle="modal" data-target="#myModal<?php echo $myModalid; ?>">
					  <i class=" fa fa-search"></i>
					</a>
					<a title="<?php echo $item->title; ?>" class="img-circle btn" href="<?php echo $item->link; ?>"><i class=" fa fa-link"></i></a>
				</div>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="myModal<?php echo $myModalid; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $myModalid; ?>">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel<?php echo $myModalid; ?>"><?php echo $item->title; ?></h4>
				  </div>
				  <div class="modal-body">
					<?php echo JLayoutHelper::render('joomla.content.project_image', $item);?>
				  </div>
				</div>
			  </div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>

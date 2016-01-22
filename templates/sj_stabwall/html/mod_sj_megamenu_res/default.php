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
$instance	= rand().time();
$menu_class_sfx = $params->get('moduleclass_sfx');
$menu_id = $menu_tag_id."_".$instance;
$detect = new Mobile_Detect();
if ( $params->get('include_js', 1)  ){
	JHtml::script('modules/' . $module->module . '/assets/js/megamenu.js');
	JHtml::script('modules/' . $module->module . '/assets/js/jquery.megamenu.js');
	JHtml::script('modules/' . $module->module . '/assets/js/dropdown_menu.js');
}
if ( $params->get('include_css', 1) ){
	JHtml::stylesheet('modules/' . $module->module . '/assets/css/megamenu.css');
}
?>
<!--[if lt IE 9]><div id="<?php echo $menu_id; ?>" class="sambar msie lt-ie9 " data-sam="<?php echo $instance; ?>"><![endif]-->
<!--[if IE 9]><div id="<?php echo $menu_id; ?>" class="sambar msie  " data-sam="<?php echo $instance; ?>"><![endif]-->
<!--[if gt IE 9]><!--><div id="<?php echo $menu_id; ?>" class="sambar" data-sam="<?php echo $instance; ?>"><!--<![endif]-->
	<div class="sambar-inner">
		<a class="btn-sambar open hidden" data-sapi="collapse" href="<?php echo '#'.$menu_id; ?>">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
<?php 

if($params->get('type_show') == 'vertical'){
	$cls_type = ' sj_mega_menu_vertical';
}else{
	$cls_type = '';
}
$cls_type_position = '';
?>
<ul class="sj-megamenu<?php echo $cls_type;?> <?php echo $cls_type_position;?> <?php echo $menu_class_sfx; ?> <?php if( $params->get('menu_event') == 'hover' ){
	if ( !$detect->isMobile() && !$detect->isTablet() ) { echo "sj-megamenu-hover";}}?>" data-jsapi="on">
	<?php
	foreach ($list as $i => &$item) {

		// id for itemid
		$id = $item->params->get('xmp_tag_id', '');
		if (!empty($id)) {
			$id = ' id="'.trim($id) .'"';
		}

		// class for itemid
		$class = 'item-'.$item->id;
		if ($item->id == $active_id) {
			$class .= ' current';
		}

		// class for active state
		if (in_array($item->id, $path)) {
			$class .= ' active';
		} elseif ($item->type == 'alias') {
			// alias of active item.
			$aliasToId = $item->params->get('aliasoptions');
			if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
				$class .= ' active';
			} elseif (in_array($aliasToId, $path)) {
				$class .= ' alias-parent-active';
			}
		}

		// class for leel
		$class .= ' level-'.$item->level;

		if ($item->level == 1 && $item->params->get('xmp_float')=='right' ){
			$class .= ' mega-right';
		}
		$fixed_width = (int)$item->params->get('xmp_fixed_width', 0);

		$show_as = $item->params->get('xmp_show_as', 'mega-dropofly');
		if ($item->level >= 2){
			$fly = $item->params->get('xmp_fly_dir', 'right'); // left / right
			if ($show_as == 'mega-dropofly'){
				if ($fly=='left'){
					$class .= ' fly-left';
				} else if ($fly=='right'){
					// default
					$class .= ' fly-right';
				}
			} else {
				$fixed_width = 0;
				$class .= ' '.$show_as;
			}
		} else {
			
		}
		if ($item->id==540){
		}

		if ($item->parent) {
			$class .= ' parent';
		}

		if($item->params->get('xmp_tag_class') !=null ){
			$col = $item->params->get('xmp_tag_class');
			$class .= " ".$col;
		}

		// TODO: best way params get method
		$xmp_type = $item->params->get('xmp_contenttype', '');
		if( $xmp_type ){
			$class .= " ".$xmp_type;
			if (!$item->parent && $xmp_type=='mod'){
				$class .= ' parent';
			}
		}

		//$event = $item->params->get('xmp_events');
		//$class .= " ".$event;
		
		if (!empty($class)) {
			$class = ' class="'.trim($class) .'"';
		}?>

	<li <?php echo $id;?> <?php echo $class;?>>
	<?php
		if ( empty($xmp_type) ){
			// Render the menu item.
			switch ($item->type){
				case 'separator':
				case 'url':
				case 'component':
					require JModuleHelper::getLayoutPath($module->module, $layout.'_'.$item->type);
					break;
				default:
					require JModuleHelper::getLayoutPath($module->module, $layout.'_url');
					break;
			}
		} else {
			switch ($xmp_type){
				case 'mod':
					require JModuleHelper::getLayoutPath($module->module, $layout.'_module');
					break;
				case 'divider':
					break;
			}
		}
		
		if($params->get('position') == 'left'){
			$cls_type_position = ' sj_mega_menu_vertical_left';
		}else{
			$cls_type_position = ' sj_mega_menu_vertical_right';
		}
	// The next item is deeper.
	$showchild = (int)$item->params->get('xmp_showchild');
	$fly = $item->params->get('xmp_position');
	if ($item->deeper) {?>
		<div class="sj-megamenu-child"
			<?php if ( $fixed_width ): ?>
			style="width: <?php echo $fixed_width;?>px;"
			<?php endif; ?>
		>
		<ul class="submenu <?php echo $item->params->get('xmp_cols');?>">
			<?php
	} else if ($item->shallower) {
		// The next item is shallower.
		echo '</li>';
		echo str_repeat('</ul></div></li>', $item->level_diff);
	} else {
		// The next item is on the same level.
		echo '</li>';
	}}?>
</ul>
	</div>
</div>
<?php if( $params->get('css_style') == 0 ){?>
	<script type="text/javascript">
	jQuery(function($){
		$('#<?php echo $menu_id; ?> .sj-megamenu').each(function(){
			var $menu = $(this), clearMenus = function( el ){
				var parents = $(el).parents();
				$menu.find('.actived').not(parents).not(el).each( function(){
					$(this).removeClass('actived');
					$(this).children('.sj-megamenu-child').slideUp(0);
				});
			};
			var window_w = $(window).width();
				<?php if( $params->get('menu_event') == 'click' ){?>
					//console.log($menu);
					
					$('.level-1 > a', $menu).click( function(e){
						e.preventDefault();
						$parent = $(this).parent();						
						$sub = $(this).next();						
						clearMenus($parent);
						$parent.toggleClass('actived');
						
						if($parent.hasClass('actived')){
							$sub.hide().slideDown(300);							
						}else{
							$sub.hide().slideUp(300);
						}
					
						return false;
					});
					
					$('.level-4 > a', $menu).click( function(e){
						e.preventDefault();
						$parent = $(this).parent();						
						$sub = $(this).next();						
						clearMenus($parent);
						$parent.toggleClass('actived');
						
						if($parent.hasClass('actived')){
							$sub.hide().slideDown(300);							
						}else{
							$sub.hide().slideUp(300);
						}
					
						return false;
					});
					
					
					/*$menu.on('click', '.parent.level-1', function(e){
						e.preventDefault();
						var $this = $(this), data = $this.data(), $dropdown = $this.children('.sj-megamenu-child');
						clearMenus($this);
						$this.toggleClass('actived');
						if($this.hasClass('actived')){
							$dropdown.hide().slideDown(300);
						}else{
							$dropdown.hide().slideUp(300);
						}
						return false;
					});*/

				<?php } else{?>
					if(window_w <= 980)
					{
						$('.level-1 > a', $menu).click( function(e){
							e.preventDefault();
							$parent = $(this).parent();						
							$sub = $(this).next();						
							clearMenus($parent);
							$parent.toggleClass('actived');
							
							if($parent.hasClass('actived')){
								$sub.hide().slideDown(300);							
							}else{
								$sub.hide().slideUp(300);
							}
						
							return false;
						});
					}
					else
					{
						$( '#<?php echo $menu_id; ?> .sj-megamenu .parent > a' ).hover(function(){
							var $this = $(this), data = $this.data(), $dropdown = $this.children('.sj-megamenu-child');
							$parent = $(this).parent();
							if( $this.hasClass('actived') && !$this.hasClass('mega-pinned') ){
								$dropdown.hide().slideDown(300);
							}
						},function(){
							var $this = $(this), data = $this.data(), $dropdown = $this.children('.sj-megamenu-child');
							$this.removeClass('actived');
							if( !$this.hasClass('mega-pinned') ){
								$dropdown.hide().slideUp(300);
							}
						});
						return false;
					}
				<?php }?>
			});
			
		});
		
	</script>
	
<?php } ?>
<script type="text/javascript">
	jQuery( window ).resize(function() {
		var w_width = parseInt(jQuery(window).width());
		if(w_width <991){
			jQuery('#<?php echo $menu_id;?> .sj_mega_menu_vertical .level-1.parent ').each(function(){
				var html = jQuery(this).find('a').eq(0).html();
				jQuery(this).find('a').eq(0).remove();
				jQuery(this).prepend('<a href="#">'+html+'</a>');
			})
		}
	})
	jQuery(function($){
	var w_width = parseInt($(window).width());
	
	if(w_width > 991){
		<?php if($params->get('position') == 'right' && $params->get('type_show') == 'vertical'){ ?>

					
					$('#<?php echo $menu_id;?> .level-2').each(function(){
						$(this).find('.submenu ').eq(0).append('<div style="clear:both"></div>');
						if(!$(this).hasClass('mega-pinned')){
							$(this).find('.sj-megamenu-child').eq(0).css('position','absolute');
							$(this).find('.sj-megamenu-child').eq(0).css('top','0px');
							$(this).find('.sj-megamenu-child').eq(0).css('left','100%');
						}
					})
					$('#<?php echo $menu_id;?> .sj_mega_menu_vertical .level-1').each(function(){
						$(this).find('.submenu ').eq(0).append('<div style="clear:both"></div>');
						
					})


		<?php } ?>

		<?php if($params->get('position') == 'left' && $params->get('type_show') == 'vertical'){ ?>

					$('#<?php echo $menu_id;?> .level-2').each(function(){
						if(!$(this).hasClass('mega-pinned')){
							var width = $(this).find('.sj-megamenu-child').eq(0).css('width');
							var obj  = $(this);
							if(parseInt(width) == 0){
								setTimeout(function(){
									width = obj.find('.sj-megamenu-child').eq(0).css('width');
									obj.find('.sj-megamenu-child').eq(0).css('position','absolute');
									obj.find('.sj-megamenu-child').eq(0).css('top','0px');
									obj.find('.sj-megamenu-child').eq(0).css('left','-'+width);
								},1000);
							}else{
								$(this).find('.sj-megamenu-child').eq(0).css('position','absolute');
								$(this).find('.sj-megamenu-child').eq(0).css('top','0px');
								$(this).find('.sj-megamenu-child').eq(0).css('left','-'+width);
							}
							
						}
					})
					$('#<?php echo $menu_id;?> .sj_mega_menu_vertical .level-1').each(function(){
						$(this).find('.submenu ').eq(0).append('<div style="clear:both"></div>');
							var width = $(this).find('.sj-megamenu-child').eq(0).css('width');

							$(this).find('.sj-megamenu-child').eq(0).css('position','absolute');
							$(this).find('.sj-megamenu-child').eq(0).css('top','0px');
							$(this).find('.sj-megamenu-child').eq(0).css('left','-'+width);
						
					})


		<?php } ?>
	}else{
		$('#<?php echo $menu_id;?> .sj_mega_menu_vertical .level-1').click(function(){
			if($(this).hasClass('so_slide_up')){
				$(this).removeClass('so_slide_up');
				$(this).find('.submenu').slideUp();
			}else{
				$(this).addClass('so_slide_up');
				$(this).find('.submenu').slideDown();
			}
		})
		$('#<?php echo $menu_id;?> .sj_mega_menu_vertical .level-1.parent ').each(function(){
			var html = $(this).find('a').eq(0).html();
			$(this).find('a').eq(0).remove();
			$(this).prepend('<a href="#">'+html+'</a>');
		})
	}
	})
</script>
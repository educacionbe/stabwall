<?php 
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2014 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="cpanel_wrapper" class="hidden-sm hidden-xs">
    <div class="accordion" id="ytcpanel_accordion">
        <div class="cpanel-head">
			Template Settings
			<div class="cpanel-reset">
				<a class="btn btn-info" href="#" onclick="javascript: onCPResetDefault(TMPL_COOKIE);" ><i class="fa fa-refresh fa-spin"></i> Reset</a>
			</div>
		</div>
		
    	<!--Body-->
        <div class="cpanel-theme">
			<!-- Style Color -->
			<div class="panel-group">
				<h4 class="panel-heading">Theme Colors</h4>
			  
				<div class="panel-theme-color">
					<span  title="Default" class="theme-color default<?php echo ($templateColor=='default')?' active':'';?>">Default</span>
					<span  title="Blue"    class="theme-color blue<?php echo ($templateColor=='blue')?' active':'';?>">Blue</span>
					<span  title="Red"     class="theme-color red<?php echo ($templateColor=='red')?' active':'';?>">Red</span>
					<span  title="Green"   class="theme-color green<?php echo ($templateColor=='green')?' active':'';?>">Green</span>
					<span  title="Pink"    class="theme-color pink<?php echo ($templateColor=='pink')?' active':'';?>">Pink</span>
				</div>
			</div>
			
			<!--<div class="panel-group">
					<h4 class="panel-heading">Background Color</h4>
					<div class="link-color">
						<input type="text" value="<?php //echo $yt->getParam('linkcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_linkcolor" maxlength="7">
					</div>
			</div>
	
			<div class="panel-group visible-lg">
				<h4 class="panel-heading">Layout</h4>
				
				<div class="panel-layout typeLayout">
					<span data-value="layout-wide" title="layout-wide"   class="layout-item btn <?php //echo ($typelayout=='wide')?' active':'';?>">Wide</span>
					<span data-value="layout-boxed" title="layout-boxed" class="layout-item btn <?php //echo ($typelayout=='boxed')?' active':'';?>">Boxed</span>
					<span data-value="layout-framed" title="layout-framed"  class="layout-item btn <?php //echo ($typelayout=='framed')?' active':'';?>">Framed</span>
					<span data-value="layout-rounded" title="layout-rounded" class="layout-item btn <?php //echo ($typelayout=='rounded')?' active':'';?>">Rounded</span>
				</div>
			</div>
			
			<div class="panel-group nomarginbottom visible-lg">
				<div class="panel-desc" style="margin:10px 0 3px;"> Patterns for Layour: Boxed, Framed, Rounded </div>
				<div class="body-bg">
				<?php
				
				//$path = JPATH_ROOT.'/templates/'.$yt->template.'/images/pattern/body';
				//$files = JFolder::files($path, '.'); 
				//foreach($files as $file) {
					//$file = JFile::stripExt($file); ?>
					<a href="#"  title="<?php //echo $file; ?>" class="pattern <?php //echo $file; ?><?php //echo ($yt->getParam('bgbox')==$file)?' active':''?>"><?php //echo $file; ?></a>
					<?php
				//}
				?>
				</div>
				<input type="hidden" name="ytcpanel_bgimage" value="<?php //echo $yt->getParam('bgbox'); ?>"/>
					
			</div>-->
			
        </div>
        
    </div>
    <div id="cpanel_btn" class="isDown"><i class="fa fa-wrench"></i></div>
	
</div>
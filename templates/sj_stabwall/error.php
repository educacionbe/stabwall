<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//get copyright
$app = JFactory::getApplication();
$date		= JFactory::getDate();
$template = $app->getTemplate(true);
$params = $template->params;
$cur_year	= $date->format('Y');
$ytcopyright = $params->get('ytcopyright' );
$ytcopyright = str_replace('{year}', $cur_year, $ytcopyright);


//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
?>

<html  lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="HandheldFriendly" content="true">

	<link rel="stylesheet" href="<?php echo $this->baseurl.'/templates/'.$this->template; ?>/asset/fonts/font-awesome-4.4.0/css/font-awesome.css" type="text/css" />	

	<link rel="stylesheet" href="<?php echo $this->baseurl.'/templates/'.$this->template; ?>/asset/bootstrap/css/bootstrap.min.css" type="text/css" />	
	<link rel="stylesheet" href="<?php echo $this->baseurl.'/templates/'.$this->template; ?>/css/error.css" type="text/css" />	
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="wrapall">
		<div class="wrap-inner">
			<div class="contener">
				<h1 class="text-header"><?PHP echo JText::_('DONT_WORRY_YOU_WILL_BE_BACK_ON_TRACK_IN_NO_TIME'); ?></h1>
				<img class="img_404" src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate();?>/images/404/404.png" alt="" />
				<div class="mess-code"><?php echo $this->error->getMessage(); ?></div>
				<div class="text-please">
					<p>	
						<span><?php echo JText::_("PAGE_DOESNT_EXIT_OR_SOME_OTHER_ERROR_OCCURED_GO_TO_OUR");?></span>
						<?php //echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?>
						<a class="" href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
							<?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?>
						</a>
						<?php echo JText::_("OR_GO_BACK_TO");?></span>
						<a class="" href="javascript:history.go(-1)" title="<?php echo JText::_('JERROR_LAYOUT_PREVIOUS_PAGE'); ?>">
							<?php echo JText::_('JERROR_LAYOUT_PREVIOUS_PAGE'); ?>
						</a>
					</p>
				</div>
				<?php
					echo $doc->getBuffer('modules', 'top11', array('style' => 'none'));
				?>
			</div>
		</div>
	</div>	
</body>
</html>

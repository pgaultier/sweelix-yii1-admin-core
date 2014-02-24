<?php
/**
 * File login.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.core.views.layouts
 */

Yii::app()->getClientScript()->registerSweelixScript('callback');
$sweeftModule = Yii::app()->getModule('sweeft');
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
		<?php Yii::app()->getClientScript()->registerCoreScript('jquery.ui'); ?>
		<?php Yii::app()->getClientScript()->registerCoreScript('cookie'); ?>

		<title><?php echo Yii::app()->name; ?></title>

		<!--[if lte IE 7]><script type="text/javascript" src="<?php echo $sweeftModule->getAssetsUrl(); ?>/js/lte-ie7.js"></script><![endif]-->
		<!--[if lte IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="<?php echo $sweeftModule->getAssetsUrl(); ?>/js/jquery.mjs.nestedSortable.js"></script>
		<script type="text/javascript" src="<?php echo $sweeftModule->getAssetsUrl(); ?>/js/jquery.chosen.js"></script>

		<link rel="stylesheet" type="text/css" href="<?php echo $sweeftModule->getAssetsUrl(); ?>/css/chosen.css" media="screen" />
		<?php Yii::app()->clientScript->registerLessFile('sweelix.less'); ?>
		<!-- link rel="stylesheet/less" type="text/css" href="<?php echo $sweeftModule->getAssetsUrl(); ?>/css/sweelix.less" / -->

		<!-- script type="text/javascript" src="<?php echo $sweeftModule->getAssetsUrl(); ?>/js/less-1.3.1.min.js"></script -->

		<link rel="icon" type="image/png" href="<?php echo $sweeftModule->getAssetsUrl(); ?>/img/favicon.png" />
		<!--[if IE]>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $sweeftModule->getAssetsUrl(); ?>/img/favicon.ico" />
		<![endif]-->
		<script type="text/javascript">
			jQuery(document).ready(function(){
				var options = {
					allow_single_deselect : true,
					disable_search_threshold : 0,
					disable_search : false,
					disable_search_split_words : false,
					search_contains: false,
					single_backstroke_delete:true,
					placeholder_text:'Sélectionnez une option',
					no_results_text:'Aucun résultat trouvé pour '
				};
				jQuery('select').chosen(options);
			});
		</script>
	</head>
	<body>
		<header>
			<?php $this->beginWidget('sweelix\yii1\admin\core\widgets\Header'); ?>
			<div class="top-bar">
				<span class="text">
					Sweelix - <?php echo Yii::app()->name; ?>
				</span>
			</div>
			<?php $this->endWidget(); ?>
			<?php $this->widget('sweelix\yii1\admin\core\widgets\MainMenu'); ?>
		</header>
		<section id="main" class="login">
			<?php echo $content; ?>
		</section>
		<footer>
			<div class="bottom-bar">
				<span>Sweelix [<?php echo $sweeftModule->getVersion(); ?>]</span><br/>
				Copyright &copy; 2010-<?php echo date('Y'); ?> <a href="http://www.sweelix.net">www.sweelix.net</a>
			</div>
		</footer>
	</body>
</html>
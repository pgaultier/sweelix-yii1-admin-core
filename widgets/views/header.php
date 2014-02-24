<?php
/**
 * File header.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.core.widgets.views
 */
use sweelix\yii1\web\helpers\Html;
?>

<div class="top-bar">
	<?php echo Html::link(
		Yii::t('sweelix', 'Disconnect'),
		array('/sweeft/authentication/logout'),
		array(
			'title' => Yii::t('sweelix', 'Disconnect'),
			'class' => 'icon-power light',
		)
	); ?>
	<span class="text">
		<?php echo Yii::t('sweelix', 'Connected as {firstname} {lastname}', array('{firstname}' =>Yii::app()->user->firstName, '{lastname}' =>Yii::app()->user->lastName)) ?>
		-
		<?php echo Yii::t('sweelix', 'Last connection {date}', array('{date}' => Yii::app()->user->lastLogin)); ?>
	</span>
</div>

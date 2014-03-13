<?php
/**
 * File login.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.0
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.core.views.authentication
 */
use sweelix\yii1\web\helpers\Html;
?>

<fieldset>
	<legend><?php echo Yii::app()->name; ?></legend>
	<?php echo Html::activeLabel($author, 'authorEmail');?><br/>
	<?php echo Html::activeTextField($author, 'authorEmail', array('class' => 'classic'));?><br/>
	<?php echo Html::activeLabel($author, 'authorPassword');?><br/>
	<?php echo Html::activePasswordField($author, 'authorPassword', array('class' => 'classic'));?><br/>
	<?php echo Html::activeCheckBox($author, 'authorAutoLogin');?>
	<?php echo Html::activeLabel($author, 'authorAutoLogin');?><br/>
	<?php echo Html::htmlButton(Yii::t('sweelix', 'Reset'), array('type' => 'reset', 'class' => 'medium danger'));?>
	<?php echo Html::htmlButton(Yii::t('sweelix', 'Ok'), array('type' => 'submit', 'class' => 'medium success'));?>
</fieldset>

<?php
/**
 * File _login.php
 *
 * PHP version 5.2+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2013 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweeft.views.authentication
 */

?>

<fieldset>
	<legend><?php echo Yii::app()->name; ?></legend>
	<?php echo Sweeml::activeLabel($author, 'authorEmail');?><br/>
	<?php echo Sweeml::activeTextField($author, 'authorEmail', array('class' => 'classic'));?><br/>
	<?php echo Sweeml::activeLabel($author, 'authorPassword');?><br/>
	<?php echo Sweeml::activePasswordField($author, 'authorPassword', array('class' => 'classic'));?><br/>
	<?php echo Sweeml::activeCheckBox($author, 'authorAutoLogin');?>
	<?php echo Sweeml::activeLabel($author, 'authorAutoLogin');?><br/>
	<?php echo Sweeml::htmlButton(Yii::t('sweelix', 'Reset'), array('type' => 'reset', 'class' => 'medium danger'));?>
	<?php echo Sweeml::htmlButton(Yii::t('sweelix', 'Ok'), array('type' => 'submit', 'class' => 'medium success'));?>

</fieldset>

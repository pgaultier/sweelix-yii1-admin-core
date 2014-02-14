<?php
/**
 * File login.php
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

<?php echo Sweeml::beginAjaxForm('', 'post', array('autocomplete'=>'off')); ?>
	<?php $this->renderPartial('_login', array('author'=>$author)); ?>
<?php echo Sweeml::endForm(); ?>

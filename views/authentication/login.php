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
 * @package   sweelix.yii1.admin.views.authentication
 */
use sweelix\yii1\web\helpers\Html;
?>

<?php echo Html::beginAjaxForm('', 'post', array('autocomplete'=>'off')); ?>
	<?php $this->renderPartial('_login', array('author'=>$author)); ?>
<?php echo Html::endForm(); ?>

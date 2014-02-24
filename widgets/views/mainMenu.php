<?php
/**
 * File mainMenu.php
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
<ul>
	<?php foreach($modules as $module):?>
	<?php echo Html::openTag('li', $module['htmlOptions'], null, false); ?>
		<?php echo Html::link(
					(($module['hasIcon'] === true)?Sweeml::tag('i', array('class' => 'module-'.$module['name']), null, true).' ':'').
					$module['title'],
					$module['link'],
					array('title' => $module['title'])
		); ?>
	<?php echo Html::closeTag('li');?>
	<?php endforeach;?>
</ul>

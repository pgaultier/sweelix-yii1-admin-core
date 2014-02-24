<?php
/**
 * File breadcrumb.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.base.widgets.views
 */
use sweelix\yii1\web\helpers\Html;
?>
<?php echo Html::openTag('aside', $htmlOptions); ?>
	<ul>
		<li>
			<?php echo Html::tag('span', array('class' => 'light '.$icon), null, true);?>
		</li>
	<?php foreach($elements as $element): ?>
		<li>
			<span class="light icon-arrow-right"></span>
			<?php if(isset($element['url']) === true): ?>
				<?php echo Html::link($element['content'], $element['url'], $element['htmlOptions']); ?>
			<?php else: ?>
				<?php echo Html::tag('span', $element['htmlOptions'], $element['content'], true); ?>
			<?php endif; ?>
		</li>
	<?php endforeach;?>
	</ul>
<?php echo Html::closeTag('aside'); ?>

<?php
/**
 * File table.php
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

$count = count($fields);
$newFields = array();
foreach($fields as $key => $value) {
	if(is_array($value) === false) {
		$key = $value;
		$value = array();
	}
	$newFields[$key] = $value;
}
$fields = $newFields;
?>
<?php echo Html::openTag('table', $htmlOptions); ?>
	<thead>
		<?php if($title === null): ?>
		<tr>
			<?php foreach($fields as $field => $options): ?>
			<?php echo Html::openTag('th', isset($options['htmlOptions']) ? $options['htmlOptions'] : array()); ?>
				<?php echo $activeDataProvider->model->attributeLabels[$field]; ?>
			<?php echo Html::closeTag('td'); ?>
			<?php endforeach; ?>
		</tr>
		<?php else: ?>
		<tr>
			<?php echo Html::tag('th', array('colspan' => count($fields)), \Yii::t($catalog, $title, $activeDataProvider->totalItemCount)); ?>
		</tr>
		<tr>
			<?php foreach($fields as $field => $options): ?>
			<?php echo Html::openTag('td', isset($options['htmlOptions']) ? $options['htmlOptions'] : array()); ?>
				<?php echo $activeDataProvider->model->getAttributeLabel($field); ?>
			<?php echo Html::closeTag('td'); ?>
			<?php endforeach; ?>
		</tr>
		<?php endif; ?>
	</thead>
	<tbody>
		<?php foreach($activeDataProvider->getData() as $data) :?>
		<tr>
			<?php foreach($fields as $field => $options):?>
			<?php echo Html::openTag('td', isset($options['htmlOptions']) ? $options['htmlOptions'] : array()); ?>
				<?php echo $data->{$field}; ?>
			<?php echo Html::closeTag('td'); ?>
			<?php endforeach;?>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<?php if($pagination === false): ?>
			<tr><?php echo Html::tag('th', array('colspan' => count($fields)), '&nbsp;'); ?></tr>
		<?php else: ?>
		<?php endif; ?>
	</tfoot>
<?php echo Html::closeTag('table'); ?>
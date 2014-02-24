<?php
/**
 * File contextMenu.php
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

$mainMenuOptions = $this->htmlOptions;
$secondaryMenuOptions = $this->htmlOptions;
if(isset($this->htmlOptions['class']) === true) {
	$mainMenuOptions['class'] = $mainMenuOptions['class'].' menu';
	$secondaryMenuOptions['class'] = $secondaryMenuOptions['class'].' menu submenu';
} else {
	$mainMenuOptions['class'] = 'menu';
	$secondaryMenuOptions['class'] = 'menu submenu';
}
?>

<?php echo Html::openTag('ul', $mainMenuOptions); ?>
	<?php foreach($mainMenu as $element): ?>
		<?php echo Html::openTag('li', array('class' => ( (isset($element['active']) && ($element['active'] === true))?'active':''))); ?>
			<?php if(isset($element['url']) === true): ?>
				<?php echo Html::link($element['content'], $element['url'], $element['htmlOptions']); ?>
			<?php else: ?>
				<?php echo Html::tag('span', $element['htmlOptions'], $element['content'], true); ?>
			<?php endif; ?>
		<?php echo Html::closeTag('li'); ?>
	<?php endforeach;?>
<?php echo Html::closeTag('ul'); ?>

<?php if($secondaryMenu !== null) :?>
	<?php echo Html::openTag('ul', $secondaryMenuOptions); ?>
		<?php foreach($secondaryMenu as $element): ?>
			<?php echo Html::openTag('li', array('class' => ( (isset($element['active']) && ($element['active'] === true))?'active':''))); ?>
				<?php if(isset($element['url']) === true): ?>
					<?php echo Html::link($element['content'], $element['url'], $element['htmlOptions']); ?>
				<?php else: ?>
					<?php echo Html::tag('span', $element['htmlOptions'], $element['content'], true); ?>
				<?php endif; ?>
			<?php echo Html::closeTag('li'); ?>
		<?php endforeach;?>
	<?php echo Html::closeTag('ul'); ?>
<?php endif;?>
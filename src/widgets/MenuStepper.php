<?php
/**
 * File MenuStepper.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */

namespace sweelix\yii1\admin\core\widgets;

use sweelix\yii1\web\helpers\Html;
use CWidget;
use Yii;

/**
 * Class MenuStepper
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */
class MenuStepper extends CWidget {

	private $_stepperInfo;
	public $elementId;
	public $elementKey;
	/**
	 * @var integer current step id
	 */
	public $step = 0;
	/**
	 * @var integer number of steps in current stepper
	 */
	public $steps;

	/**
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function init() {
		Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		if($this->steps === null) {
			$this->steps = $this->step;
		}
		$this->_stepperInfo = array(
			'header' => Yii::t('sweelix', 'Create new {element}', array('{element}'=>$this->controller->id)),
			'title' => Yii::t('sweelix', ucfirst($this->controller->id)),
			'class' => $this->controller->id.'Element',
		);
	}

	/**
	 * Render widget
	 * Called by CController::endWidget()
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function run() {
		Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		echo Html::tag('ul',
			array('id'=>'breadcrumb'),
			Html::tag('li',array(),
				Html::tag('span', array(), $this->_stepperInfo['header'])
			)
		)."\n";
		echo Html::tag('h3', array(), Yii::t('sweelix', 'Step {n}', array('{n}' => $this->step )))."\n";
		echo Html::tag('ul',
			array('id'=>'appMenu'),
			Html::tag('li',array('class' =>  $this->_stepperInfo['class'].' selected'),
				Html::tag('span', array(), $this->_stepperInfo['title'])
			)
		)."\n";
		echo Html::tag('ul', array('id'=>'editMenu'), null, false)."\n";
		for($i=1; $i<$this->step; $i++) {
			if(($this->elementKey === null) || ($this->elementId === null)) {
				$url = array( 'step'.$i);
			} else {
				$url = array( 'step'.$i, $this->elementKey=>$this->elementId);
			}
			echo Html::tag('li',array(),Html::link(
				Yii::t('sweelix', 'Step {n}', array('{n}' => $i )),
				$url,
				array(
					'class' => ($i==$this->step)?'selected':'',
					'title' => Yii::t('sweelix', 'Step {n}', array('{n}' => $i )),
				)
			))."\n";
		}
		for($i=$this->step; $i<=$this->steps; $i++) {
			echo Html::tag('li',array(),Html::tag('span',
				array(
					'class' => ($i==$this->step)?'selected':'',
					'title' => Yii::t('sweelix', 'Step {n}', array('{n}' => $i )),
				),
				Yii::t('sweelix', 'Step {n}', array('{n}' => $i ))
			))."\n";
		}
		echo Html::closeTag('ul');
	}
}

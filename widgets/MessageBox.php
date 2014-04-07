<?php
/**
 * File MessageBox.php
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

/**
 * Class MessageBox
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */
class MessageBox extends \CWidget {
	public $message;
	public $type = 'info';
	public $objects;
	private $_errorMessage;
	public $displayMessage;
	/**
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function init() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		ob_start();
		if($this->objects !== null) {
			if(is_array($this->objects) === false) {
				$this->objects = array($this->objects);
			}
			$errorMessage = null;
			foreach($this->objects as $object) {
				foreach($object->getErrors() as $errors) {
					foreach($errors as $error) {
						$errorMessage .= Html::tag('li', array(), $error).' ';
					}
				}
			}
			if($errorMessage !== null) {
				$this->_errorMessage = Html::tag('ul', array(), $errorMessage).' ';;
				$this->type = 'error';
			}
		}
	}

	/**
	 * Render widget
	 * Called by CController::endWidget()
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function run() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		$content=ob_get_contents();
		ob_end_clean();
		if(strlen($content) > 0) {
			$this->message = $content;
		}
		if($this->_errorMessage !== null) {
			$this->message = $this->message.' '.$this->_errorMessage;
		}
		if(strlen($this->message)>0) {
			$this->message = str_replace(array("\r\n", "\n", "\r"), array(' ', ' ', ' '), $this->message);
			$message = array(
				'type' => $this->type,
				'message' => $this->message,
				'close' => \Yii::t('sweelix', 'Close')
			);
			switch($this->type) {
				case 'valid' :
					$message['title'] = \Yii::t('sweelix', 'Confirmation');
					break;
				case 'warning' :
					$message['title'] = \Yii::t('sweelix', 'Warning');
					break;
				case 'error' :
					$message['title'] = \Yii::t('sweelix', 'Error');
					break;
				case 'info' :
					$message['title'] = \Yii::t('sweelix', 'Information');
					break;
			}
			$js = Html::raiseEvent('showMessageBox', array(
					'type' => $this->type,
					'message' => $this->message,
			));
			if(\Yii::app()->getRequest()->isAjaxRequest === false) {
				\Yii::app()->getClientScript()->registerSweelixScript('callback');
				if($this->displayMessage === true)
					\Yii::app()->getClientScript()->registerScript('messageBoxDetail', $js);
			} else {
				if($this->displayMessage === true)
					echo Html::script($js);
			}
		}
	}
}

<?php
/**
 * File ElasticForm.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 */

namespace sweelix\yii1\admin\core\components;
use sweelix\yii1\ext\entities\Node;
use sweelix\yii1\ext\entities\Content;
use sweelix\yii1\ext\entities\Group;
use sweelix\yii1\ext\entities\Tag;
use sweelix\yii1\web\helpers\Html;

/**
 * Class ElasticForm
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 * @since     2.0.0
 */
class ElasticForm extends \CComponent {
	/**
	 * @var The model associated with current form
	 */
	private $_model;
	/**
	 * @var string separator added between elements
	 */
	public $separator = "<br/>\n";
	/**
	 * Model used to handle the form
	 *
	 * @return ElasticModel
	 * @since  1.0.0
	 */
	public function getModel() {
		return $this->_model;
	}
	/**
	 * @var array elements in the form
	 */
	private $_elements = array();
	/**
	 * Constructor, create the dynamic form using
	 * array or file config or dynamic model
	 *
	 * @param mixed $config file / array configuration / ElasticModel
	 *
	 * @return void
	 */
	public function __construct($model) {
		$this->_model = $model;
		$this->configure();
	}
	/**
	 * Add new element to the dynamic form
	 *
	 * @param array $elementConfig configuration array
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function addElement($elementConfig) {
		$this->_elements[] = new ElasticFormElement($elementConfig, $this->_model);
	}
	/**
	 * Parse configuration and create elements
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function configure() {
		foreach($this->_model->getTemplateConfig() as $elementName => $elementConfig) {
			if($elementName === 'separator') {
				$this->separator = $elementConfig;
			} else {
				if(isset($elementConfig['element']) === true) {
					$elementConfig = $elementConfig['element'];
				}
				if(isset($elementConfig['name']) === false) {
					$elementConfig['name'] = $elementName;
				}
				$this->addElement($elementConfig);
			}
		}
	}
	/**
	 * Draw the form and produce html
	 *
	 * @param boolean $return if true, return the html else write the html
	 *
	 * @return mixed
	 * @since  1.0.0
	 */
	public function render($return=true) {
		$result = '';
		foreach($this->_elements as $el) {
			$result = $result.$el->render().$this->separator;
		}
		if($return === true) {
			return $result;
		} else {
			echo $result;
			return true;
		}
	}
	/**
	 * Render the html
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function __toString() {
		return $this->render();
	}
}
/**
 *
 * Class ElasticFormElement
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 * @since     1.2.0
 */
class ElasticFormElement extends \CComponent {
	/**
	 * Supported field types
	 *
	 * @var array
	 */
	public static $coreTypes=array(
		'text'=>'activeTextField',
		'hidden'=>'activeHiddenField',
		'password'=>'activePasswordField',
		'textarea'=>'activeTextArea',
		'asyncfile' => 'activeAsyncFileUpload',
		'radio'=>'activeRadioButton',
		'checkbox'=>'activeCheckBox',
		'listbox'=>'activeListBox',
		'dropdownlist'=>'activeDropDownList',
		'checkboxlist'=>'activeCheckBoxList',
		'radiolist'=>'activeRadioButtonList',
	);
	private $_layout = "{label}<br/>{element} \n";
	private $_label;
	private $_element;
	/**
	 * Create an element using the dynamic model and config array
	 *
	 * @param array          $config configuration for current element
	 * @param ElasticModel $model  model used to produce the form
	 *
	 * @return ElasticFormElement
	 * @since  1.0.0
	 */
	public function __construct($config, $model) {
		$this->configure($config, $model);
	}
	/**
	 * Create an element using the dynamic model and config array
	 *
	 * @param array        $config configuration for current element
	 * @param ElasticModel $model  model used to produce the form
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function configure($config, $model) {
		$type = $config['type'];
		unset($config['type']);
		if(isset(self::$coreTypes[$type])) {
			$method=self::$coreTypes[$type];
			$name = $config['name'];
			unset($config['name']);
			if(isset($config['layout']) === true) {
				$this->_layout = $config['layout'];
				unset($config['layout']);
			}
			$labelOptions = array();
			if(isset($config['labelOptions']) === true) {
				$labelOptions = $config['labelOptions'];
				unset($config['labelOptions']);
			}
			$this->_label = Html::activeLabel($model, $name, $labelOptions);

			if(strpos($method,'List')!==false) {
				if(isset($config['listData']) === true) {
					$listData = $config['listData'];
					unset($config['listData']);
				}
				$this->_element = Html::$method($model, $name, $listData, $config);
			} else {
				if($method == 'activeAsyncFileUpload') {
					if(\Yii::app()->getRequest()->isAjaxRequest === false) {
						\Yii::app()->getClientScript()->registerScriptFile(\Yii::app()->getModule('sweeft')->getAssetsUrl().'/js/jquery.sweeftloader.js');
					}
					if(isset($config['config']['ui']) === false) {
						$config['config']['ui'] = 'js:new SweeftUploader()';
					}
					if(isset($config['config']['auto']) === false) {
						$config['config']['auto'] = true;
					}
					if(isset($config['config']['runtimes']) === false) {
						$config['config']['runtimes'] = 'html5, flash';
					}
					if(isset($config['config']['urlPreview']) && is_array($config['config']['urlPreview'])) {
						if($model->getOwner() instanceof Content) {
							$config['config']['urlPreview']['contentId'] = $model->getOwner()->contentId;
							$config['config']['urlPreview']['nodeId'] = $model->getOwner()->nodeId;
						} elseif($model->getOwner() instanceof Node) {
							$config['config']['urlPreview']['nodeId'] = $model->getOwner()->nodeId;
						} elseif($model->getOwner() instanceof Tag) {
							$config['config']['urlPreview']['tagId'] = $model->getOwner()->tagId;
							$config['config']['urlPreview']['groupId'] = $model->getOwner()->groupId;
						} elseif($model->getOwner() instanceof Group) {
							$config['config']['urlPreview']['groupId'] = $model->getOwner()->groupId;
						}
					}
				}
				$this->_element = Html::$method($model, $name, $config);
			}
		}
	}
	/**
	 * Render the html
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function __toString() {
		return $this->render();
	}
	/**
	 * Draw the element form and produce html
	 *
	 * @param boolean $return if true, return the html else write the html
	 *
	 * @return mixed
	 * @since  1.0.0
	 */
	public function render($return=true) {
		$rendered = str_replace(array('{label}', '{element}'), array($this->_label, $this->_element), $this->_layout);
		if($return === true) {
			return $rendered;
		} else {
			echo $rendered;
			return true;
		}
	}
}






<?php
/**
 * File Table.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */

namespace sweelix\yii1\admin\core\widgets;

/**
 * Class Table
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */
class Table extends \CWidget {

	private $_moduleName;
	/**
	 * Get module name
	 *
	 * @return string
	 * @since  1.2.0
	 */
	public function getModuleName() {
		if($this->_moduleName === null) {
			$this->_moduleName=basename($this->getController()->getModule()->getId());
		}
		return $this->_moduleName;
	}

	/**
	 * @var CActiveDataProvider
	 */
	public $activeDataProvider;

	/**
	 * @var string table title
	 */
	public $title;

	public $enablePagination=false;

	public $hideOnEmpty=false;

	public $htmlOptions=array();

	private $_fields;
	/**
	 * Set fields
	 *
	 * @param array $fields
	 *
	 * @return void
	 * @since  2.0.0
	 */
	public function setFields($fields) {
		$this->_fields = $fields;
	}

	/**
	 * Get fields to display
	 *
	 * @return array
	 * @since  2.0.0
	 */
	public function getFields() {
		if($this->_fields === null) {
			$this->_fields = $this->activeDataProvider->model->attributeNames();
		}
		return $this->_fields;
	}

	/**
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  2.0.0
	 */
	public function init() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		ob_start();
	}

	/**
	 * Render widget
	 * Called by CController::endWidget()
	 *
	 * @return void
	 * @since  2.0.0
	 */
	public function run() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		$contents=ob_get_contents();
		ob_end_clean();
		if($this->activeDataProvider === null) {
			echo $contents;
		} else {
			if(($this->hideOnEmpty === true) && ($this->activeDataProvider->totalItemCount == 0)) {
				echo $contents;
			} else {
				$this->render('TableWidget', array(
					'activeDataProvider' => $this->activeDataProvider,
					'fields' => $this->getFields(),
					'title' => $this->title,
					'pagination' => $this->enablePagination,
					'catalog' => $this->getCatalog(),
					'htmlOptions' => $this->htmlOptions,
				));
			}
		}
	}

	private $_catalog;
	/**
	 * Force localisation catalog
	 *
	 * @param string $catalog string to access the catalog
	 *
	 * @return void
	 * @since  2.0.0
	 */
	public function setCatalog($catalog) {
		$this->_catalog = $catalog;
	}
	/**
	 * Check if we are in current menu
	 *
	 * @param mixed $target target link
	 *
	 * @return string
	 * @since  2.0.0
	 */
	public function getCatalog() {
		if($this->_catalog === null) {
			$this->_catalog = ucfirst($this->getModuleName()).'Module.sweelix';
		}
		return $this->_catalog;
	}
}

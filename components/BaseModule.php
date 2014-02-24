<?php
/**
 * File BaseModule.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 */

namespace sweelix\yii1\admin\core\components;

/**
 * Class BaseModule
 *
 * Every sub module should extend this module.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 * @since     XXX
 */
class BaseModule extends \CWebModule {
	protected $basePath;
	private $_assetsUrl;
	private $_assetsPath;

	private $_layoutPath;
	/**
	 * Return correct layout path to inherit sweeft module path
	 * @see CWebModule::getLayoutPath()
	 *
	 * @return string
	 * @since  1.2.0
	 */
	public function getLayoutPath() {
		if($this->_layoutPath!==null)
			return $this->_layoutPath;
		else
			return $this->_layoutPath=$this->getParentModule()->getLayoutPath();
	}
	/**
	 * Return module version
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function getVersion() {
		return $this->getParentModule()->getVersion();
	}


	/**
	 * Return current asset path.
	 *
	 * @return string
	 * @since  2.0.0
	 */
	public function getAssetsPath() {
		if($this->_assetsPath === null) {
			$this->_assetsPath = $this->basePath.DIRECTORY_SEPARATOR.'assets';
		}
		return $this->_assetsPath;
	}

	/**
	 * Everything is embedded in the module. We have to publish elements
	 * and to retrieve path of elements
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function getAssetsUrl() {
		if(($this->_assetsUrl === null) && ($this->basePath !== null)) {
			$this->_assetsUrl = \Yii::app()->getAssetManager()->publish($this->getAssetsPath());
		}
		return $this->_assetsUrl;
	}

	/**
	 * We can override assets url
	 *
	 * @param string $value assets url
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function setAssetsUrl($value) {
		$this->_assetsUrl=$value;
	}

	/**
	 * register scripts for current module.
	 * Default implementation register module.js
	 *
	 * @return void
	 * @since  2.0.0
	 */
	public function registerScripts() {
		if(file_exists($this->getAssetsPath().DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'module.js') === true) {
			\Yii::app()->getClientScript()->registerScriptFile($this->getAssetsUrl().'/js/module.js');
		}
	}
}

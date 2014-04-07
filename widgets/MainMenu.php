<?php
/**
 * File MainMenu.php
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

/**
 * Class MainMenu
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */
class MainMenu extends \CWidget {

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
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  1.2.0
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
	 * @since  1.2.0
	 */
	public function run() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		$contents=ob_get_contents();
		ob_end_clean();
		if(\Yii::app()->user->isGuest === true) {
			echo $contents;
		} else {
			$currentMessageInstance = clone \Yii::app()->getMessages();
			$modules = array();
			foreach(\Yii::app()->getModule('sweeft')->getModules() as $name => $module) {
				//check wheither the user is allowed to access the module
				if(\Yii::app()->user->checkAccess($name)){
					$hasIcon = false;
					$moduleInstance = \Yii::createComponent($module, $name, 'sweeft');
					$moduleAssetsPath = $moduleInstance->getAssetsPath();
					if(file_exists($moduleAssetsPath.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'module.css') === true) {
						$assetPath = \Yii::app()->getAssetManager()->publish($moduleAssetsPath);
						\Yii::app()->getClientScript()->registerCssFile($assetPath.'/css/module.css');
						$hasIcon = true;
					}
					//TODO: fix the translation system to force the module to translate himself
					$modules[] = array(
						'htmlOptions' => array(
							'class' => $this->isSelected($name),
						),
						'link' => array('/sweeft/'.$name),
						// 'title' => \Yii::t(get_class($moduleInstance).'.sweelix',  ucfirst($name)),
						'title' => $moduleInstance->getTitle(),
						'name' => $name,
						'hasIcon' => $hasIcon,
					);
					unset($moduleInstance);
				}
			}
			\Yii::app()->setComponent('messages', $currentMessageInstance);

			$this->render('mainMenu', ['modules' => $modules]);
		}
	}

	/**
	 * Check if we are in current menu
	 *
	 * @param mixed $target target link
	 *
	 * @return string
	 * @since  1.2.0
	 */
	public function isSelected($target) {
		if($this->getModuleName() === $target) {
			return 'active';
		} else {
			return '';
		}
	}
}

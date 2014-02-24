<?php
/**
 * File DefaultController.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  controllers
 * @package   sweelix.yii1.admin.core.controllers
 */

namespace sweelix\yii1\admin\core\controllers;
use sweelix\yii1\admin\core\web\Controller;

/**
 * Class DefaultController
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  controllers
 * @package   sweelix.yii1.admin.core.controllers
 */
class DefaultController extends Controller {

	/**
	 * Redirect the user to first module available
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function actionIndex() {
		try {
			\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.controllers');
			$appModules = $this->getModule()->getModules();
			$targetModule = null;
			foreach($appModules as $moduleName => $moduleConfig) {
				if(\Yii::app()->user->checkAccess($moduleName) === true) {
					$targetModule = $moduleName;
					break;
				}
			}
			if($targetModule !== null) {
				$this->redirect(array($targetModule.'/'));
			} else {
				\Yii::app()->user->logout();
				$this->redirect(array('authentication/'));
			}
		} catch(\Exception $e) {
			\Yii::log('Error in '.__METHOD__.'():'.$e->getMessage(), \CLogger::LEVEL_ERROR, 'sweelix.yii1.admin.core.controllers');
			throw $e;
		}
	}

	/**
	 * Define access rules / rbac stuff
	 *
	 * @return array
	 */
	public function accessRules() {
		return array(
				array(
					'deny', 'users'=>array('?'),
				),
		);
	}
}

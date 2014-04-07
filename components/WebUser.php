<?php
/**
 * File WebUser.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 */

namespace sweelix\yii1\admin\core\components;
use sweelix\yii1\web\helpers\Html;

/**
 * Class WebUser
 *
 * This component allow the user management for authentication
 * and authorization processes.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 * @since     3.0.0
 */
class WebUser extends \CWebUser {
	/**
	 * Get return url using modules parameters
	 * @see CWebUser::getReturnUrl()
	 *
	 * @return string
	 * @since  1.2.0
	 */
	public function getReturnUrl($defaultUrl=null) {
		$returnUrl = $this->getState('__returnUrl', null);
		if($returnUrl === null) {
			$returnUrl = array('default/');
		}
		return Html::normalizeUrl($returnUrl);
	}
}

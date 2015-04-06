<?php
/**
 * File Header.php
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

use CWidget;
use Yii;

/**
 * Class Header
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */
class Header extends CWidget {

	/**
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function init() {
		Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
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
		Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		$content = ob_get_contents();
		ob_end_clean();
		if(Yii::app()->user->isGuest === true) {
			echo $content;
		} else {
			$this->render('header');
		}
	}

}

<?php
/**
 * File ContextMenu.php
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

use CMap;
use CWidget;
use Yii;

/**
 * Class ContextMenu
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.core.widgets
 */
class ContextMenu extends CWidget {

	public $main;
	public $secondary;
	public $htmlOptions=array();
	/**
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  2.0.0
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
	 * @since  2.0.0
	 */
	public function run() {
		Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.widgets');
		$content = ob_get_contents();
		ob_end_clean();
		if($this->main === null) {
			echo $content;
		} else {
			$mainMenu = array();
			foreach($this->main as $element) {
				if(is_string($element)) $element = array('content' => $element);
				$mainMenu[] = CMap::mergeArray(array('content' => '', 'htmlOptions' => array()), $element);
			}
			$secondaryMenu = null;
			if($this->secondary !== null) {
				$secondaryMenu = array();
				foreach($this->secondary as $element) {
					if(is_string($element)) $element = array('content' => $element);
					$secondaryMenu[] = CMap::mergeArray(array('content' => '', 'htmlOptions' => array()), $element);
				}
			}


			$this->render('contextMenu', array(
				'htmlOptions' => $this->htmlOptions,
				'mainMenu' => $mainMenu,
				'secondaryMenu' => $secondaryMenu,
            ));
		}
	}
}

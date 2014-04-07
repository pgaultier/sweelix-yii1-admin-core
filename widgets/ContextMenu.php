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
class ContextMenu extends \CWidget {

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
		$content = ob_get_contents();
		ob_end_clean();
		if($this->main === null) {
			echo $content;
		} else {
			$mainMenu = [];
			foreach($this->main as $element) {
				if(is_string($element)) $element = ['content' => $element];
				$mainMenu[] = \CMap::mergeArray(['content' => '', 'htmlOptions' => []], $element);
			}
			$secondaryMenu = null;
			if($this->secondary !== null) {
				$secondaryMenu = [];
				foreach($this->secondary as $element) {
					if(is_string($element)) $element = ['content' => $element];
					$secondaryMenu[] = \CMap::mergeArray(['content' => '', 'htmlOptions' => []], $element);
				}
			}


			$this->render('contextMenu', [
				'htmlOptions' => $this->htmlOptions,
				'mainMenu' => $mainMenu,
				'secondaryMenu' => $secondaryMenu,
			]);
		}
	}
}

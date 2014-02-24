<?php
/**
 * File Breadcrumb.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.base.widgets
 */

namespace sweelix\yii1\admin\base\widgets;

/**
 * Class Breadcrumb
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  widgets
 * @package   sweelix.yii1.admin.base.widgets
 */
class Breadcrumb extends \CWidget {

	public $icon='icon-compass';
	public $elements;
	public $htmlOptions=[];

	/**
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  2.0.0
	 */
	public function init() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.base.widgets');
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
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.base.widgets');
		$content = ob_get_contents();
		ob_end_clean();
		if($this->elements === null) {
			echo $content;
		} else {
			$this->htmlOptions['id'] = $this->getId();
			$elements = [];
			foreach($this->elements as $element) {
				if(is_string($element)) $element = ['content' => $element];
				$elements[] = \CMap::mergeArray([
					'content' => '',
					'htmlOptions' => []
				], $element);
			}

			$this->render('breadcrumb', [
				'htmlOptions' => $this->htmlOptions,
				'elements' => $elements,
				'icon' => $this->icon,
			]);
		}
	}
}

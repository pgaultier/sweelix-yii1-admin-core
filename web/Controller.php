<?php
/**
 * File Controller.php
 *
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  web
 * @package   sweelix.yii1.admin.core.web
 */

namespace sweelix\yii1\admin\core\web;
use sweelix\yii1\web\helpers\Html;

/**
 * Class Controller
 *
 * This component embbed all methods common to all controllers.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  web
 * @package   sweelix.yii1.admin.core.web
 * @since     2.0.0
 *
 * @property Content $currentContent
 * @property Node    $currentNode
 * @property Tag     $currentTag
 * @property Group   $currentGroup
 */
class Controller extends \CController {

	/**
	 * @var Node current node in use
	 */
	private $_currentNode;

	/**
	 * Define current node in use
	 *
	 * @param Node $node node to set as default
	 *
	 * @return void
	 */
	public function setCurrentNode($node) {
		$this->_currentNode = $node;
	}

	/**
	 * Get current node in use
	 *
	 * @return Node
	 */
	public function getCurrentNode() {
		return $this->_currentNode;
	}


	/**
	 * @var Content current content in use
	 */
	private $_currentContent;

	/**
	 * Define current content in use
	 *
	 * @param Content $content content to set as default
	 *
	 * @return void
	 */
	public function setCurrentContent($content) {
		$this->_currentContent = $content;
	}

	/**
	 * Get current content in use
	 *
	 * @return Content
	 */
	public function getCurrentContent() {
		return $this->_currentContent;
	}

	/**
	 * @var Tag current content in use
	 */
	private $_currentTag;

	/**
	 * Define current tag in use
	 *
	 * @param Tag $tag tag to set as default
	 *
	 * @return void
	 */
	public function setCurrentTag($tag) {
		$this->_currentTag = $tag;
	}

	/**
	 * Get current tag in use
	 *
	 * @return Tag
	 */
	public function getCurrentTag() {
		return $this->_currentTag;
	}

	/**
	 * @var Group current group in use
	 */
	private $_currentGroup;

	/**
	 * Define current group in use
	 *
	 * @param Group $group group to set as default
	 *
	 * @return void
	 */
	public function setCurrentGroup($group) {
		$this->_currentGroup = $group;
	}

	/**
	 * Get current group in use
	 *
	 * @return Group
	 */
	public function getCurrentGroup() {
		return $this->_currentGroup;
	}

	/**
	 * attach rendering behaviors
	 * @see CController::behaviors()
	 *
	 * @return array
	 * @since  1.2.0
	 */
	public function behaviors() {
		return array('sweelix\yii1\behaviors\Render');
	}

	/**
	 * Allow easy redirect for classic *and* Ajax pages
	 *
	 * @param array   $url                  target url in yii format @see Html::normalizeUrl()
	 * @param boolean $terminate            end request after redirect
	 * @param integer $statusCode           http code used for redirect
	 * @param boolean $forceClassicRedirect redirect using http even if we are in an ajax request
	 *
	 * @return void
	 */
	public function redirect($url, $terminate=true, $statusCode=302, $forceClassicRedirect = false) {
		if((\Yii::app()->getRequest()->isAjaxRequest === true) && ($forceClassicRedirect === false)) {
			if(\Yii::app()->getRequest()->isJsRequest == true) {
				$this->renderJs(Html::raiseRedirect($url), $terminate);
			} else {
				$js = 'document.location.href = \''.\CHtml::normalizeUrl($url).'\';';
				echo \CHtml::script($js);
				if($terminate === true) {
					\Yii::app()->end();
				}
			}

		} else {
			parent::redirect($url, $terminate, $statusCode);
		}
	}
}
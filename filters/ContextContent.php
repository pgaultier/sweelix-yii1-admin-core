<?php
/**
 * File ContextContent.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  filters
 * @package   sweelix.yii1.admin.core.filters
 */

namespace sweelix\yii1\admin\core\filters;
use sweelix\yii1\ext\entities\Content;

/**
 * Class ContextContent
 *
 * This component filters requests to ensure contentId is valid and correctly set.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  filters
 * @package   sweelix.yii1.admin.core.filters
 */
class ContextContent extends \CFilter {

	/**
	 * Check if current contentId is passed to the application
	 *
	 * @param CFilterChain $filterChain the current filter chain
	 *
	 * @return boolean
	 * @since  1.2.0
	 */
	protected function preFilter($filterChain) {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.filters');
		$content = Content::model()->findByPk(\Yii::app()->request->getParam('contentId', 0));
		if($content === null) {
			throw new \CHttpException(404,
				\Yii::t('sweelix', 'Content {contentId} does not exists',
					array( '{contentId}'=>\Yii::app()->request->getParam('contentId', 0)))
				);
		} else {
			$filterChain->controller->setCurrentContent($content);
			// logic being applied before the action is executed
			return true;
		}
	}

	/**
	 * No post filtering
	 *
	 * @param CFilterChain $filterChain the current filter chain
	 *
	 * @return void
	 */
	protected function postFilter($filterChain) {
	}
}

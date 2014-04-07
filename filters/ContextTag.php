<?php
/**
 * File ContextTag.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  filters
 * @package   sweelix.yii1.admin.core.filters
 */

namespace sweelix\yii1\admin\core\filters;
use sweelix\yii1\ext\entities\Tag;

/**
 * Class ContextTag
 *
 * This component filters requests to ensure tagId is valid and correctly set.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  filters
 * @package   sweelix.yii1.admin.core.filters
 */
class ContextTag extends \CFilter {

	/**
	 * Check if current groupId is passed to the application
	 *
	 * @param CFilterChain $filterChain the current filter chain
	 *
	 * @return boolean
	 * @since  1.2.0
	 */
	protected function preFilter($filterChain) {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.filters');
		$tag = Tag::model()->findByPk(\Yii::app()->request->getParam('tagId', 0));
		if($tag === null) {
			throw new \CHttpException(404,
				\Yii::t('sweelix', 'Tag {tagId} does not exists',
					array( '{tagId}'=>\Yii::app()->request->getParam('tagId', 0)))
				);
		} else {
			$filterChain->controller->setCurrentTag($tag);
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
	 * @since  1.2.0
	 */
	protected function postFilter($filterChain) {
	}
}

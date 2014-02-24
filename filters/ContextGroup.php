<?php
/**
 * File ContextGroup.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  filters
 * @package   sweelix.yii1.admin.core.filters
 */

namespace sweelix\yii1\admin\core\filters;
use sweelix\yii1\ext\entities\Group;

/**
 * Class ContextGroup
 *
 * This component filters requests to ensure groupId is valid and correctly set.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  filters
 * @package   sweelix.yii1.admin.core.filters
 */
class ContextGroup extends \CFilter {

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
		$group = Group::model()->findByPk(\Yii::app()->request->getParam('groupId', 0));
		if($group === null) {
			$group = Group::model()->find(array('order' => 'groupId asc'));
			$targetRequest = $_GET;
			$targetRequest['groupId'] = $group->groupId;
			array_unshift($targetRequest, $filterChain->controller->action->id);
			$filterChain->controller->redirect( $targetRequest );
			return false;
		} else {
			$filterChain->controller->setCurrentGroup($group);
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

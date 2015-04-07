<?php
/**
 * File ContextNode.php
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

use sweelix\yii1\ext\entities\Node;
use CFilter;
use Yii;

/**
 * Class ContextNode
 *
 * This component filters requests to ensure nodeId is valid and correctly set.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  filters
 * @package   sweelix.yii1.admin.core.filters
 */
class ContextNode extends CFilter
{
    /**
     * Check if current nodeId is passed to the application
     *
     * @param CFilterChain $filterChain the current filter chain
     *
     * @return boolean
     * @since  1.2.0
     */
    protected function preFilter($filterChain)
    {
        Yii::trace(__METHOD__ . '()', 'sweelix.yii1.admin.core.filters');
        $node = Node::model()->findByPk(Yii::app()->request->getParam('nodeId', 0));
        if ($node === null) {
            $node = Node::model()->findByAttributes(
                array('nodeLevel' => 0),
                array('order' => 'nodeLeftId ASC')
            );
            $targetRequest = $_GET;
            $targetRequest['nodeId'] = $node->nodeId;
            array_unshift($targetRequest, $filterChain->controller->action->id);
            $filterChain->controller->redirect($targetRequest);
            return false;
        } else {
            $filterChain->controller->setCurrentNode($node);
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
    protected function postFilter($filterChain)
    {
    }
}

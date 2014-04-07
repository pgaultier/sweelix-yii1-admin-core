<?php
/**
 * File Node.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */

namespace sweelix\yii1\admin\core\models;

/**
 * Class Node
 *
 * This model allow node management.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */
class Node extends \CFormModel {

	/**
	 * @var integer node id
	 */
	public $nodeId;

	/**
	 * @var integer target node id
	 */
	public $targetNodeId;

	/**
	 * @var enum where to move the node
	 */
	public $where;

	/**
	 * @var integer tag id
	 */
	public $tagId;

	/**
	 * @var boolean check if node is selected
	 */
	public $selected;

	/**
	 * Business rules
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nodeId, targetNodeId, where', 'required','on'=>'move'),
			array('where', 'isAllowed', 'on'=>'move'),
			array('nodeId, tagId, selected', 'required','on'=>'updateTag'),
			array('selected, targetNodeId', 'required', 'on'=>'deleteNode'),
			array('selected', 'boolean', 'on'=>'deleteNode'),
			array('selected', 'compare', 'compareValue'=>true, 'on'=>'deleteNode'),
		);
	}

	/**
	 * Check if selected move is allowed
	 *
	 * @param string $attribute name of checked attribute
	 * @param mixed  $params    parameters applyed
	 *
	 * @return void
	 */
	public function isAllowed($attribute, $params) {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.models');
		if(in_array($this->where, array('before', 'after', 'in', 'first', 'last')) === false) {
			$this->addError('where', \Yii::t('sweelix', 'This node move is unknown'));
		}
	}

	/**
	 * Define attributes
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'nodeId' => \Yii::t('sweelix', 'Node'),
			'targetNodeId' => \Yii::t('sweelix', 'Target'),
			'where' => \Yii::t('sweelix', 'Where'),
		);
	}
}

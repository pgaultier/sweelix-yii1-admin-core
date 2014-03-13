<?php
/**
 * File Group.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.0
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */

namespace sweelix\yii1\admin\core\models;

/**
 * Class Group
 *
 * This model allow group management.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.0
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */
class Group extends \CFormModel {

	/**
	 * @var integer group id
	 */
	public $groupId;

	/**
	 * @var integer group id
	 */
	public $targetGroupId;

	/**
	 * @var boolean check if group is selected
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
			array('selected, targetGroupId', 'required', 'on'=>'deleteGroup'),
			array('selected', 'boolean', 'on'=>'deleteGroup'),
			array('selected', 'compare', 'compareValue'=>true, 'on'=>'deleteGroup'),
		);
	}

	/**
	 * Define attributes
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'groupId' => \Yii::t('sweelix', 'Group'),
			'targetGroupId' => \Yii::t('sweelix', 'Target group id'),
			'selected' => \Yii::t('sweelix', 'Selected'),
		);
	}
}

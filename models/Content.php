<?php
/**
 * File Content.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */

namespace sweelix\yii1\admin\core\models;

/**
 * Class Content
 *
 * This model allow content management.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */
class Content extends \CFormModel {

	/**
	 * @var integer content id
	 */
	public $contentId;

	/**
	 * @var integer content id
	 */
	public $targetContentId;

	/**
	 * @var integer tag id
	 */
	public $tagId;

	/**
	 * @var boolean check if content is selected
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
			array('contentId, tagId, selected', 'required','on'=>'updateTag'),
			array('selected, targetContentId', 'required', 'on'=>'deleteContent'),
			array('selected', 'boolean', 'on'=>'deleteContent'),
			array('selected', 'compare', 'compareValue'=>true, 'on'=>'deleteContent'),
		);
	}

	/**
	 * Define attributes
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'contentId' => \Yii::t('sweelix', 'Content'),
			'tagId' => \Yii::t('sweelix', 'Tag'),
			'selected' => \Yii::t('sweelix', 'Selected'),
		);
	}
}

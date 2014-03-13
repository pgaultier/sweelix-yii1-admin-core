<?php
/**
 * File Meta.php
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
 * Class Meta
 *
 * This model allow meta management.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */
class Meta extends \CFormModel {

	/**
	 * @var integer meta id
	 */
	public $metaId;

	/**
	 * @var boolean if we override meta value or not
	 */
	public $metaModeOverride=false;

	/**
	 * @var string default meta value
	 */
	public $metaDefaultValue;

	/**
	 * @var string current meta value
	 */
	public $metaValue=null;

	/**
	 * @var integer node id
	 */
	public $nodeId;

	/**
	 * @var integer content id
	 */
	public $contentId;

	/**
	 * Business rules
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('metaId, metaModeOverride, nodeId', 'required', 'on'=>'node'),
			array('metaDefaultValue, metaValue', 'safe', 'on'=>'node'),
			array('metaId, metaModeOverride, contentId', 'required','on'=>'content'),
			array('metaDefaultValue, metaValue', 'safe', 'on'=>'content'),
		);
	}

	/**
	 * Define attributes
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'metaId' => \Yii::t('sweelix', 'Meta'),
			'metaModeOverride' => \Yii::t('sweelix', 'Override general value'),
			'metaDefaultValue' => \Yii::t('sweelix', 'Default value'),
			'metaValue' => \Yii::t('sweelix', 'Value'),
			'nodeId' => \Yii::t('sweelix', 'Node ID'),
			'contentId' => \Yii::t('sweelix', 'Content ID'),
		);
	}
}

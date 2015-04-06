<?php
/**
 * File Tag.php
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

use CFormModel;
use Yii;

/**
 * Class Tag
 *
 * This model allow tag management.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */
class Tag extends CFormModel
{

    /**
     * @var integer tag id
     */
    public $tagId;

    /**
     * @var integer tag id
     */
    public $targetTagId;

    /**
     * @var boolean check if tag is selected
     */
    public $selected;

    /**
     * Business rules
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('selected, targetTagId', 'required', 'on' => 'deleteTag'),
            array('selected', 'boolean', 'on' => 'deleteTag'),
            array('selected', 'compare', 'compareValue' => true, 'on' => 'deleteTag'),
        );
    }

    /**
     * Define attributes
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'tagId' => Yii::t('sweelix', 'Tag'),
            'targetTagId' => Yii::t('sweelix', 'Target tag id'),
            'selected' => Yii::t('sweelix', 'Selected'),
        );
    }
}

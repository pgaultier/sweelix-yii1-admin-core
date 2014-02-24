<?php
/**
 * File Author.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */

namespace sweelix\yii1\admin\core\models;
use sweelix\yii1\ext\entities\Author as EntityAuthor;
use sweelix\yii1\admin\base\components\UserIdentity;

/**
 * Class Author
 *
 * This model allow author management.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  models
 * @package   sweelix.yii1.admin.core.models
 */
class Author extends EntityAuthor {

	/**
	 * @var boolean allow auto login
	 */
	public $authorAutoLogin;
	/**
	 * @var string new password wanted
	 */
	public $authorNewPassword;
	/**
	 * @var string check if new password is ok
	 */
	public $authorControlPassword;
	/**
	 * @var array handle author roles
	 */
	public $authorRoles=array();
	/**
	 * @var SwUserIdentity identity
	 */
	private $_identity;

	/**
	 * Returns the static model of the specified AR class.
	 *
	 * @return Author
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * Business rules
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('authorEmail, authorPassword, authorAutoLogin', 'required','on'=>'authenticate'),
			array('authorEmail', 'email','on'=>'authenticate'),
			array('authorPassword', 'authenticateClassic', 'on'=>'authenticate'),

			array('authorLastname, authorFirstname, authorEmail, authorPassword, authorControlPassword', 'required', 'on'=>'create'),
			array('authorId, authorLastname, authorFirstname, authorEmail', 'required', 'on'=>'adminUpdate'),
			array('authorEmail', 'email','on'=>'create, adminUpdate'),
			array('authorPassword', 'safe', 'on' => 'adminUpdate'),
			array('authorControlPassword', 'compare', 'compareAttribute'=>'authorPassword', 'on'=>'create'),
			array('authorControlPassword', 'compare', 'compareAttribute'=>'authorPassword', 'on'=>'adminUpdate'),
			array('authorRoles', 'safe'),
		);
	}

	/**
	 * Define attributes
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'authorEmail' => \Yii::t('sweelix', 'E-mail'),
				'authorPassword' => \Yii::t('sweelix', 'Password'),
				'authorAutoLogin' => \Yii::t('sweelix', 'Auto-connect'),
				'authorControlPassword' => \Yii::t('sweelix', 'Confirm Password'),
				'authorNewPassword' => \Yii::t('sweelix', 'New Password'),
			)
		);
	}

	/**
	 * retrieve user identity if everything was ok
	 *
	 * @return UserIdentity
	 */
	public function getIdentity() {
		return $this->_identity;
	}

	/**
	 * Direct password check
	 *
	 * @param mixed $attribute attribute information
	 * @param mixed $params    event parameter
	 *
	 * @return void
	 */
	public function checkPassword($attribute, $params) {
		try {
			\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.models');
			$author = EntityAuthor::model()->findByPk($this->authorId);
			if($author !== null) {
				if($this->authorPassword !== $author->authorPassword) {
					$this->addError('authorPassword', \Yii::t('sweelix', 'Incorrect password'));
				}
			} else {
				$this->addError('authorId', \Yii::t('sweelix', 'Incorrect ID'));
			}
		} catch(\Exception $e) {
			\Yii::log('Error in '.__METHOD__.'():'.$e->getMessage(), \CLogger::LEVEL_ERROR, 'sweelix.yii1.admin.core.models');
			throw $e;
		}
	}

	/**
	 * manage authentication through SwUserIdentity
	 *
	 * @param mixed $attribute attribute information
	 * @param mixed $params    event parameter
	 *
	 * @return void
	 */
	public function authenticateClassic($attribute, $params) {
		try {
			\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.models');
			// Login a user with the provided username and password.
			$this->_identity = new UserIdentity($this->authorEmail, $this->authorPassword);
			if($this->_identity->authenticate() !== true) {
				switch($this->_identity->errorCode) {
					case UserIdentity::ERROR_PASSWORD_INVALID :
						$this->addError('authorPassword', \Yii::t('sweelix', 'Incorrect password'));
						break;
					case UserIdentity::ERROR_USERNAME_INVALID :
					case UserIdentity::ERROR_UNKNOWN_IDENTITY :
					default :
						$this->addError('authorEmail', \Yii::t('sweelix', 'Incorrect username'));
						$this->addError('authorPassword', \Yii::t('sweelix', 'Incorrect password'));
						break;
				}
			}
		} catch(\Exception $e) {
			\Yii::log('Error in '.__METHOD__.'():'.$e->getMessage(), \CLogger::LEVEL_ERROR, 'sweelix.yii1.admin.core.models');
			throw $e;
		}
	}

	/**
	* get the full (firstName.' '.lastName) name of the user
	*
	* @return String
	*/
	public function getFullName(){
		return $this->authorFirstname.' '.$this->authorLastname;
	}

	/**
	 * perform some operations before save a new user
	 *
	 * @return boolean
	 */
	public function beforeSave() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.models');
		try {
			if(parent::beforeSave()){
                if ($this->isNewRecord){
                    $this->authorPassword = sha1($this->authorPassword);
                    return true;
                }else{
                	$currentPasswordInDB = EntityAuthor::model()->findByPk($this->authorId)->authorPassword;
                	if($currentPasswordInDB != $this->authorPassword)
                		$this->authorPassword = sha1($this->authorPassword);
                    return true;
                }
            } else return false;
		} catch(\Exception $e) {
			\Yii::log('Error in '.__METHOD__.'():'.$e->getMessage(), \CLogger::LEVEL_ERROR, 'sweelix.yii1.admin.core.models');
			throw $e;
			return false;
		}
	}
}

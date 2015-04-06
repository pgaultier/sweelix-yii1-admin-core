<?php
/**
 * File UserIdentity.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 */

namespace sweelix\yii1\admin\core\components;

use sweelix\yii1\ext\entities\Author;
use CDateTimeParser;
use Exception;
use Yii;

/**
 * Class UserIdentity
 *
 * This component allow the user management for authentication
 * and authorization processes.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 *
 * @property integer $id
 * @property boolean $isAuthenticated
 * @property string  $name
 * @property array   $persistentStates
 */
class UserIdentity extends \CComponent implements \IUserIdentity {
	const ERROR_NONE=0;
	const ERROR_USERNAME_INVALID=1;
	const ERROR_PASSWORD_INVALID=2;
	const ERROR_UNKNOWN_IDENTITY=100;

	/**
	 * @var string user id once authentication is successfull
	 */
	private $_id;

	/**
	 * @var mixed data stored in session for persistent state
	 */
	private $_state=array();

	/**
	 * @var string user email needed for authentication
	 */
	public $email;

	/**
	 * @var string user password needed for authentication
	 */
	public $password;

	/**
	 * @var integer the authentication error code. If there is an error, the error code will be non-zero.
	 * Defaults to 100, meaning unknown identity. Calling {@link http://www.sweelix.net
	 */
	public $errorCode=self::ERROR_UNKNOWN_IDENTITY;

	/**
	 * @var string the authentication error message. Defaults to empty.
	 */
	public $errorMessage='';

	/**
	 * UserIdentity constructor. Init needed information
	 *
	 * @param string $email    the email used to login
	 * @param string $password user password
	 *
	 * @return UserIdentity
	 * @since  1.2.0
	 */
	public function __construct($email, $password) {
		$this->email = $email;
		$this->password = $password;
	}

	/**
	 * Getter for userId
	 *
	 * @return integer the user id
	 * @since  1.2.0
	 */
	public function getId() {
		return $this->_id;
	}
	/**
	 * Returns the display name for the identity (e.g. username).
	 *
	 * @return string the display name for the identity.
	 * @since  1.2.0
	 */
	public function getName() {
		return $this->email;
	}

	/**
	 * Returns the identity states that should be persisted.
	 * This method is required by {@link http://www.sweelix.net
	 *
	 * @return array the identity states that should be persisted.
	 * @since  1.2.0
	 */
	public function getPersistentStates() {
		return $this->_state;
	}

	/**
	 * Sets an array of presistent states.
	 *
	 * @param array $states the identity states that should be persisted.
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function setPersistentStates($states) {
		$this->_state = $states;
	}

	/**
	 * Returns a value indicating whether the identity is authenticated.
	 * This method is required by {@link http://www.sweelix.net
	 *
	 * @return integer whether the authentication is successful.
	 * @since  1.2.0
	 */
	public function getIsAuthenticated() {
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * Gets the persisted state by the specified name.
	 *
	 * @param string $name         the name of the state
	 * @param mixed  $defaultValue the default value to be returned if the named state does not exist
	 *
	 * @return mixed the value of the named state
	 * @since  1.2.0
	 */
	public function getState($name,$defaultValue=null) {
		return (isset($this->_state[$name])===true)?$this->_state[$name]:$defaultValue;
	}

	/**
	 * Sets the named state with a given value.
	 *
	 * @param string $name  the name of the state
	 * @param mixed  $value the value of the named state
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function setState($name, $value) {
		$this->_state[$name]=$value;
	}

	/**
	 * Removes the specified state.
	 *
	 * @param string $name the name of the state
	 *
	 * @return void
	 * @since  1.2.0
	 */
	public function clearState($name) {
		unset($this->_state[$name]);
	}

	/**
	 * Authenticate the user against the DB
	 *
	 * @return boolean
	 * @since  1.2.0
	 */
	public function authenticate() {
		Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.components');
		$result = false;
		try {

			$author = Author::model()->findByAttributes(array('authorEmail'=>$this->email));
			if($author===null) {
		    	$this->errorCode=self::ERROR_USERNAME_INVALID;
			} elseif($author->authorPassword!==sha1($this->password)) {
		    	$this->errorCode=self::ERROR_PASSWORD_INVALID;
			} else {
				$this->_id=$author->authorId;
				$this->setState('firstName', $author->authorFirstname);
				$this->setState('lastName', $author->authorLastname);
				$this->setState('lastLogin',
					Yii::app()->locale->dateFormatter->formatDateTime(
						CDateTimeParser::parse($author->authorLastLogin, 'yyyy-MM-dd hh:mm:ss'),
						'long',
						'medium'
					)
				);
				$author->authorLastLogin = new \CDbExpression('now()');
				$author->save();
		    	$this->errorCode=self::ERROR_NONE;
		    	$result = true;
			}
			return $result;
		} catch(Exception $e) {
			Yii::log('Error in '.__METHOD__.'():'.$e->getMessage(), \CLogger::LEVEL_ERROR, 'sweelix.yii1.admin.core.components');
			throw $e;
		}
    }
}

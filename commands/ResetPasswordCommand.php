<?php
/**
 * File ResetPasswordCommand.php
 *
 * PHP version 5.4+
 *
 * @author    Cyril Marois <cyrilmarois@gmail.com>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  commands
 * @package   sweelix.yii1.admin.core.commands
 */

namespace sweelix\yii1\admin\core\components;

/**
 * Class ResetPasswordCommand
 *
 * This command handle password reset
 *
 * @author    Cyril Marois <cyrilmarois@gmail.com>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  commands
 * @package   sweelix.yii1.admin.core.commands
 * @since     XXX
 */
class ResetPasswordCommand extends \CConsoleCommand {
    
	const FILENAME = 'reset';
	const PASSWORD_LENGTH = 8;

	/**
	 * Provide new password
	 *
	 * @return boolean
	 * @since  XXX
	 */
	public function actionIndex($authorEmail = 'admin@sweelix.net')
	{
		try {
            \Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.core.commands');

			$connection = \Yii::app()->db;
			$query = "SELECT * FROM authors WHERE authorEmail = :authorEmail";
			$command = $connection->createCommand($query);
			$command->bindParam('authorEmail', $authorEmail);
			if ($command->queryRow() === false) {
				echo "User does not exists \r\n";
				return 1;
			}

			//check if file exists
			if (file_exists(Yii::app()->basePath.DIRECTORY_SEPARATOR.self::FILENAME) === false) {
				echo "The file \"" .self::FILENAME. "\" is missing in the \"protected\" directory\r\n";
				return 1;
			}
			//if exists generate password			
			$string = 'abcdefghijklmnopqrstuvwyxz0123456789@!:;,§/$=+';
			$password = '';
			//set password length
			$passwordLength = self::PASSWORD_LENGTH;
			for($i = 1; $i <= $passwordLength; $i++) {

				//get string length
				$lengthString = strlen($string);

				//pick random character
				$lengthString = mt_rand(0,($lengthString-1));

				//compute string
				$password .= $string[$lengthString];
			}
			//hash password
			$hashPassword = sha1($password);
			//set password
			$query = "UPDATE authors SET authorPassword = :authorPassword WHERE authorEmail = :authorEmail";

			$command = $connection->createCommand($query);
			$command->bindParam(':authorPassword', $hashPassword);
			$command->bindParam(':authorEmail', $authorEmail);
			$command->execute();

			//remove file to make sur user can access to project
			unlink(Yii::app()->basePath.DIRECTORY_SEPARATOR.self::FILENAME);

			echo "The password for the user $authorEmail has been reset.\r\nThe new password is : $password \r\n";

			return 0;
		} catch(Exception $e) {
            \Yii::log('Error in '.__METHOD__.'():'.$e->getMessage(), \CLogger::LEVEL_ERROR, 'sweelix.yii1.admin.core.commands');
			throw $e;
		}
	}
}
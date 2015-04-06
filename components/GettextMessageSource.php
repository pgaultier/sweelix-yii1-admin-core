<?php
/**
 * File GettextMessageSource.php
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

use CGettextMessageSource;
use CFileCacheDependency;
use CGettextPoFile;
use CGettextMoFile;
use Yii;

/**
 * Class GettextMessageSource
 *
 * This component allow simplier translation management.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  components
 * @package   sweelix.yii1.admin.core.components
 * @since     3.0.0
 */
class GettextMessageSource extends CGettextMessageSource {
	/**
	 * @var array the message paths for extensions that do not have a base class to use as category prefix.
	 * The format of the array should be:
	 * <pre>
	 * array(
	 * 'ExtensionName' => 'ext.ExtensionName.messages',
	 * )
	 * </pre>
	 * Where the key is the name of the extension and the value is the alias to the path
	 * of the "messages" subdirectory of the extension.
	 * When using Yii::t() to translate an extension message, the category name should be
	 * set as 'ExtensionName.categoryName'.
	 * Defaults to an empty array, meaning no extensions registered.
	 * @since 1.1.13
	 */
	public $extensionPaths=array();

	private $_files=array();

	/**
	 * Determines the message file name based on the given category and language.
	 * If the category name contains a dot, it will be split into the module class name and the category name.
	 * In this case, the message file will be assumed to be located within the 'messages' subdirectory of
	 * the directory containing the module class file.
	 * Otherwise, the message file is assumed to be under the {@link basePath}.
	 * @param string $category category name
	 * @param string $language language ID
	 * @return string the message file path
	 */
	protected function getMessageFile($category,$language) {
		if(!isset($this->_files[$category][$language])) {
			if(($pos=strpos($category,'.'))!==false) {
				$extensionClass=substr($category,0,$pos);
				$extensionCategory=substr($category,$pos+1);
				// First check if there's an extension registered for this class.
				if(isset($this->extensionPaths[$extensionClass])) {
					$this->_files[$category][$language]=Yii::getPathOfAlias($this->extensionPaths[$extensionClass]).DIRECTORY_SEPARATOR.$language;
				} else {
					// No extension registered, need to find it.
					$class=new \ReflectionClass($extensionClass);
					$this->_files[$category][$language]=dirname($class->getFileName()).DIRECTORY_SEPARATOR.'messages'.DIRECTORY_SEPARATOR.$language;
				}
			} elseif(isset($this->extensionPaths[$category])) {
				$this->_files[$category][$language]=Yii::getPathOfAlias($this->extensionPaths[$category]).DIRECTORY_SEPARATOR.$language;
			}
			else
				$this->_files[$category][$language]=$this->basePath.DIRECTORY_SEPARATOR.$language;
		}
		if($this->useMoFile)
			$this->_files[$category][$language].=self::MO_FILE_EXT;
		else
			$this->_files[$category][$language].=self::PO_FILE_EXT;

		return $this->_files[$category][$language];
	}
	/**
	 * Loads the message translation for the specified language and category.
	 * @param string $category the message category
	 * @param string $language the target language
	 * @return array the loaded messages
	 */
	protected function loadMessages($category, $language) {
		$messageFile = $this->getMessageFile($category,$language);
		if ($this->cachingDuration > 0 && $this->cacheID!==false && ($cache=Yii::app()->getComponent($this->cacheID))!==null) {
			$key = self::CACHE_KEY_PREFIX . $messageFile;
			if (($data=$cache->get($key)) !== false)
				return unserialize($data);
		}
		if (is_file($messageFile) === true) {
			if($this->useMoFile)
				$file = new CGettextMoFile($this->useBigEndian);
			else
				$file = new CGettextPoFile();
			$messages = $file->load($messageFile,$category);
			if(isset($cache) === true) {
				$dependency = new CFileCacheDependency($messageFile);
				$cache->set($key,serialize($messages),$this->cachingDuration,$dependency);
			}
			return $messages;
		}
		else
			return array();
	}
}

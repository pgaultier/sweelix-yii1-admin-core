<?php
/**
 * File Module.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  admin
 * @package   sweelix.yii1.admin.core
 */

namespace sweelix\yii1\admin\core;
use sweelix\yii1\ext\components\Config as Extension;

\Yii::setPathOfAlias('sweeft', __DIR__);

/**
 * Class Module
 *
 * This module is the base container for all admin submodules
 * @see Module in components.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  admin
 * @package   sweelix.yii1.admin.core
 * @since     1.0.0
 */
class Module extends \CWebModule {
	private $_assetsUrl;
	/**
	 * @var string define session name to avoid conflicts
	 **/
	public $sessionName = 'sweeft';
	/**
	 * @var integer define session lifetime
	 **/
	public $sessionLifetime = 86400;
	/**
	 * @var string controllers namespace
	 */
	public $controllerNamespace = 'sweelix\yii1\admin\core\controllers';
	/**
	 * Init the module with specific information.
	 * @see CModule::init()
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function init() {
		parent::init();
		\Yii::app()->setLocaleDataPath(__DIR__.DIRECTORY_SEPARATOR.'i18n'.DIRECTORY_SEPARATOR.'data');
		$this->layout='main';
		\Yii::app()->sourceLanguage = 'en';
		// CHttpRequest cannot be redefined, we have to attach the behavior manually.
		\Yii::app()->getRequest()->attachBehavior('sweelixAjax', 'sweelix\yii1\behaviors\Ajax');

		$sessionSetUp = array(
			'class' => 'CHttpSession',
			'cookieParams' => array(
				'lifetime' => 12*3600,
				'path' => '/',
				'httponly' => true,
			),
		);
		if($this->sessionName !== null) {
			$sessionSetUp['sessionName'] = $this->sessionName;
		}
		if($this->sessionLifetime !== null) {
			$sessionSetUp['cookieParams']['lifetime'] = $this->sessionLifetime;
		}
		\Yii::app()->setComponents(array(
			'user'=>array(
				'class' => 'sweelix\yii1\admin\core\components\WebUser',
				'stateKeyPrefix'=>'sweeft',
				'allowAutoLogin'=>true,
				'loginUrl'=>\Yii::app()->createUrl('sweeft/authentication/login'),
			),
			'messages' => array(
				'class' => 'sweelix\yii1\admin\core\components\GettextMessageSource',
				'basePath' => __DIR__.DIRECTORY_SEPARATOR.'messages',
				'forceTranslation' => true,
			),
			'session' => $sessionSetUp,
			'urlManager' => array(
				'class' => 'sweelix\yii1\ext\web\UrlManager',
			),
			'authManager'=>array(
				'class'=>'\CDbAuthManager',
				'connectionID'=>'db',
				'itemTable'=>'{{swauthItem}}',
				'assignmentTable'=>'{{swauthAssignment}}',
				'itemChildTable'=>'{{swauthItemChild}}',
			),
		), false);
		\Yii::app()->setComponents(array(
			'clientScript'=>array(
				'class' => 'CClientScript',
				'behaviors' => array(
					'sweelixClientScript' => array(
						'class' => 'sweelix\yii1\behaviors\ClientScript',
						'config' => array(
							'debug'=>array(
								//'mode' => array('popup'),
							),
							'sweeft'=>array(
								'language' => \Yii::app()->language,
								'editor' => $this->getEditor(),
							),
						),
					),
					'lessClientScript' => array(
						'class' => 'sweelix\yii1\behaviors\Less',
						'suffix' => '-sweeft', // avoid collisions
						// 'cacheId' => 'cache', // define cache component to use
						'cacheDuration' => 0, // default value infinite duration
						'forceRefresh' => false, // default value : do not recompile files
						'formatter' => 'lessjs', // default output format
						'variables' => array(), // variables to expand
						'directory' => 'sweeft.less', // directory where less files are stored
						'assetsDirectories' => array('img'),
					),
				),
			),
		), false);
		if(\Yii::app()->hasComponent('sweelix') === false) {
			\Yii::app()->setComponents(array(
				'sweelix'=>array(
					'class' => 'sweelix\yii1\ext\components\Config',
				),
			), false);
		}
		if(\Yii::app()->hasComponent('image') === false) {
			\Yii::app()->setComponents(array(
				'image'=>array(
					'class' => 'sweelix\yii1\components\ImageConfig',
					'quality'=>80,
				),
			), false);
		}
	}

	private $_realSiteUrl;
	/**
	 * Define the real site url
	 *
	 * @param string $url target site url http://www.mysite.com/dir
	 */
	public function setRealSiteUrl($url) {
		$this->_realSiteUrl = rtrim($url, '/');
	}
	/**
	 * Return real site url, empty if identical
	 *
	 * @return string
	 * @since  1.9.0
	 */
	public function getRealSiteUrl() {
		return ($this->_realSiteUrl===null)?'':$this->_realSiteUrl;
	}

	private $_editor;
	/**
	 * Define editor for all wysiwyg elements
	 *
	 * @param string $editor editor shortcut
	 *
	 * @return void
	 * @since  1.6.0
	 */
	public function setEditor($editor) {
		$editor = strtolower($editor);
		if(in_array($editor, array('cleditor', 'ckeditor'))===true) {
			$this->_editor = $editor;
		}
	}

	/**
	 * Get defined editor for current project
	 *
	 * @return string
	 * @since  1.6.0
	 */
	public function getEditor() {
		if($this->_editor === null) {
			$this->_editor = 'cleditor';
		}
		return $this->_editor;
	}

	/**
	 * Return module version
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function getVersion() {
		return Extension::getVersion();
	}

	/**
	 * Everything is embedded in the module. We have to publish elements
	 * and to retrieve path of elements
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function getAssetsUrl() {
		if($this->_assetsUrl===null) {
			$this->_assetsUrl = \Yii::app()->getAssetManager()->publish(__DIR__.DIRECTORY_SEPARATOR.'assets');
		}
		return $this->_assetsUrl;
	}

	/**
	 * We can override assets url
	 *
	 * @param string $value assets url
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function setAssetsUrl($value) {
		$this->_assetsUrl=$value;
	}

	/**
	 * As this function is triggered by config and used in
	 * all the application, we set it here.
	 *
	 * The function register everything to have a working wysiwyg
	 *
	 * @return void
	 * @since  1.6.0
	 */
	public function registerWysiwygEditor() {
		if($this->getEditor() == 'cleditor') {
			\Yii::app()->getClientScript()->registerCssFile($this->getAssetsUrl().'/css/jquery.cleditor.css');
			\Yii::app()->getClientScript()->registerScriptFile($this->getAssetsUrl().'/js/jquery.cleditor.js');
$js =<<<EOJS
/**
 * Declare the wysiwyg editor to handle "data" parameters
 */
jQuery.fn.wysiwyg = function (params) {
	return this.each(function () {
		var data = jQuery(this).data('wysiwyg');
		var finalData = {};
		jQuery.extend(finalData, params, data);
		jQuery(this).cleditor(finalData);
	});
};
jQuery('body').on('afterAjax', 'form', function(){jQuery('.wysiwyg').wysiwyg();});
jQuery('.wysiwyg').wysiwyg();
EOJS;
			\Yii::app()->getClientScript()->registerScript('cleditor', $js);
		} elseif($this->getEditor() == 'ckeditor') {
			\Yii::app()->getClientScript()->registerScriptFile($this->getAssetsUrl().'/js/ckeditor/ckeditor.js');
			\Yii::app()->getClientScript()->registerScriptFile($this->getAssetsUrl().'/js/ckeditor/jquery.ckeditor.js');
$js =<<<EOJS
jQuery.fn.wysiwyg = function (params) {
	return this.each(function () {
		var data = jQuery(this).data('wysiwyg');
		var finalData = {};
		jQuery.extend(finalData, params, data);
		jQuery(this).ckeditor(function(){}, finalData);
	});
};
jQuery('body').on('beforeAjax', 'form', function(){jQuery('.wysiwyg').each(function(i, el){if (CKEDITOR.instances[jQuery(el).attr('id')]) {CKEDITOR.instances[jQuery(el).attr('id')].destroy();}});});
jQuery('body').on('afterAjax', 'form', function(){jQuery('.wysiwyg').each(function(i, el){if (CKEDITOR.instances[jQuery(el).attr('id')]) {delete CKEDITOR.instances[jQuery(el).attr('id')];}});jQuery('.wysiwyg').wysiwyg();});
jQuery('.wysiwyg').wysiwyg();
EOJS;
			\Yii::app()->getClientScript()->registerScript('ckeditor', $js);
		}
	}
}

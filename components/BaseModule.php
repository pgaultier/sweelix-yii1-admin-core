<?php
/**
 * File BaseModule.php
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

use CWebModule;
use Yii;

/**
 * Class BaseModule
 *
 * Every sub module should extend this module.
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
class BaseModule extends CWebModule
{
    protected $basePath;
    private $assetsUrl;
    private $assetsPath;

    private $layoutPath;

    /**
     * Return correct layout path to inherit sweeft module path
     * @see CWebModule::getLayoutPath()
     *
     * @return string
     * @since  1.2.0
     */
    public function getLayoutPath()
    {
        if ($this->layoutPath !== null) {
            return $this->layoutPath;
        } else {
            return $this->layoutPath = $this->getParentModule()->getLayoutPath();
        }
    }

    /**
     * Return module version
     *
     * @return string
     * @since  1.0.0
     */
    public function getVersion()
    {
        return $this->getParentModule()->getVersion();
    }

    private $shortId;

    /**
     * Return the short module id
     *
     * @return string
     * @since  3.0.0
     */
    public function getShortId()
    {
        if ($this->shortId === null) {
            $parts = explode('/', $this->getId());
            $this->shortId = array_pop($parts);
        }
        return $this->shortId;
    }

    /**
     * Return current module title
     *
     * @return string
     * @since  3.0.0
     */
    public function getTitle()
    {
        return Yii::t($this->getShortId(), ucfirst($this->getShortId()));
    }

    /**
     * Return current asset path.
     *
     * @return string
     * @since  2.0.0
     */
    public function getAssetsPath()
    {
        if ($this->assetsPath === null) {
            $this->assetsPath = $this->basePath . DIRECTORY_SEPARATOR . 'assets';
        }
        return $this->assetsPath;
    }

    /**
     * Everything is embedded in the module. We have to publish elements
     * and to retrieve path of elements
     *
     * @return string
     * @since  1.0.0
     */
    public function getAssetsUrl()
    {
        if (($this->assetsUrl === null) && ($this->basePath !== null)) {
            $this->assetsUrl = Yii::app()->getAssetManager()->publish($this->getAssetsPath());
        }
        return $this->assetsUrl;
    }

    /**
     * We can override assets url
     *
     * @param string $value assets url
     *
     * @return void
     * @since  1.0.0
     */
    public function setAssetsUrl($value)
    {
        $this->assetsUrl = $value;
    }

    /**
     * register scripts for current module.
     * Default implementation register module.js
     *
     * @return void
     * @since  2.0.0
     */
    public function registerScripts()
    {
        $moduleJs = $this->getAssetsPath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'module.js';
        if (file_exists($moduleJs) === true) {
            Yii::app()->getClientScript()->registerScriptFile($this->getAssetsUrl() . '/js/module.js');
        }
    }
}

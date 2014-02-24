<?php
/**
 * File en.php
 *
 * This file override original i18n file to have same info between javascript and php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  i18n
 * @package   sweelix.yii1.admin.i18n
 */
return CMap::mergeArray(
	require(Yii::getPathOfAlias('system.i18n.data').DIRECTORY_SEPARATOR.basename(__FILE__)),
	array(
		'dateFormats' =>
		array (
			'full' => 'EEEE, MMMM d, y',
			'jui_full' => 'DD d MM yy',
			'long' => 'MMMM d, y',
			'jui_long' => 'd MM yy',
			'medium' => 'MMM d, y',
			'jui_medium' => 'd M yy',
			'short' => 'M/d/yyyy',
			'jui_short' => 'm/d/yy',
		)
	)
);

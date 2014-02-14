<?php
/**
 * File fr.php
 *
 * This file override original i18n file to have same info between javascript and php
 *
 * PHP version 5.2+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2013 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  i18n
 * @package   sweeft.i18n
 */
return CMap::mergeArray(
	require(Yii::getPathOfAlias('system.i18n.data').DIRECTORY_SEPARATOR.basename(__FILE__)),
	array(
		'dateFormats' =>
		array (
			'full' => 'EEEE d MMMM y',
			'jui_full' => 'DD d MM yy',
			'long' => 'd MMMM y',
			'jui_long' => 'd MM yy',
			'medium' => 'd MMM y',
			'jui_medium' => 'd M yy',
			'short' => 'dd/MM/yyyy',
			'jui_short' => 'dd/mm/yy',
		)
	)
);

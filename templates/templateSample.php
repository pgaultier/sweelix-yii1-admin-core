<?php
/**
 * templateSample.php
 *
 * PHP version 5.4+
 *
 * This sample list all element types allowed and major config information
 *
 * elementType are
 *  - text
 *  - hidden
 *  - password
 *  - textarea
 *  - asyncfile
 *  - file
 *  - radio
 *  - checkbox
 *  - listbox
 *  - dropdownlist
 *  - checkboxlist
 *  - radiolist
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  templates
 * @package   sweelix.yii1.admin.core.templates
 */
return array(
    'idOfTheElement' => array(
        /**
         * model related information
         */
        'model' => array(
            /**
             * title of the element in BO
             */
            'label' => Yii::t('sweelix', 'Name displayed'),
            /**
             * rules which should be applied to current element
             */
            'rules' => array(
                array('file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
                array('required'),
            ),
            /**
             * where images should be uploaded
             * only available for file and asyncfile
             */
            'targetPath' => 'resources/',
        ),
        'element' => array(
            // ajax upload
            /**
             * type of the element
             */
            'type' => 'elementType',
            // how the field is displayed in BO
            /**
             * how the element is displayed in the BO
             * fields are
             *  available for all element types
             *  - {label}
             *  - {element}
             */
            'layout' => "{label}<br/>\n{displayLabel} \n",
            /**
             * options for {label}, @see CHtml::activeLabel options
             */
            'labelOptions' => array(),
            /**
             * All other configuration parameters related to base element should be set here.
             *
             * For example:
             * Config data for asyncfile @see Html::activeAsyncFileUpload
             * 'config' => array(
             *    'maxFileSize' => '512mb',
             *    'multiSelection' => true,
             *  'urlPreview' => array('asyncPreview',
             *    'targetPathAlias' => 'webroot.resources',
             *    'width' => 100,
             *    'height' => 100,
             *  ),
             *  // all those parameters can be access by the js event handler
             *  'eventHandlerConfig' => array(
             *    'linkClass' => 'wysiwygimage', // used to link uploaded images with the wysiwyg editor
             *  )
             * ),
             *
             * use app property editor = cleditor / ckeditor to choose appropriate editor
             * or to force wysiwyg in a textarea (@see http://premiumsoftware.net/cleditor/)
             * 'class' => 'wysiwyg',
             * 'data-wysiwyg' =>  CJSON::encode(array(
             *            'controls' => 'bold italic underline strikethrough | highlight removeformat | bullets numbering | undo redo | link unlink | cut copy paste pastetext | print source'
             *        )),
             * same for ckeditor (@see http://ckeditor.com/)
             * 'class' => 'wysiwyg',
             * 'data-wysiwyg' =>  CJSON::encode(array(
             *            'toolbar' => 'MyToolbarSet',
             *            'toolbar_MyToolbarSet' => array(
             *                array('NumberedList','BulletedList','Outdent','Indent','Blockquote','RemoveFormat','Source'),
             *            )
             *        )),
             *
             * or to add data for list elements,
             * 'listData' => $listData,
             *
             */
        ),
    ),
);

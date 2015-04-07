<?php
/**
 * templatingSystem.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  templates
 * @package   sweelix.yii1.admin.core.templates
 *
 *
 * This sample shows how the automatic elastic form translate elements
 *
 * The "Back office" template receive one paramater : $model
 * this $model is the current model which will be rendered
 *
 * @var ElasticModel $model current model rendered (can be Node, Content, Tag, Group)
 */

// use the sweelix helper to have access to async upload system
use sweelix\yii1\web\helpers\Html;


/**
 * Case 1 : elementType in
 *     * text        -> Html::activeTextField(...)
 *     * hidden        -> Html::activeHiddenField(...)
 *     * password    -> Html::activePasswordField(...)
 *     * textarea    -> Html::activeTextArea(...)
 *     * radio        -> Html::activeRadioButton(...)
 *     * checkbox    -> Html::activeCheckBox(...)
 *
 *    'elementId' => [
 *        'model' => [
 *            ... model definition ...
 *        ],
 *        'element' => array(
 *            'labelOptions'    =>  array('label' => 'My label'),            // applied to label element
 *            'type'            => 'text',                                    // stripped out
 *            'class'        => 'small',                                // applied to main element
 *            'layout'        => "{label}\n<br/>\n{element}\n<br/>\n",    // stripped out
 *        ),
 *    ],
 *
 *  in case of textarea, the class wysiwyg trigger the wysiwyg editor
 */
?>

<?php echo Html::activeLabel($model, 'elementId', array('label' => 'My label')); ?>
<br/>
<?php echo Html::activeTextField($model, 'elementId', array('class' => 'small')); ?>
<br/>

<?php
/**
 * Case 2 : elementType in
 *        * listbox        -> Html::activeListBox(...)
 *        * dropdownlist    -> Html::activeDropDownList(...)
 *        * checkboxlist    -> Html::activeCheckBoxList(...)
 *        * radiolist    -> Html::activeRadioButtonList(...)
 *
 *    'elementId' => array(
 *        'model' => array(
 *            ... model definition ...
 *        ),
 *        'element' => array(
 *            'labelOptions'    =>  array('label' => 'My label'),            // applied to label element
 *            'type'            => 'dropdownlist',                            // stripped out
 *            'listData'        => array('element1', 'element2'),            // applied as listData
 *            'class'        => 'medium',                                // applied to main element
 *            'layout'        => "{label}\n<br/>\n{element}\n<br/>\n",    // stripped out
 *        ),
 *    ),
 *
 */
?>

<?php echo Html::activeLabel($model, 'elementId', array('label' => 'My label')); ?>
<br/>
<?php echo Html::activeDropDownList($model, 'elementId', array('element1', 'element2'), array('class' => 'medium')); ?>
<br/>

<?php
/**
 * Case 3 : elementType is asyncfile -> Html::activeAsyncFileUpload(...)
 *
 *    'picture' => array(
 *        'model' => array(
 *                ... model definition ...
 *                'targetPathAlias' => 'webroot.resources.node-{nodeId}',
 *                'targetUrl' => 'resources/node-{nodeId}',
 *        ),
 *        'element' => array(
 *            'labelOptions'    =>  array('label' => 'My picture'),
 *            'type'            => 'asyncfile',
 *            'config' => array(
 *                'maxFileSize'            => '4mb',
 *                'multiSelection'        => false,
 *                'urlPreview'            => array(
 *                    'asyncPreview',
 *                    'targetPathAlias'    => 'webroot.resources.node-{nodeId}',
 *                    'width'            => 400,
 *                    'height'            => 100,
 *                ),
 *            ),
 *            'layout' => "<h3>Visuel et description de la boutique</h3>{label}<br/>{element} <br/>\n",
 *        ),
 *    ),
 *
 */
?>

<?php echo Html::activeLabel($model, 'picture', array('label' => 'My picture')); ?>
<br/>
<?php
// prepare file upload config because we are in special case with dynamic vars in path
$config = array(
    'ui' => 'js:new SweeftUploader()',
    'auto' => true,
    'runtimes' => 'html5, flash',
    'urlPreview' => array(
        'asyncPreview',
        'targetPathAlias' => 'webroot.resources.node-{nodeId}'
    ),
);
// prepare var expansion ({nodeId} <- this is usefull for previewing)
if ($model instanceof sweelix\yii1\ext\entities\Content) {
    $config['urlPreview']['nodeId'] = $model->nodeId;
} elseif ($model instanceof sweelix\yii1\ext\entities\Node) {
    $config['urlPreview']['nodeId'] = $model->nodeId;
}
// any var can be expanded
?>

<?php echo Html::activeAsyncFileUpload($model, 'picture', array(
    // 'class' => 'wysiwigimage', // allow the user to embed the image into a wysiwyg
    'config' => array(
        'ui' => 'js:new SweeftUploader()',
        'auto' => true,
        'runtimes' => 'html5, flash',
        'urlPreview' => array(
            'asyncPreview',
            'targetPathAlias' => 'webroot.resources.node-{nodeId}'
        ),
    )
)); ?>
<br/>

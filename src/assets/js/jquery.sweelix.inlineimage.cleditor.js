/**
 * jquery.sweelix.inlineimage.cleditor.js
 *
 * PHP version 5.4+
 *
 * @author      Philippe Gaultier <pgaultier@sweelix.net>
 * @author      David Ghyse <dghyse@ibitux.com>
 * @link        http://code.ibitux.net/projects/gan-ani-phase2
 * @copyright   Copyright 2010-2015 Ibitux
 * @license     http://www.ibitux.com/license license
 * @version     XXX
 * @category    js
 * @package     jquery.sweelix.inlineimage.cleditor.js
 */
(function($) {
    function redrawPopup() {
        var strData = '';
        var store = '';
        var offset =0;
        $('a.wysiwygimage img').each(function(i,el){
            if($(el).parent('a').data('store') != store) {
                store = $(el).parent('a').data('store');
                offset=0;
            }
            strData = strData+'<img data-store="'+$(el).parent('a').data('store')+'" data-offset="'+offset+'" src="'+$(el).parent('a').attr('href')+'" height="20" /> ';
            offset++;
        });
        if(strData == '') {
            strData = strData+'Enter an URL :<br/>';
        } else {
            strData = 'Select an image:<br/><div style="width:250px">'+strData+'</div>';
            strData = strData+'<br/>';
            strData = strData+'Or enter an URL :<br/>';
        }
        strData = strData+'<input type="text" size="35" value="http://" /><br/>';
        strData = strData+'<input type="button" value="Submit" />';
        return strData;
    }
    $.cleditor.buttons.inlineimage = {
        name: "inlineimage",
        css: {"background-position": "-552px 50%", "background-color": "transparent"},
        title: "Insert image",
        command: "inserthtml",
        popupName: "inlineimage",
        popupClass: "cleditorPrompt",
        popupContent: redrawPopup,
        buttonClick: function (e, data) {
            $(data.popup).html(redrawPopup());
            // Wire up the submit button click event
            $(data.popup).children("div").children("img").unbind("click").bind("click", function(e){
                var editor = data.editor;
                // Get the entered name
                var html = $(this).clone().removeAttr('height').wrap('<div>').parent().html();
                editor.execCommand(data.command, html, null);
                // Hide the popup and set focus back to the editor
                editor.hidePopups();
                editor.focus();
            });
            $(data.popup).children(":button").unbind("click").bind("click", function(e){
                var editor = data.editor;
                // Get the entered name
                var text = $(data.popup).find(":text");
                var url = $.trim(text.val());
                if (url !== "") {
                    editor.execCommand('insertimage', url, null, data.button);
                }
                // Reset the text, hide the popup and set focus
                text.val("http://");
                // Hide the popup and set focus back to the editor
                editor.hidePopups();
                editor.focus();
            });
        }
    };
    // replace original image button
    $.cleditor.defaultOptions.controls = $.cleditor.defaultOptions.controls
        .replace("image", "inlineimage");
})(jQuery);

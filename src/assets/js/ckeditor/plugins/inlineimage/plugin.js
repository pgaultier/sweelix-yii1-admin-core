/**
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 */
CKEDITOR.plugins.add( 'inlineimage',
{
	requires : [ 'dialog' ],

	init : function( editor )
	{
		var pluginName = 'inlineimage';
		CKEDITOR.dialog.add(pluginName, this.path + 'dialogs/inlineimage.js');
		editor.addCommand( pluginName, new CKEDITOR.dialogCommand(pluginName));
		editor.ui.addButton( 'Inlineimage',
			{
				label : 'Inline image',
				icon : this.path+'/images/icon.png',
				command : pluginName
			});
	}
} );

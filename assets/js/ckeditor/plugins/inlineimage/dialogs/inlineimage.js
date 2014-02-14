/**
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 */
CKEDITOR.dialog.add( 'inlineimage', function( editor )
{
	var config = editor.config;
	
	//	lang = editor.lang.inlineimage,
	//	i;
	/**
	 * Simulate "this" of a dialog for non-dialog events.
	 * @type {CKEDITOR.dialog}
	 */
	var dialog;
	var onClick = function( evt )
	{
		var target = evt.data.getTarget(),
			targetName = target.getName();

		if ( targetName == 'a' )
			target = target.getChild( 0 );
		else if ( targetName != 'img' )
			return;
		var img = editor.document.createElement( 'img',
			{
				attributes :
				{
					src : target.getAttribute( 'src' ),
					'data-store' : target.getAttribute('data-store'),
					'data-offset' : target.getAttribute('data-offset'),
					title : '',
					alt : ''
				}
			});

		editor.insertElement( img );

		dialog.hide();
		evt.data.preventDefault();
	};



	// Build the HTML for the smiley images table.
	var labelId = CKEDITOR.tools.getNextId() + '_inlineimage_label';
	var html =
	[
		'<div style="white-space:normal;">' +
		'<span id="' + labelId + '" class="cke_voice_label">lang.options</span>',
	];
	var store ='';
	var offset=0;
	jQuery('a.wysiwygimage img').each(function(i,el){
		if(store != jQuery(el).parent('a').data('store')) {
			store = jQuery(el).parent('a').data('store');
			offset = 0;
		}
		html.push( ' <img data-store="'+jQuery(el).parent('a').data('store')+'" data-offset="'+i+'" src="'+jQuery(el).parent('a').attr('href')+'" style="height:20px" /> ');
		offset++;
	});

	html.push( '</div>' );

	var inlineImageSelector =
	{
		type : 'html',
		id : 'inlineImage',
		html : html.join( '' ),
		onLoad : function( event )
		{
			dialog = event.sender;
		},
		onClick : onClick,
		style : 'width: 100%; border-collapse: separate;'
	};

	return {
		title : 'Images',
		minWidth : 270,
		minHeight : 120,
		contents : [
			{
				id : 'tab1',
				label : '',
				title : '',
				expand : true,
				padding : 0,
				elements : [
				           inlineImageSelector
					]
			}
		],
		buttons : [ CKEDITOR.dialog.cancelButton ]
	};
} );

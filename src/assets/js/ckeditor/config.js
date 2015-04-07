/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'inlineimage';
	config.toolbar = 'Full';
	CKEDITOR.config.toolbar_Basic = [
		[ 'Source', '-', 'Bold', 'Italic', '-', 'Inlineimage' ]
	];
	CKEDITOR.config.stylesSet = [
		// Block-level styles
		// { name : 'Blue Title', element : 'h2', styles : { 'color' : 'Blue' } },
		// { name : 'Red Title' , element : 'h3', styles : { 'color' : 'Red' } },
	                         
		// Inline styles
		// { name : 'CSS Style', element : 'span', attributes : { 'class' : 'my_style' } },
		// { name : 'Marker: Yellow', element : 'span', styles : { 'background-color' : 'Yellow' } }
	] ;	
	CKEDITOR.config.toolbar_Full = [
		['Source','-','Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['Link','Unlink','Anchor'],
		['Inlineimage','Table','HorizontalRule','SpecialChar'],
		'/',
		// ['Styles','Format','FontSize'],
		['Format','FontSize'],
	]; 
};

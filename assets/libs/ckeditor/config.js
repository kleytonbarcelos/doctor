/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};

$(function()
{
	$('.ckeditor-basic').ckeditor(function()
	{

	},
	{
		extraPlugins:'autogrow',
		//skin: 'office2013',
		//removePlugins : 'elementspath',
		//resize_enabled : false,
		toolbar : [
			['Bold', 'Italic', 'Underline', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Indent', 'Outdent', '-', 'Undo', 'Redo', '-', 'Maximize']
		],
	});
});

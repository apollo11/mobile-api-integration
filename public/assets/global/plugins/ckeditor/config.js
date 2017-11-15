/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.toolbar = [
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
		'/',
		{ name: 'links', items: [ 'Link', 'Unlink' ] },
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		'/',
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'insert', items: [ 'Table', 'HorizontalRule',  'SpecialChar'] },
		{ name: 'tools', items: [ 'ShowBlocks' ] },
		{ name: 'document', items: [ 'Source' ] },
	];
	config.allowedContent = true;
};

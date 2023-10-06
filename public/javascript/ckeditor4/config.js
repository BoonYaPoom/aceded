/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'th';
	 config.enterMode = CKEDITOR.ENTER_BR;
     config.shiftEnterMode = CKEDITOR.ENTER_P;
	 config.uiColor = '#F09BA4';
	 config.filebrowserBrowseUrl = '//e-learning.ago.go.th/admin/vendor/ckeditor4/plugins/ajaxfilemanager/ajaxfilemanager.php';
	 config.filebrowserImageBrowseUrl = '//e-learning.ago.go.th/admin/vendor/ckeditor4/plugins/ajaxfilemanager/ajaxfilemanager.php';
	 config.filebrowserFlashBrowseUrl = '//e-learning.ago.go.th/admin/vendor/ckeditor4/plugins/ajaxfilemanager/ajaxfilemanager.php';
	 config.removePlugins = 'about,flash,font';
	// This is actually the default value.
	/*config.toolbar =
	[
		{ name: 'document', items: [ 'mode', 'document', 'doctools' ] },
		{ name: 'basicstyles', items : ['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert',      items : [ 'Image','Youtube','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
		{ name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors',      items : [ 'TextColor','BGColor' ] }
	];*/
	 //config.extraPlugins = 'youtube';
};

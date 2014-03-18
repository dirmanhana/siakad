/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.width = '800px';
        //config.removePlugins = 'sourcearea,save,newpage,preview,print,templates,scayt,wsc,forms,language,maximize,showblocks';
        // Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
        config.toolbar = [
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection' ], items: [ 'Find', 'Replace', '-', 'SelectAll' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe' ] },
                '/',
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'others', items: [ '-' ] },
                { name: 'about', items: [ 'About' ] }
        ];

        // Toolbar groups configuration.
        config.toolbarGroups = [
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection' ] },
                { name: 'links' },
                { name: 'insert' },
                '/',
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                '/',
                { name: 'styles' },
                { name: 'colors' },
                { name: 'others' },
                { name: 'about' }
        ];
        
        config.filebrowserBrowseUrl = '/sisforun/kcfinder/browse.php?type=files';
        config.filebrowserImageBrowseUrl = '/sisforun/kcfinder/browse.php?type=images';
        config.filebrowserFlashBrowseUrl = '/sisforun/kcfinder/browse.php?type=flash';
        config.filebrowserUploadUrl = '/sisforun/kcfinder/upload.php?type=files';
        config.filebrowserImageUploadUrl = '/sisforun/kcfinder/upload.php?type=images';
        config.filebrowserFlashUploadUrl = '/sisforun/kcfinder/upload.php?type=flash';
};

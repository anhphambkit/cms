<?php 

return [
	'admin-assets' => [
		/* js */
		'vendors-js'               => ['theme' => 'app-assets/vendors/js/vendors.min.js'],
		'app-menu-js'              => ['theme' => 'app-assets/js/core/app-menu.js'],
		'app-js'                   => ['theme' => 'app-assets/js/core/app.js'],
		'jquery-tree-js'           => ['theme' => 'plugins/jquery-tree/jquery.tree.min.js'],
		'toastr-js'                => ['theme' => 'plugins/toastr/toastr.min.js'],
		'jquery-ui-js'             => ['theme' => 'plugins/jquery-ui/jquery-ui.min.js'],
		'uniform-js'               => ['theme' => 'plugins/uniform/jquery.uniform.min.js'],
		'editable-js'              => ['theme' => 'plugins/bootstrap-editable/bootstrap-editable.min.js'],
		'bootstrap-datepicker-js'  => ['theme' => 'plugins/bootstrap-datepicker/bootstrap-datepicker.min.js'],
		'jquery-mask-js'           => ['theme' => 'plugins/jquery-mask-js/jquery.mask.js'],
		'datatable-js'             => ['theme' => 'app-assets/vendors/js/tables/datatable/datatables.min.js'],
		'datatable-button-js'      => ['theme' => 'app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js'],
		'editor-js'                => ['cdn' => 'backend/core/base/assets/js/editor.js'],
		'ckeditor-js'              => ['theme' => 'app-assets/vendors/js/editors/ckeditor/ckeditor.js'],
		'tinymce-js'               => ['theme' => 'app-assets/vendors/js/editors/tinymce/tinymce.js'],
		'slug-js'                  => ['cdn' => 'backend/core/slug/assets/js/slug.js'],
		'inputtag-js'              => ['cdn' => 'backend/core/base/packages/bootstrap-tagsinput/bootstrap-tagsinput.min.js'],
		'pickadate-picker-js'      => ['theme' => 'plugins/pickers/js/pickadate/picker.js'],
		'pickadate-picker-date-js' => ['theme' => 'plugins/pickers/js/pickadate/picker.date.js'],
		'datetime-js'              => ['theme' => 'plugins/pickers/cdn/dateTime/pick-a-datetime.js'],
		'daterangepicker-js'              => ['theme' => 'plugins/pickers/js/daterange/daterangepicker.js'],
 
		/* css */
		'vendors-css'              => ['theme' => 'app-assets/css/vendors.css'],
		'bootstrap-css'              => ['theme' => 'app-assets/css/bootstrap.css'],
		'bootstrap-extended-css'              => ['theme' => 'app-assets/css/bootstrap-extended.css'],
		'vertical-menu-modern-css' => ['theme' => 'app-assets/css/core/menu/menu-types/vertical-menu-modern.css'],
		'palette-gradient-css'     => ['theme' => 'app-assets/css/core/colors/palette-gradient.css'],
		'app-css'                  => ['theme' => 'app-assets/css/app.css'],
		'cms-style-css'            => ['theme' => 'assets/css/style.css'],
		'cms-core-css'             => ['theme' => 'assets/css/core.css'],
		'jquery-tree-css'          => ['theme' => 'plugins/jquery-tree/jquery.tree.min.css'],
		'toastr-css'               => ['theme' => 'plugins/toastr/toastr.min.css'],
		'jquery-ui-css'            => ['theme' => 'plugins/jquery-ui/jquery-ui.min.css'],
		'editable-css'             => ['theme' => 'plugins/bootstrap-editable/bootstrap-editable.css'],
		'bootstrap-datepicker-css' => ['theme' => 'plugins/bootstrap-datepicker/bootstrap-datepicker.min.css'],
		'datatable-css'            => ['theme' => 'app-assets/vendors/css/tables/datatable/datatables.min.css'],
		'datatable-button-css'     => ['theme' => 'app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css'],
		'inputtag-css'             => ['cdn' => 'backend/core/base/packages/bootstrap-tagsinput/bootstrap-tagsinput.css'],
		'daterangepicker-css'      => ['theme' => 'plugins/pickers/css/daterange/daterangepicker.css'],
		'pickadate-css'            => ['theme' => 'plugins/pickers/css/pickadate/pickadate.css'],
		'cnddaterange-css'         => ['theme' => 'plugins/pickers/cdn/daterange/daterange.css'],
	],

	'frontend-assets' => [
		/* js */
		'vendor-js'      => ['theme' => "assets/js/style.min.js"],
		'base-script-js' => ['cdn' => 'frontend/core/base/assets/js/script.js'],
		'toastr-js'      => ['cdn' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js'],

		/* css */
		'vendor-css' => ['theme' => 'assets/css/style.min.css'],
		'loading-css' => ['cdn' => 'frontend/core/base/assets/css/loading-component.css'],
		'cart-css' => ['cdn' => 'frontend/plugins/cart/assets/css/cart.css'],
		'toastr-css' => ['cdn' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css'],
	],

	'frontend-required-assets' => [
		'css' => [
			'vendor-css',
			'toastr-css',
			'loading-css',
			'cart-css',
		],
		'js' => [
			'vendor-js',
			'toastr-js',
			'base-script-js'
		]
	],

	'admin-required-assets' => [
		'css' => [
			'vendors-css'  ,    
//			'bootstrap-css',
//			'bootstrap-extended-css',
			'datatable-css',
			'vertical-menu-modern-css' ,
			'palette-gradient-css' ,    
			'app-css'    ,              
			'cms-style-css',
			'toastr-css',
			'jquery-ui-css',
			'cms-core-css',
			'datatable-button-css',
			'inputtag-css',
		],
		'js' => [
			'vendors-js' ,
			'app-menu-js',
			'app-js'   ,
			'toastr-js',
			'jquery-ui-js',
			'uniform-js',
			'jquery-mask-js',
			'datatable-js',
			'datatable-button-js',
			'editor-js',
			'slug-js',
			'inputtag-js',
		]
	]

];



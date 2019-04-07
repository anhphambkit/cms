<?php 

return [
	'admin-assets' => [
		/* js */
		'vendors-js'              => ['theme' => 'app-assets/vendors/js/vendors.min.js'],
		'app-menu-js'             => ['theme' => 'app-assets/js/core/app-menu.js'],
		'app-js'                  => ['theme' => 'app-assets/js/core/app.js'],
		'jquery-tree-js'          => ['theme' => 'plugins/jquery-tree/jquery.tree.min.js'],
		'toastr-js'               => ['theme' => 'plugins/toastr/toastr.min.js'],
		'jquery-ui-js'            => ['theme' => 'plugins/jquery-ui/jquery-ui.min.js'],
		'uniform-js'              => ['theme' => 'plugins/uniform/jquery.uniform.min.js'],
		'editable-js'             => ['theme' => 'plugins/bootstrap-editable/bootstrap-editable.min.js'],
		'bootstrap-datepicker-js' => ['theme' => 'plugins/bootstrap-datepicker/bootstrap-datepicker.min.js'],
		'jquery-mask-js'          => ['theme' => 'plugins/jquery-mask-js/jquery.mask.js'],
		'datatable-js'            => ['theme' => 'app-assets/vendors/js/tables/datatable/datatables.min.js'],
		'datatable-button-js'     => ['theme' => 'app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js'],
		'editor-js'               => ['cdn' => 'backend/core/base/assets/js/editor.js'],
		'ckeditor-js'             => ['theme' => 'app-assets/vendors/js/editors/ckeditor/ckeditor.js'],
		'tinymce-js'              => ['theme' => 'app-assets/vendors/js/editors/tinymce/tinymce.js'],

		/* css */
		'vendors-css'              => ['theme' => 'app-assets/css/vendors.css'],
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
	],

	'frontend-assets' => [
		/* js */
		'jquery-js'         => ['theme' => "libs/jquery/jquery.min.js"],
		'popper-js'         => ['theme' => "libs/popper/popper.min.js"],
		'response-js'       => ['theme' => "libs/responsejs/response.min.js"],
		'loadingoverlay-js' => ['theme' => "libs/loading-overlay/loadingoverlay.min.js"],
		'tether-js'         => ['theme' => "libs/tether/js/tether.min.js"],
		'bootstrap-js'      => ['theme' => "libs/bootstrap/js/bootstrap.min.js"],
		'jscrollpane-js'    => ['theme' => "libs/jscrollpane/jquery.jscrollpane.min.js"],
		'mousewheel-js'     => ['theme' => "libs/jscrollpane/jquery.mousewheel.js"],
		'flexibility-js'    => ['theme' => "libs/flexibility/flexibility.js"],
		'noty-js'           => ['theme' => "libs/noty/noty.min.js"],
		'velocity-js'       => ['theme' => "libs/velocity/velocity.min.js"],
		'common-js'         => ['theme' => "assets/scripts/common.min.js"],
		'd3-js'             => ['theme' => 'libs/d3/d3.min.js'],
		'c3-js'             => ['theme' => 'libs/c3js/c3.min.js'],
		'maplace-js'        => ['theme' => 'libs/maplace/maplace.min.js'],

		/* css */
		'kosmo-styles-css'      => ['theme' => 'assets/fonts/kosmo/styles.css'],
		'weather-icons-css'     => ['theme' => 'assets/fonts/weather/css/weather-icons.min.css'],
		'c3-css'                => ['theme' => 'libs/c3js/c3.min.css'],
		'noty-css'              => ['theme' => 'libs/noty/noty.css'],
		'payment-css'           => ['theme' => 'assets/styles/widgets/payment.min.css'],
		'panels-css'            => ['theme' => 'assets/styles/widgets/panels.min.css'],
		'tabbed-sidebar-css'    => ['theme' => 'assets/styles/dashboard/tabbed-sidebar.min.css'],
		'bootstrap-css'         => ['theme' => 'libs/bootstrap/css/bootstrap.min.css'],
		'line-awesome-css'      => ['theme' => 'assets/fonts/line-awesome/css/line-awesome.min.css'],
		'open-sans-styles-css'  => ['theme' => 'assets/fonts/open-sans/styles.css'],
		'montserrat-styles-css' => ['theme' => 'assets/fonts/montserrat/styles.css'],
		'tether-css'            => ['theme' => 'libs/tether/css/tether.min.css'],
		'jscrollpane-css'       => ['theme' => 'libs/jscrollpane/jquery.jscrollpane.css'],
		'flag-icon-css'         => ['theme' => 'libs/flag-icon-css/css/flag-icon.min.css'],
		'common-css'            => ['theme' => 'assets/styles/common.min.css'],
		'primary-css'           => ['theme' => 'assets/styles/themes/primary.min.css'],
		'sidebar-black-css'     => ['theme' => 'assets/styles/themes/sidebar-black.min.css'],
	],

	'frontend-required-assets' => [
		'css' => [
			'kosmo-styles-css'  ,
			'weather-icons-css' ,
			'c3-css'            ,
			'noty-css'          ,
			'payment-css'       ,
			'panels-css'        ,
			'tabbed-sidebar-css',
			'bootstrap-css',
			'line-awesome-css',
			'open-sans-styles-css',
			'montserrat-styles-css',
			'tether-css',
			'jscrollpane-css',
			'flag-icon-css',
			'common-css',
			'primary-css',
			'sidebar-black-css',
		],
		'js' => [
			'jquery-js'        ,
			'popper-js'        ,
			'tether-js'        ,
			'bootstrap-js'     ,
            'response-js'      ,
            'loadingoverlay-js',
			'jscrollpane-js'   ,
			'mousewheel-js'    ,
			'flexibility-js'   ,
			'velocity-js'      ,
			'common-js'        ,
			'd3-js'            ,
			'c3-js'            ,
			'noty-js'          ,
			'maplace-js'       ,
		]
	],

	'admin-required-assets' => [
		'css' => [
			'vendors-css'  ,    
			'datatable-css',        
			'vertical-menu-modern-css' ,
			'palette-gradient-css' ,    
			'app-css'    ,              
			'cms-style-css',
			'toastr-css',
			'jquery-ui-css',
			'cms-core-css',
			'datatable-button-css'     
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
			'editor-js'
		]
	]

];



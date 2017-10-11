<?php

namespace backend\assets;

use yii\web\AssetBundle;
use FortAwesome\FontAwesome;
use driftyco\ionicons;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	//practica 39 y 40
		//http://localhost/themes/AdminLTE-2.3.11/
		
        'css/bootstrap.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
		'fonts/font-awesome.min.css',
	//	'code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
		'fonts/ionicons.min.css',
		 
		'css/AdminLTE.min.css',
		'css/skins/_all-skins.min.css',
		'plugins/iCheck/flat/blue.css',
		'css/site.css',
    ];
    public $js = [
	
	'js/bootstrap/bootstrap.min.js',
//	'//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
//	'jquery-ui.min.js',
//	'//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
	'js/raphael-min.js',
	
	'plugins/sparkline/jquery.sparkline.min.js',
	'plugins/slimScroll/jquery.slimScroll.min.js',
	'plugins/fastclick/fastclick.min.js',
	'js/app.min.js',
	//'js/dashboard.js',
	'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

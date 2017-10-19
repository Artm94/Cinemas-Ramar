<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        'plugins/daterangepicker/daterangepicker.css',
        //'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',
        'css/site.css',
        'css/tables.css',
    ];
    public $js = [
    'js/bootstrap/bootstrap.min.js',
    '//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
    '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
    'plugins/sparkline/jquery.sparkline.min.js',
    //'plugins/slimScroll/jquery.slimscroll.min.js',
    'plugins/fastclick/fastclick.min.js',
    'js/app.min.js',
    //'plugins/daterangepicker/moment.min.js',
    //'plugins/daterangepicker/daterangepicker.js',
    //'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
    //'plugins/knob/jquery.knob.js',
    //'js/dashboard.js',
    'js/main.js',
    'js/alerts.js',
    '//cdn.conekta.io/js/latest/conekta.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
<?php 
namespace frontend\assets;

use yii\web\AssetBundle;

class SignupAsset extends AssetBundle{
	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/signup.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
 ?>

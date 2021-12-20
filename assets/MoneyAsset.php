<?php

namespace app\assets;

use yii\web\AssetBundle;

class MoneyAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/v-money.js'
    ];
}
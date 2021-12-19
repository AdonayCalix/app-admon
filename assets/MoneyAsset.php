<?php

namespace app\assets;

use yii\web\AssetBundle;

class MoneyAsset extends AssetBundle
{
    public $sourcePath = "@npm/v-money/dist";

    public $js = [
        'v-money.js'
    ];
}
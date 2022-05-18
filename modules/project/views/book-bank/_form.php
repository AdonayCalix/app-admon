<?php

use app\assets\VueSelectAsset;
use mootensai\components\JsBlock;
use yii\helpers\Html;
use yii\web\View;


/* @var $this yii\web\View */

$this->title = 'Generar Libro de Banco';
$this->params['breadcrumbs'][] = $this->title;

VueSelectAsset::register($this);
JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);
?>
<div class="book-bnak">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">

            <div id="book-bank">
                <div class="row">
                    <div class="col-md-3">
                        <label for=""><strong>Proyecto</strong></label>
                        <treeselect v-model="project_id" :multiple="false" placeholder="[SELECCIONE]"
                                    :options="project_list"/>
                    </div>
                    <div class="col-md-3">
                        <label for=""><strong>Mes</strong></label>
                        <treeselect v-model="month" :multiple="false" placeholder="[SELECCIONE]" :options="month_list"/>
                    </div>
                    <div class="col-md-3">
                        <label for=""><strong>Año</strong></label>
                        <treeselect v-model="year" :multiple="false" placeholder="[SELECCIONE]" :options="year_list"/>
                    </div>
                    <div class="col align-content-center" style="margin-top: 10px">
                        <br>
                        <button class="btn btn-success btn-sm" v-on:click="download">
                           Generar
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

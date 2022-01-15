<?php

use app\assets\VueSelectAsset;
use mootensai\components\JsBlock;
use yii\helpers\Html;
use yii\web\View;


/* @var $this yii\web\View */

$this->title = 'Generar Formato Financiero V2';
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

            <div id="financial-format">
                <div class="row">
                    <div class="col-md-3">
                        <label for=""><strong>Proyecto</strong></label>
                        <treeselect v-model="project_id" :multiple="false" placeholder="[SELECCIONE]"
                                    :options="project_list"/>
                    </div>
                    <div class="col-md-3">
                        <label for=""><strong>Presupuesto</strong></label>
                        <treeselect v-model="budget_id" :multiple="false" placeholder="[SELECCIONE]" :options="budget_list"/>
                    </div>
                    <div class="col-md-3">
                        <label for=""><strong>Periodo</strong></label>
                        <treeselect v-model="period_id" :multiple="false" placeholder="[SELECCIONE]" :options="period_list"/>
                    </div>
                    <div class="col align-content-center">
                        <br>
                        <button class="btn btn-success" v-on:click="download">
                            Generar
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

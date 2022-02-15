<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:31 PM
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Employee Induction Document.';
$this->params['breadcrumbs'][] = ['label' => 'Grievances List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Grievance card', 'url' => ['update','Key' => $model->Key]];

?>
<div class="agenda-document-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form',[
        'model' => $model,
        'document' => $document,
        'employees' => $employees,
        'complaintTypes' => $complaintTypes
    ]) ?>

</div>

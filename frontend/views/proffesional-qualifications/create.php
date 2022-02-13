<?php
use yii\helpers\Html;
$this->title = 'Add Proffesional Certification';
$this->params['breadcrumbs'][] = ['label' => 'New Qualification', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-document-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'ProffesionalExaminers'=>$ProffesionalExaminers



    ]) ?>

</div>

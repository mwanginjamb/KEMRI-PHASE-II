<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:29 PM
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Add Line';

$this->params['breadcrumbs'][] = $this->title;


$model->isNewRecord = true;

?>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
  




<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */

use yii\bootstrap4\Html;

/* @var $this yii\web\View */

$this->title = 'HRMIS - Candidate Succession Evaluation';
$this->params['breadcrumbs'][] = ['label' => 'Candidate Succession Evaluation', 'url' => ['evaluation-list']];
// $this->params['breadcrumbs'][] = ['label' => 'Approved Appraisals List', 'url' => ['approvedappraisals']];

//Yii::$app->recruitment->printrr($model);

?>


<?php
if(Yii::$app->session->hasFlash('success')){
    print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}else if(Yii::$app->session->hasFlash('error')){
    print ' <div class="alert alert-danger alert-dismissable">
 
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
//Yii::$app->recruitment->printrr($model);
?>

<!-- Actions -->

<div class="row">
    <div class="container">

            <?= Html::a('<i class="fas fa-forward"></i> submit',['submit-plan'],['class' => 'btn btn-app bg-success submitforapproval',
                        'data' => [
                                'confirm' => 'Are you sure you want to submit this succession plan ?',
                                'params' => [
                                    'successionNo' => is_array($model)?$model[0]->Succession_No:'',
                                    'employeeNo' => is_array($model)?$model[0]->Employee_No:''
                                ],
                                'method' => 'post',
                            ],
                        'title' => 'Submit succession plan.'

            ]) ?>


    </div>
</div>

<!-- Actions -->


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Candidate Succession Evaluation List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" >


                        <thead>
                            <tr>
                                <td class="text-bold">Evaluation_No</td>
                                <td class="text-bold">Succession_No</td>
                                <!-- <td class="text-bold">Employee_No</td> -->
                                <td class="text-bold">Employee_Name</td>
                                <td class="text-bold">Question</td>
                                <td class="text-bold text-info">Answer</td>
                                <!-- <td class="text-bold">Preferred_Answer</td>
                                <td class="text-bold">Recomendation</td>
                                <td class="text-bold">Candidate_Status</td>
                                <td class="text-bold">Evaluator_Status</td> -->
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($model as $record):
                                if(empty($record->Succession_No)){
                                    continue;
                                }
                                ?>

                                <tr>
                                    <td><?= !empty($record->Evaluation_No)?$record->Evaluation_No:'' ?></td>
                                    <td><?= !empty($record->Succession_No)?$record->Succession_No:'' ?></td>
                                   
                                    <td><?= !empty($record->Employee_Name)?$record->Employee_Name:'' ?></td>
                                    <td><?= !empty($record->Question)?$record->Question:'' ?></td>
                                    <td data-key="<?= $record->Key ?>" data-name="Answer" data-service="SuccessionEvaluationList" ondblclick="addDropDown(this,'answers')"><?= $record->Answer ?></td>
                                    <!-- <td><?= $record->Preferred_Answer ?></td>
                                    <td><?= $record->Recomendation ?></td>
                                    <td><?= $record->Candidate_Status ?></td>
                                    <td><?= $record->Evaluator_Status ?></td> -->
                                </tr>

                            <?php endforeach; ?>
                        </tbody>


                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<?php

$script = <<<JS

    $(function(){
        
        
       
    });
        
JS;

$this->registerJs($script);







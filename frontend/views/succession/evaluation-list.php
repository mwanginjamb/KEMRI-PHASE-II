<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



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
?>
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
                                <td class="text-bold">Preferred_Answer</td>
                                <td class="text-bold">Recomendation</td>
                                <td class="text-bold">Candidate_Status</td>
                                <td class="text-bold">Evaluator_Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($model as $record): ?>

                                <tr>
                                    <td><?= $record->Evaluation_No ?></td>
                                    <td><?= $record->Succession_No ?></td>
                                    <!-- <td><?= $record->Employee_No ?></td> -->
                                    <td><?= $record->Employee_Name ?></td>
                                    <td><?= $record->Question ?></td>
                                    <td data-key="<?= $record->Key ?>" data-name="Answer" data-service="SuccessionEvaluationList" ondblclick="addDropDown(this,'answers')"><?= $record->Answer ?></td>
                                    <td><?= $record->Preferred_Answer ?></td>
                                    <td><?= $record->Recomendation ?></td>
                                    <td><?= $record->Candidate_Status ?></td>
                                    <td><?= $record->Evaluator_Status ?></td>
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







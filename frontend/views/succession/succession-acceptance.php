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
?>

<!-- Actions -->

<div class="row">
    <div class="container">

            <?= ($model[0]->Status  == 'New')? Html::a('<i class="fas fa-forward"></i> Accept',['accept-plan'],['class' => 'btn btn-app bg-success submitforapproval',
                        'data' => [
                                'confirm' => 'Are you sure you want to accept this succession planning step ?',
                                'params' => [
                                    'empNo' =>  $model[0]->Employee_No,
                                    'lineNo' => $model[0]->Line_No
                                ],
                                'method' => 'post',
                            ],
                        'title' => 'Accept succession plan.'

            ]): '' ?>

        <?= ($model[0]->Status  == 'New')? Html::a('<i class="fas fa-forward"></i> Reject',['reject-plan'],['class' => 'btn btn-app bg-success submitforapproval',
                        'data' => [
                                'confirm' => 'Are you sure you want to accept this succession planning step ?',
                                'params' => [
                                    'empNo' =>  $model[0]->Employee_No,
                                    'lineNo' => $model[0]->Line_No
                                ],
                                'method' => 'post',
                            ],
                        'title' => 'Accept succession plan.'

            ]): '' ?>


    </div>
</div>

<!-- Actions -->


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Candidate Succession Acceptance List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover " id="succession" >


                        <thead>
                            <tr>
                                
                                <td class="text-bold">Succession_No</td>
                                <td class="text-bold">Employee_Name</td>
                                <td class="text-bold">Status</td>
                                <td class="text-bold">Rejection_Comments</td>
                                <td class="text-bold">Succession_Job</td>
                                
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($model as $record): ?>

                                <tr>
                                    <td><?= $record->Succession_No ?></td>
                                    <td><?= $record->Employee_Name ?></td>
                                    <td><?= $record->Status ?></td>
                                    <td><?= !empty($record->Rejection_Comments)?$record->Rejection_Comments:'' ?></td>
                                    <td><?= !empty($record->Succession_Job )?$record->Succession_Job :'' ?></td>
                    
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
        var absolute = $('input[name=absolute]').val();
         /*Data Tables*/
         
         $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#appraisal').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'succession/list-acceptance',
            paging: true,
            columns: [
                { title: 'Succession_No' ,data: 'Succession_No'},
                { title: 'Employee_Name' ,data: 'Employee_Name'},
                { title: 'Status' ,data: 'Status'},
                { title: 'Rejection_Comments' ,data: 'Job_Title'},
                { title: 'Succession_Job' ,data: 'Succession_Job'},
                
                
               
            ] ,                              
           language: {
                "zeroRecords": "No records to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#appraisal').DataTable();
       table.columns([3]).visible(false);
    
    
    });
        
JS;

$this->registerJs($script);







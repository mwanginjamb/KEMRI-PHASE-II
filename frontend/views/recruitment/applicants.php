<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);
$this->title = $model->Job_Description . ' Applicants '
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">

                <?= Html::a('<i class="fas fa-check"></i> Submit Interview Assesment',['submit-assesment','ComiteeID'=> $model->No,],[
                    
                    'class' => 'mx-1 btn btn-app bg-success ',
                    'rel' => '',
                    'rev' =>'',
                    'title' => 'Reject KRAs and Send them Back to Appraisee.',
                ]
                ) ?>

                <?php

                    $form = ActiveForm::begin([
                            'id' => $model->formName()
                    ]);

                        if(Yii::$app->session->hasFlash('success')){
                            print ' <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h5><i class="icon fas fa-check"></i> Success!</h5>';
                            echo Yii::$app->session->getFlash('success');
                            print '</div>';
                        }else if(Yii::$app->session->hasFlash('error')){
                            print ' <div class="alert alert-danger alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h5><i class="icon fas fa-times"></i> Error!</h5>
                                                ';
                            echo Yii::$app->session->getFlash('error');
                            print '</div>';
                    }

                ?>

                <div class="row">
                    <div class="row col-md-12">
                        <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                        <div class="col-md-6">

                            <?= $form->field($model, 'Job_Description')->textInput(['readonly' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Requisition_Purpose')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        </div>
                    </div>

                </div>

                <hr>
                <h3> Applicants </h3>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered dt-responsive table-hover" id="requistions">
                        </table>
                    </div>
                </div>



                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>



    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Imprest Management</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>
<input type="hidden" id="ab" value="<?= $absoluteUrl ?>">
<input type="hidden" id="committeeId" value="<?= $model->No ?>">

<?php
$script = <<<JS

        $(function(){
                /*Data Tables*/
                var absolute = $('#ab').val();               
            
                $('#requistions').DataTable({
                    //serverSide: true,  
                    ajax: absolute +'recruitment/get-applicants?committeeId='+$('#committeeId').val(),
                    paging: true,
                    columns: [
                        { title: 'Applicant Name' ,data: 'ApplicantName'},
                        { title: 'Shortlisting Status' ,data: 'Shotlisting Status'},
                        { title: 'Action' ,data: 'Action'},
                        
                    ] ,                              
                    language: {
                            "zeroRecords": "No Applicants Found"
                        },
                        
                        order : [[ 0, "desc" ]]
                });

                     
                /* Add Line */
                $('.add-line').on('click', function(e){
                        e.preventDefault();
                    var url = $(this).attr('href');
                    console.log(url);
                    $('.modal').modal('show')
                                    .find('.modal-body')
                                    .load(url); 

                });
                
                /*Handle modal dismissal event  */
                $('.modal').on('hidden.bs.modal',function(){
                    var reld = location.reload(true);
                    setTimeout(reld,1000);
                }); 
        });

     
     
    
JS;

$this->registerJs($script);

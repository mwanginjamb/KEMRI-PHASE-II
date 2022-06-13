<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\widgets\ActiveForm;
//$this->title = 'AAS - Employee Profile'
// echo '<pre>';
// print_r($Questions);
// exit;
?>
             <?= $this->render('_steps', ['model'=>$model]) ?>
             <div class="row">
                    <div class="col-md-6"> 

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Personal Details</h3>
                            </div>
                            <div class="card-body">
                                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                                <?= $form->field($model,'Key')->hiddenInput()->label(false) ?>

                                <div class="row">
                                    <div class=" row col-md-12">

                                        <div class="col-md-12">
                                            <?= $form->field($model, 'First_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                            <?= $form->field($model, 'Middle_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                            <?= $form->field($model, 'Last_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                            <?= $form->field($model, 'Marital_Status')->dropDownList([
                                                'Single' => 'Single',
                                                'Married' => 'Married',
                                                'Separated' => 'Separated',
                                                'Divorced' => 'Divorced',
                                                'Widow_er' => 'Widow_er',
                                                'Other' => 'Other'
                                            ],['prompt' => 'Select Status', 'disabled'=>true]) ?>
                                        </div>

                                    </div>
                                </div>
                        </div> 
                        </div>
                        
                       
                    </div>

                       <div class="col-md-6"> 
                            <?= $this->render('questions', ['Questions'=>$Questions, 'getInterviewRatings'=>$getInterviewRatings]) ?>
                        </div>
                        
                       
                    </div>

                    

                    <?php ActiveForm::end(); ?>
    </div>
<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<input type="hidden" name="ProfileNo" value="<?= $model->No ?>">
</div>

<?php
$script = <<<JS

            var absolute = $('input[name=absolute]').val();


           $('.ScoresTable').on('change', '.Score', function(){ 
                var currentrow = $(this).closest('tr');
                var Score = currentrow.find('.Score').val();
                var Key = currentrow.find('.Key').val(); 

                if(Score){ //Ensure No Blanks
                       //Submit Score
                    var commurl = absolute+'interviews/score';
                    $.post(commurl,{'Key': Key,'Score':Score,},function(data){
                        if(data.length){
                            Swal.fire("Warning", data , "warning");;
                            return false;
                        }
                            //Set Value of LineKey
                            var j = data.key;
                            $('.NewLineModal').find('#linekey').val(j);
                            $('.NewLineModal').find('.amount_usd').val(data.Additional_Reporting_Currency);
                            $('.NewLineModal').find('.gfbudget').val(data.Available_Amount);
                            $('.NewLineModal').find('#linenumber').val(data.linenumber);
                            $('.NewLineModal').find('.description').val(data.Description);
                            $('.NewLineModal').find('.totalamount').val(data.Amount);
                            $('.NewLineModal').find('.noOfNights').val(data.No_of_Days);
                            // alert(lineKey);
                    });
                }
               
                 
            });
    
  
    
     
JS;

$this->registerJs($script);

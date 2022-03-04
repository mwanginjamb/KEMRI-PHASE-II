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
?>
             <!-- <?= $this->render('_steps') ?> -->
            
             <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Personal Details</h3>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model,'Key')->hiddenInput()->label(false) ?>

                    <div class="row">
                        <div class=" row col-md-12">

                            <div class="col-md-4">
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

                            <div class="col-md-4">

                                <?= $form->field($model, 'Initials')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Full_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Gender')->dropDownList([
                                    '_blank_' => '_blank_',
                                    'Female' => 'Female',
                                    'Male' => 'Male',
                                ],['prompt' => 'Select Gender', 'readonly'=>true]) ?>

                                <?= $form->field($model, 'Birth_Date')->textInput(['type' => 'date', 'readonly'=>true]) ?>


                            </div>

                            <div class="col-md-4">
                                <?= $form->field($model, 'NHIF_Number')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'NSSF_Number')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'KRA_Number')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'National_ID')->textInput(['readonly'=> true]) ?>
                            </div>
                        </div>
                    </div>
              </div> </div>
            

         

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Other Details</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <!-- <div class="col-md-6">

                            <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>
                            <div class="image">
                                <?php if(!empty($model->ImageUrl)){
                                    print '<img src="'.Yii::$app->recruitment->absoluteUrl().$model->ImageUrl.'">';
                                } ?>
                            </div> -->






                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model,'Key')->hiddenInput()->label(false) ?>

                            <!-- <?= $form->field($model, 'Disabled')->checkbox() ?> -->
                            <?= $form->field($model, 'Disabled')->dropDownList([
                                    '1' => 'Yes',
                                    '0' => 'No',
                                ],['prompt' => 'Select ...', 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Describe_Disability')->textInput()->label('Description', ['class'=>'control-label DisabilityLabel', 'readonly'=>true]) ?>
                         


                        </div>
                    </div>
                </div>

             







            </div>
        </div>











        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$script = <<<JS


    $('#applicantprofile-disabled').change((e) => {

      if($('#applicantprofile-disabled').val() == 1){
          $('#applicantprofile-describe_disability').show();
          $('.DisabilityLabel').show();
          return false;
      }
      $('#applicantprofile-describe_disability').hide();
      $('.DisabilityLabel').hide();

      

    }); 
    
  
    
     
JS;

$this->registerJs($script);

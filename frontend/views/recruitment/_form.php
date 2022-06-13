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
             <?= $this->render('_steps', ['model'=>$model]) ?>
            
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

                            <div class="col-md-6">

                                <?= $form->field($model, 'Initials')->textInput(['readonly'=>true]) ?>
                                <?= $form->field($model, 'Full_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Gender')->dropDownList([
                                    '_blank_' => '_blank_',
                                    'Female' => 'Female',
                                    'Male' => 'Male',
                                ],['prompt' => 'Select Gender', 'readonly'=>true]) ?>

                                <?= $form->field($model, 'Birth_Date')->textInput(['type' => 'date', 'readonly'=>true]) ?>


                            </div>

                           
                        </div>
                    </div>
              </div> </div>
            

         
    
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$script = <<<JS

console.log('clicked...')

    $('#applicantprofile-disabled').change((e) => {

      if($('#applicantprofile-disabled').val() == 1){
          $('#applicantprofile-describe_disability').show();
          $('.DisabilityLabel').show();
          return false;
      }
      $('#applicantprofile-describe_disability').hide();
      $('.DisabilityLabel').hide();

     

    });
    
    $('.rejectey').on('click', function(e){
            console.log('clicked...')
            e.preventDefault();
            const form = $('#eyrejform').html(); 
            const ProfileID = $(this).attr('rel');
            const ComitteID = $(this).attr('rev');
                            
            //Display the rejection comment form
            $('.modal').modal('show')
                            .find('.modal-body')
                            .append(form);
            
            //populate relevant input field with code unit required params
                    
            $('input[name=ProfileID]').val(ProfileID);
            $('input[name=ComitteID]').val(ComitteID);
            
            //Submit Rejection form and get results in json    
            $('form#ey-reject-form').on('submit', function(e){
                e.preventDefault()
                const data = $(this).serialize();
                const url = $(this).attr('action');
                $.post(url,data).done(function(msg){
                        $('.modal').modal('show')
                        .find('.modal-body')
                        .html(msg.note);
            
                    },'json');
            });
                       
    });

      /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
    
  
    
     
JS;

$this->registerJs($script);

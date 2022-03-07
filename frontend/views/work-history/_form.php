<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                    <?php  $form = ActiveForm::begin(['id' => 'work-history']);      ?>
                <div class="row">
                   

                            <table class="table">
                                <tbody>

                             <div class="col-md-6">
                                     <?= $form->field($model, 'Work_Done')->textInput(['required' => true]); ?>
                                     <?= $form->field($model, 'Institution_Company')->textInput(['maxlength' => 150]) ?>
                                     <?= $form->field($model, 'From_Date')->textInput(['type' => 'date']) ?>
                                     <?= $form->field($model, 'Reason_For_Leaving')->textInput(['maxlength' => 150]) ?>
                                   
                                   

                            </div>
                             <div class="col-md-6">
                                    <?= $form->field($model, 'Key_Experience')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'Salary_on_Leaving')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'To_Date')->textInput(['type' => 'date']) ?>
                                   

                                    <?= $form->field($model, 'Action')->dropDownList(
                                        ['Existing' => 'Existing','New_Addition' => 'New_Addition'],
                                        ['prompt' => 'Select ...']
                                    ) ?>
                            </div>
                                    <?= $form->field($model, 'Change_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                    

                                </tbody>
                            </table>


                </div>


                <div class="row">

                    <div class="form-group">
                        <?php Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
        $('form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });

        $('#workhistory-key_experience').change((e) => {
                globalFieldUpdate('workhistory','work-history','Key_Experience', e);
        });


        $('#workhistory-salary_on_leaving').change((e) => {
                globalFieldUpdate('workhistory','work-history','Salary_on_Leaving', e);
        });


        $('#workhistory-from_date').blur((e) => {
                globalFieldUpdate('workhistory','work-history','From_Date', e);
        });

        $('#workhistory-to_date').blur((e) => {
                globalFieldUpdate('workhistory','work-history','To_Date', e);
        });

        $('#workhistory-institution_company').change((e) => {
                globalFieldUpdate('workhistory','work-history','Institution_Company', e);
        });

        $('#workhistory-work_done').change((e) => {
                globalFieldUpdate('workhistory','work-history','Work_Done', e);
        });

        $('#workhistory-reason_for_leaving').change((e) => {
                globalFieldUpdate('workhistory','work-history','Reason_For_Leaving', e);
        });

        $('#workhistory-action').change((e) => {
                globalFieldUpdate('workhistory','work-history','Action', e);
        });


JS;

$this->registerJs($script);

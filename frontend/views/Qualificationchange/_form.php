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



                <?php  $form = ActiveForm::begin(['id' => 'qualificationchange']);      ?>
                <div class="row">
                   

                            <table class="table">
                                <tbody>

                             <div class="col-md-6">
                                     <?= $form->field($model, 'Qualification_Code')->dropDownList(
                                        $qualifications,
                                        ['prompt' => 'Select ...']
                                    ) ?>
                                    <?= $form->field($model, 'From_Date')->textInput(['type' => 'date']) ?>
                                   
                                   

                            </div>
                             <div class="col-md-6">
                                    <?= $form->field($model, 'Institution_Company')->textInput(['maxlength' => 150]) ?>
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
 
 $('#qualificationchange-qualification_code').change((e) => {
        globalFieldUpdate('qualificationchange',false,'Qualification_Code', e);
});

$('#qualificationchange-from_date').blur((e) => {
        globalFieldUpdate('qualificationchange',false,'From_Date', e);
});

$('#qualificationchange-to_date').blur((e) => {
        globalFieldUpdate('qualificationchange',false,'To_Date', e);
});

$('#qualificationchange-institution_company').change((e) => {
        globalFieldUpdate('qualificationchange',false,'Institution_Company', e);
});

$('#qualificationchange-action').change((e) => {
        globalFieldUpdate('qualificationchange',false,'Action', e);
});

JS;

$this->registerJs($script);

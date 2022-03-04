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


                    <?php
                    $form = ActiveForm::begin(['id' => 'dependant']); ?>
                        <div class="row">


                                    <div class="col-md-12">
                                            <?= $form->field($model, 'Change_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                            <?= $form->field($model, 'Full_Name')->textInput(['maxlength' => 150]) ?>
                                            <?= $form->field($model, 'ID_Birth_Certificate_No')->textInput(['maxlength' => 100]) ?>
                                            <?= $form->field($model, 'Is_Student')->checkbox() ?>
                                            <?= $form->field($model, 'Date_of_Birth')->textInput(['type' => 'date']) ?>
                                            <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                            <?= $form->field($model, 'Relationship')->dropDownList($relationship,['prompt' => 'Select ...']) ?>
                                            <?= $form->field($model, 'Gender')->dropDownList($model->gender,['prompt' => 'Select ...']); ?>
                                            <?= $form->field($model, 'Key')->hiddenInput(['readonly' => true])->label(false); ?>

                                    </div>

                        </div>

                <div class="row">

                    <div class="form-group">
                        <?php Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id'=>'submit']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>


    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
$('#dependant-full_name').change((e) => {
        globalFieldUpdate('dependant',false,'Full_Name', e);
});

$('#dependant-id_birth_certificate_no').change((e) => {
        globalFieldUpdate('dependant',false,'ID_Birth_Certificate_No', e);
});

$('#dependant-is_student').change((e) => {
        globalFieldUpdate('dependant',false,'Is_Student', e);
});

$('#dependant-date_of_birth').blur((e) => {
        globalFieldUpdate('dependant',false,'Date_of_Birth', e);
});

$('#dependant-relationship').change((e) => {
        globalFieldUpdate('dependant',false,'Relationship', e);
});

$('#dependant-gender').change((e) => {
        globalFieldUpdate('dependant',false,'Gender', e);
});

$('#dependant-full_name').change((e) => {
        globalFieldUpdate('dependant',false,'Full_Name', e);
});


JS;

$this->registerJs($script);

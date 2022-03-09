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



                    <?php  $form = ActiveForm::begin(['id' => 'professionalchange']);      ?>
                <div class="row">
                   

                            <table class="table">
                                <tbody>

                             <div class="col-md-6">
                                     <?= $form->field($model, 'Body_Code')->dropDownList(
                                        $qualifications,
                                        ['prompt' => 'Select ...']
                                    ) ?>
                                    <?= $form->field($model, 'From_Date')->textInput(['type' => 'date']) ?>
                                   
                                   

                            </div>
                             <div class="col-md-6">
                                    <?= $form->field($model, 'Membership_No')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'To_Date')->textInput(['type' => 'date']) ?>
                                   

                                    <?= $form->field($model, 'Action')->dropDownList(
                                        ['Retain' => 'Retain','Remove' => 'Remove','New_Addition' => 'New_Addition'],
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
  $('#professionalchange-body_code').change((e) => {
        globalFieldUpdate('professionalchange',false,'Body_Code', e);
});

$('#professionalchange-from_date').blur((e) => {
        globalFieldUpdate('professionalchange',false,'From_Date', e);
});

$('#professionalchange-to_date').blur((e) => {
        globalFieldUpdate('professionalchange',false,'To_Date', e);
});

$('#professionalchange-membership_no').change((e) => {
        globalFieldUpdate('professionalchange',false,'Membership_No', e);
});

JS;

$this->registerJs($script);

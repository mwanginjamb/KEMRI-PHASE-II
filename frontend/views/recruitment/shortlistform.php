<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div id="shorlistcandidate">

    <?= Html::beginForm(
        ['recruitment/shortlist-form?ProfileID=' . urlencode($ProfileID) . '&ComitteID=' . urlencode($ComitteID)],
        'post',
        ['id' => 'short-listcandidate_form']
    ) ?>

    <?= Html::dropDownList('ShortListCriteria', [], $ShortListCriteria, ['prompt' => 'Select Criteria', 'required' => true, 'class' => 'form-control']) ?>

    <?= Html::submitButton('ShortList Candidate', ['class' => 'btn btn-warning', 'style' => 'margin-top: 10px']) ?>

    <?= Html::endForm() ?>
</div>
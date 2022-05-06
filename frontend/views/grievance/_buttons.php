<?php

use yii\bootstrap4\Html;
?>

<?= ($model->Status == 'New' && $model->Employee_No == Yii::$app->user->identity->{'Employee No_'}) ? Html::a('<i class="fas fa-forward"></i>To HRO', ['send-to-hro'], [
    'class' => 'btn btn-app bg-success btn-success',
    'data' => [
        'confirm' => 'Are you sure you want to send this Document to HRO?',
        'params' => [
            'No' => $model->No
        ],
        'method' => 'post',
    ],
    'title' => 'Send Document to HRO for Acceptance'

]) : '';
?>

<?= ($model->Status == 'HRO') ? Html::a('<i class="fas fa-forward"></i> To HRM.', ['send-to-hrm'], [
    'class' => 'btn btn-app bg-success mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to send this Document to HRM?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'To HRM.'

]) : '';


?>


<?= ($model->Status == 'HRO') ? Html::a('<i class="fas fa-times"></i> Withdraw.', ['withdraw'], [
    'class' => 'btn btn-app bg-success mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to withdraw this grievance ?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'Withdraw Grievance.'

]) : '';


?>


<?= ($model->Status == 'HRO') ? Html::a('<i class="fas fa-check"></i> Accept ', ['accept-grievance'], [
    'class' => 'btn btn-app bg-success mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to Accept this Grievance?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'Accept Grievance.'

]) : ''
?>


<?= ($model->Status == 'HRO') ? Html::a('<i class="fas fa-times"></i> Reject ', ['reject-grievance'], [
    'class' => 'btn btn-app bg-success mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to Accept this Grievance?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'Reject Grievance.'

]) : ''
?>


    


<?= ($model->Status == 'Accepted') ? Html::a('<i class="fas fa-forward"></i> To Disciplinary ', ['convert-to-disciplinary'], [
    'class' => 'btn btn-app bg-success mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to Convert this grievance to a disciplinary case?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'Covert to Disciplinary Case.'

]) : ''
?>


<?= ($model->Status == 'HRM') ? Html::a('<i class="fas fa-forward"></i> To HoH ', ['send-to-hoh'], [
    'class' => 'btn btn-app bg-success mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to send Document to HoH?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'To HoH.'

]) : ''
?>


<?= ($model->Status == 'HOH') ? Html::a('<i class="fas fa-check"></i> Close ', ['close-grievance'], [
    'class' => 'btn btn-app bg-warning mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to close grievance?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'Close Grievance.'

]) : ''
?>


<?= ($model->Status == 'HOH') ? Html::a('<i class="fas fa-forward"></i> Back to HRM ', ['back-to-hrm'], [
    'class' => 'btn btn-app bg-success mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to send Document Back to HRM?',
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'post',
    ],
    'title' => 'Back to HRM.'

]) : ''
?>
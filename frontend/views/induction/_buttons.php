<?php

use yii\bootstrap4\Html;

?>


<?= Html::a('<i class="fas fa-check"></i>Induction Status', ['clearance-status'], [
    'class' => 'btn btn-app bg-success btn-success submitforapproval',
    'data' => [
        'params' => [
            'No' => $model->No,
        ],
        'method' => 'GET',
    ],
    'title' => 'Track Clearance Status.'
])  ?>

<?= ($model->Overall_Status == 'Induction' && $model->IsThereNextSection() == true) ? Html::a('<i class="fas fa-forward"></i>Next Section', ['next-section', 'employeeNo' => Yii::$app->user->identity->employee[0]->No], [
    'class' => 'btn btn-app bg-success btn-success submitforapproval',
    'data' => [
        'confirm' => 'Are you sure you want to send induction to next section?',
        'params' => [
            'No' => $model->No,
            'Key' => $model->Key,
        ],
        'method' => 'post',
    ],
    'title' => 'Send Induction To Next Section.'
]) : '' ?>


<?= ($model->Overall_Status == 'Induction' && $model->IsThereNextSection() == false) ? Html::a('<i class="fas fa-forward"></i> To Employee', ['send-to-employee'], [
    'class' => 'btn btn-app bg-primary mx-1',
    'data' => [
        'confirm' => 'Are you sure you want to this document to Employee ?',
        'params' => [
            'No' => $model->No,
            'Key' => $model->Key,
        ],
        'method' => 'post',
    ],
    'title' => 'Send to Inductee / Employee.'

]) : '' ?>

<!-- To CEO -->
<?= ($model->Overall_Status == 'HR' && !strlen($model->CEO_Comments)) ? Html::a('<i class="fas fa-forward"></i>To CEO', ['send-to-ceo'], [
    'class' => 'btn btn-app bg-success btn-info submitforapproval',
    'data' => [
        'confirm' => 'Are you sure you want to send induction to the C.E.O?',
        'params' => [
            'No' => $model->No,
            'Key' => $model->Key,
        ],
        'method' => 'post',
    ],
    'title' => 'To C.E.O.'
]) : '' ?>


<!-- To HOF -->

<?= ($model->Overall_Status == 'HR' && !strlen($model->HOF_Comments)) ? Html::a('<i class="fas fa-forward"></i>To H.O.F', ['send-to-hof'], [
    'class' => 'btn btn-app bg-success btn-info submitforapproval',
    'data' => [
        'confirm' => 'Are you sure you want to send induction to the H.O.F ?',
        'params' => [
            'No' => $model->No,
            'Key' => $model->Key,
        ],
        'method' => 'post',
    ],
    'title' => 'To H.O.F'
]) : '' ?>


<!-- H.O.O -->

<?= ($model->Overall_Status == 'HR' && !strlen($model->HOO_Comments)) ? Html::a('<i class="fas fa-forward"></i>To H.O.O', ['send-to-hoo'], [
    'class' => 'btn btn-app bg-success btn-info submitforapproval',
    'data' => [
        'confirm' => 'Are you sure you want to send induction to the H.O.O ?',
        'params' => [
            'No' => $model->No,
            'Key' => $model->Key,
        ],
        'method' => 'post',
    ],
    'title' => 'To H.O.O'
]) : '' ?>


<!-- Back to HR -->

<?= ($model->Overall_Status == 'CEO' || $model->Overall_Status == 'HOO' || $model->Overall_Status == 'HOF') ? Html::a('<i class="fas fa-forward"></i>To H.R', ['send-back-to-hr'], [
    'class' => 'btn btn-app bg-success btn-info submitforapproval',
    'data' => [
        'confirm' => 'You are sending this document back to HR, sure ?',
        'params' => [
            'No' => $model->No,
            'Key' => $model->Key,
        ],
        'method' => 'post',
    ],
    'title' => 'To H.R'
]) : '' ?>


<!-- Quiz answers to HR -->

<?= ($model->Overall_Status == 'Questions') ? Html::a('<i class="fas fa-upload"></i>Submit Quiz', ['submit-answers-to-hr'], [
    'class' => 'btn btn-app bg-info btn-info submitforapproval',
    'data' => [
        'confirm' => 'You are sending quiz to HR, sure ?',
        'params' => [
            'No' => $model->No,
            'Key' => $model->Key,
        ],
        'method' => 'post',
    ],
    'title' => 'Quiz To H.R'
]) : '' ?>

<!-- Generate Question entries -->

<?= ($model->Overall_Status == 'Employee') ? Html::a('<i class="fas fa-recycle"></i>Generate Quiz', ['generate-quiz'], [
    'class' => 'btn btn-app bg-warning btn-info submitforapproval',
    'data' => [
        'confirm' => 'You are to generate an Induction quiz, proceed ? .',
        'params' => [
            'No' => $model->No,
            'Employee_No' => $model->Employee_No,
        ],
        'method' => 'post',
    ],
    'title' => 'Generate Quiz'
]) : '' ?>


<!-- Update Action-->

<?= (Yii::$app->controller->action->id == 'view'  && $model->Overall_Status !== 'Closed') ? Html::a('<i class="fas fa-edit"></i>Edit', ['update', 'Key' => $model->Key], [
    'class' => 'btn btn-app bg-info btn-success',

    'title' => 'Edit Document'

]) : '';
?>


<!-- Close Induction -->

<?= ($model->Overall_Status == 'HR') ? Html::a('<i class="fas fa-lock"></i>Close Induction', ['close'], [
    'class' => 'btn btn-app bg-warning btn-info submitforapproval',
    'data' => [
        'confirm' => 'Are you sure you want to close this induction?',
        'params' => [
            'No' => $model->No
        ],
        'method' => 'post',
    ],
    'title' => 'Close Induction.'
]) : '' ?>
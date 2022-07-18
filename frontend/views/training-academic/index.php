<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'];
$this->params['breadcrumbs'][] = ['label' => 'Employee Academic Training List', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';
$url = \yii\helpers\Url::home(true);
?>



<?php
if (Yii::$app->session->hasFlash('success')) {
    print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
} else if (Yii::$app->session->hasFlash('error')) {
    print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Approved CPD Training List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive table-hover" id="table">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<input type="hidden" value="<?= $url ?>" id="url" />
<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         
         // $.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'training-academic/list',
            paging: true,
            columns: [
               
                { title: 'Employee No' ,data: 'Employee_No'},
                { title: 'Employee Name' ,data: 'Employee_Name'},
                { title: 'Trainer' ,data: 'Trainer'},
                { title: 'Training Type' ,data: 'Training_Type'},
                { title: 'Training Category' ,data: 'Training_Category'},
                { title: 'Training Need' ,data: 'Training_Need'},
                { title: 'Training Need Description' ,data: 'Training_Need_Description'},
                { title: 'Expected Start Date' ,data: 'Expected_Start_Date'},
                { title: 'Expected End Date' ,data: 'Expected_End_Date'},
                { title: 'Institution' ,data: 'Institution'},
                { title: 'Venue' ,data: 'Venue'},
                { title: 'Training Calender' ,data: 'Training_Calender'},
                { title: 'Approved Cost' ,data: 'Approved_Cost'},
                { title: 'Status' ,data: 'Status'},      
                { title: 'Action', data: 'Action' }
               
            ] ,                              
           language: {
                "zeroRecords": "No Records to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
      // table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#table').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
    table td:nth-child(7), td:nth-child(8), td:nth-child(9) {
        text-align: center;
    }
CSS;

$this->registerCss($style);

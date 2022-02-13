<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:08 PM
 */






/* @var $this yii\web\View */

$this->title = ' Applicant Proffesional Qualifications';
?>

    <!--THE STEPS THING--->

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('..\applicantprofile\_steps') ?>
        </div>
    </div>

    <!--END THE STEPS THING--->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=
                    //  \yii\helpers\Html::a('Add Qualification',
                    // ['createprofessional','create'=> 1],['class' => ' create btn btn-outline-warning push-right showModalButton'])

                    \yii\helpers\Html::button('Add Proffesional Qualification',
                    [  'value' => \yii\helpers\Url::to(['createprofessional',
                        'ProfileId'=>Yii::$app->user->identity->profileID
                        ]),
                        'title' => 'New Qualification',
                        'class' => 'btn btn-info push-right showModalButton',
                         ]
                    ); 

                    ?>


                </div>
            </div>
        </div>
    </div>


<?php
if(Yii::$app->session->hasFlash('success')){
    print ' <div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}else if(Yii::$app->session->hasFlash('error')){
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Proffesional Certifications.</h3>





                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive table-hover" id="leaves">
                    </table>
                </div>
            </div>
        </div>
    </div>



<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<?php

$script = <<<JS

    $(function(){
        
        var absolute = $('input[name=absolute]').val();
         /*Data Tables*/
         
        //  $.fn.dataTable.ext.errMode = 'throw';        
    
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'qualification/getprofessionalqualifications',
            paging: true,
            columns: [
                // { title: '....', data: 'index'},
                // { title: 'Applicant ID' ,data: 'Employee_No'},
                // { title: 'Qualification Code' ,data: 'Qualification_Code'},
                { title: 'From Date' ,data: 'From_Date'},
                { title: 'To Date' ,data: 'To_Date'},
                { title: 'Examining Body' ,data: 'Professional_Examiner'},
                { title: 'Specialization' ,data: 'Specialization'},
               // { title: 'Comment' ,data: 'Comment'},
               
                { title: 'Edit' ,data: 'Edit'},
                { title: 'Delete' ,data: 'Remove'},
                
               
            ] ,                              
           language: {
                "zeroRecords": "No  Certifications Found"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
    //    var table = $('#leaves').DataTable();
    //   table.columns([0]).visible(false);
    
    /*End Data tables*/
    
    
    /*Update Qualifications */
        $('#leaves').on('click','.update', function(e){
                 e.preventDefault();
                var url = $(this).attr('href');
                console.log('clicking...');
                $('.modal').modal('show')
                                .find('.modal-body')
                                .load(url); 
    
            });
            
            
           //Add an experience
        
        //  $('.create').on('click',function(e){
        //     e.preventDefault();
        //     var url = $(this).attr('href');
        //     console.log('clicking...');
        //     $('.modal').modal('show')
        //                     .find('.modal-body')
        //                     .load(url); 
    
        //  });
        
        /*Handle dismissal eveent of modal */
        $('.modal').on('hidden.bs.modal',function(){
            var reld = location.reload(true);
            setTimeout(reld,1000);
        });
    });
        
JS;

$this->registerJs($script);


$style = <<<CSS
    tr > td:last-child, th:last-child{ text-align: center; }
CSS;

$this->registerCss($style);






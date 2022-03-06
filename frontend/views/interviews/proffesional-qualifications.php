<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:08 PM
 */






/* @var $this yii\web\View */

$this->title = 'Applicant Qualifications';
?>

   <!--My Bs Modal template  --->

   <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Qualification</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>


    <!--THE STEPS THING--->

    <div class="row">
        <div class="col-md-12">
        <?= $this->render('_steps', ['model'=>$model]) ?>
        </div>
    </div>

    <!--END THE STEPS THING--->



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
        <div class=" row col-md-6"> 
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Proffesional Certifications .</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered dt-responsive table-hover" id="leaves">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ml-1"> 
            <?= $this->render('questions', ['Questions'=>$Questions]) ?>
       </div>
     </div>


<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<input type="hidden" name="ProfileNo" value="<?= $model->No ?>">

<?php

$script = <<<JS

    $(function(){
        
        var absolute = $('input[name=absolute]').val();
         /*Data Tables*/
         
         $.fn.dataTable.ext.errMode = 'throw';        
    
          $('#leaves').DataTable({
           
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            //serverSide: true,  
            ajax: absolute+'recruitment/getprofessionalqualifications?ProfileID='+$('input[name=ProfileNo]').val(),
            paging: true,
            columns: [
                { title: '#', data: 'index'},
                { title: 'Professional Examiner' ,data: 'Professional_Examiner'},
                // { title: 'Academic Qualification' ,data: 'Academic_Qualification'},
                { title: 'From Date' ,data: 'From_Date'},
                { title: 'To Date' ,data: 'To_Date'},
                { title: 'Specialization' ,data: 'Specialization'},
               // { title: 'Comment' ,data: 'Comment'},
               
                
                
               
            ] ,                              
           language: {
                "zeroRecords": "No Proffessional Qualifications to show."
            },
            
            // order : [[ 0, "asc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
    //   table.columns([0]).visible(false);
    
    $('.ScoresTable').on('change', '.Score', function(){ 
            var currentrow = $(this).closest('tr');
            var Score = currentrow.find('.Score').val();
            var Key = currentrow.find('.Key').val(); 

            if(Score){ //Ensure No Blanks
                    //Submit Score
                var commurl = absolute+'interviews/score';
                $.post(commurl,{'Key': Key,'Score':Score,},function(data){
                    if(data.length){
                        Swal.fire("Warning", data , "warning");;
                        return false;
                    }
                        //Set Value of LineKey
                        var j = data.key;
                        $('.NewLineModal').find('#linekey').val(j);
                        $('.NewLineModal').find('.amount_usd').val(data.Additional_Reporting_Currency);
                        $('.NewLineModal').find('.gfbudget').val(data.Available_Amount);
                        $('.NewLineModal').find('#linenumber').val(data.linenumber);
                        $('.NewLineModal').find('.description').val(data.Description);
                        $('.NewLineModal').find('.totalamount').val(data.Amount);
                        $('.NewLineModal').find('.noOfNights').val(data.No_of_Days);
                        // alert(lineKey);
                });
            }
            
                
        });
    });
        
JS;

$this->registerJs($script);







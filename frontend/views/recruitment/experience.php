<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'Recruitment - Job Experience';
?>

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
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
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
                <h3 class="card-title"> Work Experince.</h3>






            </div>
            <div class="card-body">
                <table class="table table-bordered dt-responsive table-hover" id="leaves">
                </table>
            </div>
        </div>
    </div>
</div>
 
<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<input type="hidden" name="ProfileNo" value="<?= $model->No ?>">

<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         var absolute = $('input[name=absolute]').val();

        // $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'recruitment/getexperience?ProfileID='+$('input[name=ProfileNo]').val(),
            paging: true,
            columns: [
                { title: '....', data: 'index'},
                { title: 'Position' ,data: 'Position'},
                { title: 'Responsibilities' ,data: 'Job_Description'},
                { title: 'Institution' ,data: 'Institution'},
                
               
            ] ,                              
           language: {
                "zeroRecords": "No Employment record to Show.."
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
      table.columns([0]).visible(false);
    
    /*End Data tables*/
        $('#leaves').on('click','.update', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });



    $('.rejectey').on('click', function(e){
            console.log('clicked...')
            e.preventDefault();
            const form = $('#eyrejform').html(); 
            const ProfileID = $(this).attr('rel');
            const ComitteID = $(this).attr('rev');
                            
            //Display the rejection comment form
            $('.modal').modal('show')
                            .find('.modal-body')
                            .append(form);
            
            //populate relevant input field with code unit required params
                    
            $('input[name=ProfileID]').val(ProfileID);
            $('input[name=ComitteID]').val(ComitteID);
            
            //Submit Rejection form and get results in json    
            $('form#ey-reject-form').on('submit', function(e){
                e.preventDefault()
                const data = $(this).serialize();
                const url = $(this).attr('action');
                $.post(url,data).done(function(msg){
                        $('.modal').modal('show')
                        .find('.modal-body')
                        .html(msg.note);
            
                    },'json');
            });
                       
    });

      /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 

        
        
       //Add an experience
    
     $('.create').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
    
    /*Handle dismissal eveent of modal */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
        
        
    });//end jquery

    

        
JS;

$this->registerJs($script);


$style = <<<CSS
    tr > td:last-child, th:last-child{ text-align: center; }
CSS;

$this->registerCss($style);




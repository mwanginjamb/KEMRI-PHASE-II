<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'];
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';

/*print '<pre>';
print_r(Yii::$app->user->identity->employee);
exit;*/

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-info card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="https://via.placeholder.com/150/cccccc/FFFFFF/?text=<?= !empty(Yii::$app->user->identity->Employee[0]->Last_Name) ? Yii::$app->user->identity->Employee[0]->Last_Name : 'User' ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= (!empty($employee->First_Name) && !empty($employee->Last_Name)) ? $employee->First_Name . ' ' . $employee->Last_Name : '';  ?></h3>

                        <p class="text-muted text-center"><?= !empty($employee->Title) ? $employee->Title : '' ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><i class="fa fa-phone-alt"></i></b> <a class="float-right"><?= !empty($employee->Phone_No) ? $employee->Phone_No : '(Not Set)' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fa fa-mail-bulk"></i></b><a class="float-right"><?= !empty($employee->E_Mail) ? $employee->E_Mail : '' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fa fa-hourglass-start"></i></b> <a title="Length of Service" class="float-right"><?= !empty($employee->Service_Period) ? $employee->Service_Period : '' ?></a>
                            </li>
                        </ul>

                        <a href="mailto:<?= !empty($supervisor) ? $supervisor->Company_E_Mail : 'Not Set' ?>" class="btn btn-info btn-block"><b>Email Supervisor</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Job Title</strong>

                        <p class="text-muted">
                            <?= !empty($employee->Job_Description) ? $employee->Job_Description : '' ?>
                        </p>

                        <hr>

                        <strong><i class="fas fa-person-booth mr-1"></i> Gender</strong>

                        <p class="text-muted"><?= !empty($employee->Gender) ? $employee->Gender : '' ?> </p>

                        <hr>

                        <strong><i class="fas fa-birthday-cake mr-1"></i> Age</strong>

                        <p class="text-muted">
                            <?= !empty($employee->Age) ? $employee->Age : '' ?>
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> Date of Join:</strong>

                        <p class="text-muted"><?= !empty($employee->Employment_Date) ? $employee->Employment_Date : '' ?></p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->


            <!--start col ---9-->



            <div class="col-md-9">



                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'recruitment/vacancies' ?>" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-briefcase"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">HR Vacancies</span>
                                    <span class="info-box-number"><?= Yii::$app->dashboard->getVacancies() ?>
                                        <small></small>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                    </div>

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>


                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'approvals/open-approvals' ?>" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">Open Approvals</span>
                                    <span class="info-box-number"><?= Yii::$app->dashboard->getOpenApprovals() ?>
                                        <small></small>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'approvals/approved-approvals' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">Approved Reqs.</span>
                                    <span class="info-box-number"><?= Yii::$app->dashboard->getApprovedApprovals() ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'approvals/rejected-approvals' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">Rejected Reqs.</span>
                                    <span class="info-box-number"><?= Yii::$app->dashboard->getRejectedApprovals() ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>


                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <!-- /.col -->
                    <?php if (Yii::$app->user->identity->{'Head of Department'}) : ?>
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'leave/balances' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-door-open"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">Leave Balances</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getLeaveBalanceCount()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    <?php endif; ?>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <?php if (Yii::$app->user->identity->{'Head of Department'} || Yii::$app->dashboard->inSupervisorList()) : ?>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'leave/activeleaves' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-paper-plane"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">Staff on Leave</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getOnLeave()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    <?php endif; ?>

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'recruitment/internalapplications' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-paper-plane"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">My Applications</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getInternalapplications()) ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">

                        <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'approvals/sapproved' ?>" target="_blank">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">Super Approved</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getSuperApproved()) ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>

                    </div>
                    <!-- /.col -->


                </div>
                <!-- /.row -->

                <div class="row">

                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'approvals/srejected' ?>" target="_blank">

                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-times"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">Super Rejected</span>
                                    <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getSuperRejected()) ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </a>
                    </div>
                    <!-- /.col -->

                    <!-- /.col - HODs on Leeave -->

                    <?php

                    if (Yii::$app->user->identity->{'Head of Division'} == Yii::$app->user->identity->Employee[0]->Global_Dimension_1_Code) : ?>
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'leave/activeleaveshod' ?>" target="_blank">

                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-paper-plane"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">HoDs on Leave</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getOnLeavehod()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    <?php endif; ?>
                    <!-- /.col -->

                    <!-- /.col Appraisal Status Lists for HR Admins -->
                    <?php if (Yii::$app->user->identity->{'Is HR Admin'}) : ?>

                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/prob-status-list' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">probation Status</span>
                                        <span class="primary-box-number"><?= number_format(Yii::$app->dashboard->getProbations()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->


                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/st-status' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">Short Term Status</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getShortterms()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->


                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/lt-status' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">Long Term Status</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getLongterms()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                    <?php endif; ?>

                    <!-- HoDs Leave Balances -->
                    <?php if (Yii::$app->user->identity->{'Head of Division'} == Yii::$app->user->identity->Employee[0]->Global_Dimension_1_Code) : ?>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'leave/balances-division' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-paper-plane"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">HoD Leave Balances</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getHoDBalancesRecords()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    <?php endif; ?>


                </div>

                <div class="row">
                    <!---row for supervisor appraisal list -->
                    <!-- /.col Appraisal Status Lists for HR Admins -->
                    <?php if (Yii::$app->dashboard->inSupervisorList()) : ?>

                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/prob-status-list-super' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">Super probation Status</span>
                                        <span class="primary-box-number"><?= number_format(Yii::$app->dashboard->getProbationsSuper()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->


                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/st-status-super' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">Super ShortTerm Status</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getShorttermsSuper()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->


                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/lt-status-super' ?>" target="_blank">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-wrap">Super LongTerm Status</span>
                                        <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getLongtermsSuper()) ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                    <?php endif; ?>
                </div>

                <?= $this->render('_head_of_Section_appraisal_status') ?>


                <div class="row">

                    <div class="col-md-7">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">My Leave Balances</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive table-hover" id="leavebances">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php



                                            foreach ($balances as $key => $val) {
                                                if ($key == 'Key') {
                                                    continue;
                                                } elseif ($key == 'Annual_Leave_Bal' || $key == 'Compasionate_Leave_Bal') {
                                                    print '
                                                        <tr>
                                                            <td>' . $key . '</td><td>' . $val . '</td>
                                                        </tr>
                                                        ';
                                                }
                                            } ?>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-5">

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Current Performance Appraisal Status</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered dt-responsive table-hover" id="leavebances">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td><?= Yii::$app->dashboard->getAppraisalStatus(); ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>





                </div>

            </div>
        </div>

</section>



<?php


$script = <<<JS

    $(function(){
         /*Data Tables*/
        
         
         //$.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#onleave').DataTable({
           
           paging: true,                                        
           language: {
                "zeroRecords": "No records to display"
            },
            
            order : [[ 0, "desc" ]]            
           
       });
          
          $('#leavebances').DataTable({});
        
       //Hidding some 
       var table = $('#onleave').DataTable();
       //table.columns([3,4,5,6,]).visible(false);
    
    /*End Data tables*/
        $('#onleave').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);

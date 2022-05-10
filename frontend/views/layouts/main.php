<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 2:39 PM
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AdminlteAsset;
use common\widgets\Alert;

AdminlteAsset::register($this);

$webroot = Yii::getAlias(@$webroot);
$absoluteUrl = \yii\helpers\Url::home(true);
$employee = (!Yii::$app->user->isGuest && is_array(Yii::$app->user->identity->employee)) ? Yii::$app->user->identity->employee[0] : [];


//Yii::$app->recruitment->printrr(Yii::$app->navhelper->codeunit(Yii::$app->params['ServiceName']['PortalFactory'],['employeeNo' => Yii::$app->user->identity->{'Employee No_'} ],'IanCanViewShortTerm'));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.75">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    <style>
        @viewport {
            zoom: 0.75;
            min-zoom: 0.5;
            max-zoom: 0.9;
        }
    </style>
</head>

<?php $this->beginBody() ?>

<body class="hold-transition sidebar-mini layout-fixed accent-info">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?= $absoluteUrl ?>site" class="nav-link">Home</a>
                    </li>

                    <?php if (Yii::$app->controller->id == 'applicantprofile') { ?>

                        <li class="nav-item d-none d-sm-inline-block">
                            <?= Html::a('My Applications', ['recruitment/applications'], ['class' => "nav-link"]) ?>

                        </li>

                    <?php } ?>

                <?php endif; ?>
                <!--<li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>-->
            </ul>

            <!-- SEARCH FORM -->
            <!--<form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>-->

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto ">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <!--<i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>-->
                    </a>

                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-th-large"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!--<span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>-->






                        <div class="dropdown-divider"></div>

                        <?= (Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-sign-in-alt "></i> Signup', '/site/signup/', ['class' => 'dropdown-item']) : ''; ?>

                        <div class="dropdown-divider"></div>

                        <?= (Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-lock-open"></i> Login', '/site/login/', ['class' => 'dropdown-item']) : ''; ?>

                        <div class="dropdown-divider"></div>

                        <div class="dropdown-divider"></div>

                        <?= (!Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-sign-out-alt"></i> Logout', '/site/logout/', ['class' => 'dropdown-item']) : ''; ?>

                        <div class="dropdown-divider"></div>

                        <?= (Yii::$app->user->identity->Employee[0]->Type_of_Employee == 'Expertriate_Payable' || Yii::$app->user->identity->Employee[0]->Type_of_Employee == 'Expertriate_Non_Payable') ?
                            Html::a('<i class="fas fa-user"></i> Exp Profile', ['./employee/expetriate'], ['class' => 'dropdown-item'])
                            :
                            Html::a('<i class="fas fa-user"></i> Profile', ['./employee'], ['class' => 'dropdown-item']); ?>

                        <div class="dropdown-divider"></div>

                        <?= (!Yii::$app->user->isGuest) ? Html::a('<i class="fas fa-file-pdf "></i> ESS Manuals', '../essfile/index', ['class' => 'dropdown-item']) : ''; ?>



                    </div>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="false" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>-->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-dark-info">
            <!-- Brand Logo -->
            <a href="<?= $absoluteUrl ?>site" class="brand-link">
                <!--<img src="<?= $webroot ?>/images/Logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                     style="opacity: .8">-->
                <span class="brand-text font-weight-light"><?= Yii::$app->params['generalTitle'] ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?/*= $webroot */ ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?/*= $absoluteUrl */ ?>employee/" class="d-block"><?/*= (!Yii::$app->user->isGuest)? ucwords($employee->First_Name.' '.$employee->Last_Name): ''*/ ?></a>
                    </div>
                </div>-->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->


                        <!--Approval Management -->
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isApprover()) : ?>
                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('approvals') ? 'menu-open' : '' ?>">

                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('approvals') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        Approval Management
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>approvals" class="nav-link <?= Yii::$app->recruitment->currentaction('approvals', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>Approval Requests</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        <?php endif; ?>
                        <!--end Aprroval Management-->


                        <li class="nav-item has-treeview  <?= Yii::$app->recruitment->currentCtrl(['leave', 'leavestatement', 'leaverecall', 'leaveplan', 'leave-reimburse']) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('leave') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>
                                    Leave Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <!--<li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave/create" class="nav-link <?= Yii::$app->recruitment->currentaction('leave', 'create') ? 'active' : '' ?> ">
                                        <i class="fa fa-running nav-icon"></i>
                                        <p>New Leave Application</p>
                                    </a>
                                </li>-->
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave/" class="nav-link <?= Yii::$app->recruitment->currentaction('leave', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-door-open nav-icon"></i>
                                        <p>Leave List</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leavestatement/index" class="nav-link <?= Yii::$app->recruitment->currentaction('leavestatement', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-file-pdf nav-icon"></i>
                                        <p>Leave Statement Report</p>
                                    </a>
                                </li>

                                <!-- <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leaverecall/create/?create=1" class="nav-link <?= Yii::$app->recruitment->currentaction('leaverecall', 'create') ? 'active' : '' ?>">
                                        <i class="fa fa-recycle nav-icon"></i>
                                        <p>Recall Leave</p>
                                    </a>
                                </li>-->

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leaverecall/index" class="nav-link <?= Yii::$app->recruitment->currentaction('leaverecall', ['index', 'view']) ? 'active' : '' ?>">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Recall Leave List</p>
                                    </a>
                                </li>

                                <!-- Leave Reimbursement -->

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave-reimburse/index" class="nav-link <?= Yii::$app->recruitment->currentaction('leave-reimburse', ['index', 'view']) ? 'active' : '' ?>">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Leave Reimbursement</p>
                                    </a>
                                </li>

                                <!-- <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leaveplan/create" class="nav-link <?= Yii::$app->recruitment->currentaction('leaveplan', 'create') ? 'active' : '' ?>">
                                        <i class="fa fa-directions nav-icon"></i>
                                        <p>New Leave Plan</p>
                                    </a>
                                </li>-->

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leaveplan/index" class="nav-link <?= Yii::$app->recruitment->currentaction('leaveplan', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Leave Plan List</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!--Change Mgt-->

                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['change-request', 'asset-assignment']) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['change-request', 'asset_assignment']) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-address-card "></i>
                                <p>
                                    Change Management
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>change-request" class="nav-link <?= Yii::$app->recruitment->currentaction('change-request', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Change Request List </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>asset-assignment" class="nav-link <?= Yii::$app->recruitment->currentaction('asset-assignment', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Asset Assignment </p>
                                    </a>
                                </li>

                            </ul>
                        </li>






                        <!--/ Salary Advance -->


                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('salaryadvance') ? 'menu-open' : '' ?>">
                            <a href="#" title="Salary Advance Module" class="nav-link <?= Yii::$app->recruitment->currentCtrl('salaryadvance') ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-money-check"></i>
                                <p>
                                    Salary Advance
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                <!-- <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>salaryadvance/create" class="nav-link <?= Yii::$app->recruitment->currentaction('salaryadvance', 'create') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> New Requisition</p>
                                    </a>
                                </li> -->

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>salaryadvance" class="nav-link <?= Yii::$app->recruitment->currentaction('salaryadvance', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> Salary Advance List</p>
                                    </a>
                                </li>


                            </ul>

                        </li>

                        <!--/Salary Advance -->



                        <!--Salary Increment-->

                        <?php if (1 == 0) : ?>

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('salary-increment') ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('salary-increment') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line "></i>
                                    <p>
                                        Salary Increment
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>salary-increment" class="nav-link <?= Yii::$app->recruitment->currentaction('salary-increment', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>Salary Increment List </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>salary-increment/create" class="nav-link <?= Yii::$app->recruitment->currentaction('salary-increment', 'create') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>New Request </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        <?php endif; ?>
                        <!-- Overtime -->


                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('overtime') ? 'menu-open' : '' ?>">
                            <a href="#" title="Overtime Management" class="nav-link <?= Yii::$app->recruitment->currentCtrl('overtime') ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-clock"></i>
                                <p>
                                    Overtime Management
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>overtime/create" class="nav-link <?= Yii::$app->recruitment->currentaction('overtime', 'create') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> New Requisition</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>overtime" class="nav-link <?= Yii::$app->recruitment->currentaction('overtime', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> Overtime List</p>
                                    </a>
                                </li>


                            </ul>

                        </li>

                        <!--/Overtime -->


                        <!--Recruitment-->

                        <?php if (Yii::$app->params['ActiveModules']['Recruitment']) { ?>

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(Yii::$app->params['profileControllers']) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('recruitment') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-briefcase "></i>
                                    <p>
                                        Employee Recruitment
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>recruitment/vacancies" class="nav-link <?= Yii::$app->recruitment->currentaction('recruitment', 'vacancies') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>Internal Job Vacancies </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>recruitment/externalvacancies" class="nav-link <?= Yii::$app->recruitment->currentaction('recruitment', 'externalvacancies') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>External Job Vacancies </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        <?php } ?>

                        <!--Payroll reports -->
                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['payslip', 'p9']) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['payslip', 'p9']) ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-file-invoice-dollar"></i>
                                <p>
                                    HR Reports
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>payslip" class="nav-link <?= Yii::$app->recruitment->currentaction('payslip', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Generate Payslip</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>p9" class="nav-link <?= Yii::$app->recruitment->currentaction('p9', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Generate P9 </p>
                                    </a>
                                </li>

                                <!--<li class="nav-item">
                                    <a href="<?/*= $absoluteUrl */ ?>medical" class="nav-link <?/*= Yii::$app->recruitment->currentaction('p9','index')?'active':'' */ ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Medical Claim </p>
                                    </a>
                                </li>-->

                            </ul>
                        </li>
                        <!--payroll reports-->


                        <?php  // Yii::$app->recruitment->printrr(Yii::$app->user->identity->Employee) 
                        ?>

                        <!-- Long Term Appraisal -->

                        <?php if (
                            Yii::$app->user->identity->Employee[0]->Long_Term == true && Yii::$app->user->identity->Employee[0]->Probation_Status == 'Confirmed' ||
                            (Yii::$app->user->identity->Employee[0]->Type_of_Employee == 'Expertriate_Payable' ||
                                Yii::$app->user->identity->Employee[0]->Type_of_Employee == 'Expertriate_Non_Payable' ||
                                Yii::$app->user->identity->Employee[0]->Type_of_Employee == 'Part_Time' ||
                                Yii::$app->user->identity->Employee[0]->Type_of_Employee == 'Seconded'

                            )
                        ) : ?>

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('appraisal') ? 'menu-open' : '' ?>">
                                <a href="#" title="Performance Management" class="nav-link <?= Yii::$app->recruitment->currentCtrl('appraisal') ? 'active' : '' ?>">
                                    <i class="nav-icon fa fa-balance-scale"></i>
                                    <p>
                                        Perfomance Mgt.
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">


                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>appraisal" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Goal Setting</p>
                                        </a>
                                    </li>
                                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isSupervisor()) :  ?>
                                        <li class="nav-item">
                                            <a href="<?= $absoluteUrl ?>appraisal/submitted" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', ['submitted', 'viewsubmitted']) ? 'active' : '' ?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>Submitted Goals List </p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>appraisal/overviewgoalslist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'overviewgoalslist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>Overview Mgr Goals List </p>
                                        </a>
                                    </li>
                                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isSupervisor()) :  ?>
                                        <!-- <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>appraisal/superapprovedappraisals" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'superapprovedappraisals') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p>Approved (Supervisor) </p>
                                        </a>
                                    </li> -->
                                    <?php endif; ?>

                                    <!--Mid Year Appraisals-->
                                    <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentaction('appraisal', ['myappraiseelist', 'mysupervisorlist', 'myoverviewlist']) ? 'menu-open' : '' ?>">
                                        <a href="#" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', ['myappraiseelist', 'mysupervisorlist', 'myoverviewlist']) ? 'active' : '' ?>">
                                            <i class="nav-icon fa fa-balance-scale"></i>
                                            <p>
                                                Mid Year Appraisals
                                                <i class="fas fa-angle-left right"></i>
                                                <!--<span class="badge badge-info right">6</span>-->
                                            </p>
                                        </a>

                                        <ul class="nav nav-treeview">
                                            <!--Mid Year Appraisals Menu-->

                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/myappraiseelist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'myappraiseelist') ? 'active' : '' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>M-Y Appraisal (Appraisee) </p>
                                                </a>
                                            </li>

                                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isSupervisor()) :  ?>

                                                <li class="nav-item">
                                                    <a href="<?= $absoluteUrl ?>appraisal/mysupervisorlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'mysupervisorlist') ? 'active' : '' ?>">
                                                        <i class="fa fa-check-square nav-icon"></i>
                                                        <p>M-Y Appraisal (Supervisor) </p>
                                                    </a>
                                                </li>

                                            <?php endif; ?>




                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/myagreement" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'myagreement') ? 'active' : '' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>M-Y Agreement (Appraisee) </p>
                                                </a>
                                            </li>






                                            <?php if (!Yii::$app->user->isGuest) :  ?>

                                                <li class="nav-item">
                                                    <a href="<?= $absoluteUrl ?>appraisal/myoverviewlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'myoverviewlist') ? 'active' : '' ?>">
                                                        <i class="fa fa-check-square nav-icon"></i>
                                                        <p>M-Y Appraisal (Overview) </p>
                                                    </a>
                                                </li>

                                            <?php endif; ?>

                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/myapprovedappraiseelist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'myapprovedappraiseelist') ? 'active' : '' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>M-Y Approved (Appraisee) </p>
                                                </a>
                                            </li>

                                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isSupervisor()) :  ?>

                                                <li class="nav-item">
                                                    <a href="<?= $absoluteUrl ?>appraisal/myapprovedsupervisorlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'myapprovedsupervisorlist') ? 'active' : '' ?>">
                                                        <i class="fa fa-check-square nav-icon"></i>
                                                        <p>M-Y Approved (Supervisor) </p>
                                                    </a>
                                                </li>

                                            <?php endif; ?>




                                        </ul>
                                        <!--End Mid Year Appraisals menu list-->


                                    </li>
                                    <!--End Mid Year Child Menu list-->

                                    <!--end Year Appraisals -->
                                    <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentaction('appraisal', ['eyappraiseelist', 'eysupervisorlist', 'eyoverviewlist', 'eyagreementlist', 'eyappraiseeclosedlist']) ? 'menu-open' : '' ?>">
                                        <a href="#" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', ['eyappraiseelist', 'eysupervisorlist', 'eyoverviewlist', 'eyagreementlist', 'eyappraiseeclosedlist']) ? 'active' : '' ?>">
                                            <i class="nav-icon fa fa-balance-scale"></i>
                                            <p>
                                                End Year Appraisals
                                                <i class="fas fa-angle-left right"></i>
                                                <!--<span class="badge badge-info right">6</span>-->
                                            </p>
                                        </a>

                                        <ul class="nav nav-treeview">
                                            <!--End Year Appraisals Menu-->


                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/eyappraiseelist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'eyappraiseelist') ? 'active' : '' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>E-Y Appraisals (Appraisee) </p>
                                                </a>
                                            </li>

                                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isSupervisor()) :  ?>
                                                <li class="nav-item">
                                                    <a href="<?= $absoluteUrl ?>appraisal/eysupervisorlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'eysupervisorlist') ? 'active' : '' ?>">
                                                        <i class="fa fa-check-square nav-icon"></i>
                                                        <p>E-Y Appraisals (Supervisor) </p>
                                                    </a>
                                                </li>

                                            <?php endif; ?>

                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/eyoverviewlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'eypeer1list') ? 'active' : '' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>E-Y Overview List </p>
                                                </a>
                                            </li>




                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/eyagreementlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'eyagreementlist') ? 'active' : '' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>E-Y (Agreement) </p>
                                                </a>
                                            </li>


                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/eyappraiseeclosedlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'eyappraiseeclosedlist') ? 'active' : '' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>E-Y Closed (Appraisee) </p>
                                                </a>
                                            </li>
                                            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isSupervisor()) :  ?>
                                                <li class="nav-item">
                                                    <a href="<?= $absoluteUrl ?>appraisal/eysupervisorclosedlist" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal', 'eysupervisorclosedlist') ? 'active' : '' ?>">
                                                        <i class="fa fa-check-square nav-icon"></i>
                                                        <p>E-Y Closed (Superviosr) </p>
                                                    </a>
                                                </li>

                                            <?php endif; ?>




                                        </ul>
                                        <!--End Mid Year Appraisals menu list-->


                                    </li>
                                    <!--/ End Year Child Menu list-->











                                </ul>
                            </li>

                        <?php endif; ?>


                        <!-- Start Probation Appraisal -->
                        <?php if (
                            Yii::$app->user->identity->Employee[0]->Probation_Status == 'Extended' ||
                            Yii::$app->user->identity->Employee[0]->Probation_Status == 'On_Probation' ||
                            Yii::$app->user->identity->Employee[0]->Type_of_Employee == 'Seconded' ||
                            Yii::$app->dashboard->inSupervisorList()
                        ) : ?>
                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('probation') ? 'menu-open' : '' ?>">
                                <a href="#" title="Performance Management" class="nav-link <?= Yii::$app->recruitment->currentCtrl('appraisal') ? 'active' : '' ?>">
                                    <i class="nav-icon fa fa-balance-scale"></i>
                                    <p>
                                        Probation Appraisal
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">


                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>probation" class="nav-link <?= Yii::$app->recruitment->currentaction('probation', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Objective Setting</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>probation/superglist" class="nav-link <?= Yii::$app->recruitment->currentaction('probation', 'superglist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Supervisor Goals List</p>
                                        </a>
                                    </li>



                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>probation/ovglist" class="nav-link <?= Yii::$app->recruitment->currentaction('probation', 'ovglist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Overview Goals List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>probation/approvedglist" class="nav-link <?= Yii::$app->recruitment->currentaction('probation', 'approvedglist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Approved Goals List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>probation/superproblist" class="nav-link <?= Yii::$app->recruitment->currentaction('probation', 'superproblist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Supervisor Probation List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>probation/ovproblist" class="nav-link <?= Yii::$app->recruitment->currentaction('probation', 'ovproblist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Overview Probation List</p>
                                        </a>
                                    </li>




                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>probation/closedlist" class="nav-link <?= Yii::$app->recruitment->currentaction('probation', 'closedlist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Closed List</p>
                                        </a>
                                    </li>


                                </ul>

                            </li>
                        <?php endif; ?>
                        <!---End Probationary Appraisal -->




                        <!-- Short Term Probation -->

                        <?php if (

                            Yii::$app->user->identity->Employee[0]->Long_Term == false ||
                            (
                                (Yii::$app->user->identity->Employee[0]->Probation_Status == 'Confirmed')
                                && Yii::$app->navhelper->codeunit(Yii::$app->params['ServiceName']['PortalFactory'], ['employeeNo' => Yii::$app->user->identity->{'Employee No_'}], 'IanCanViewShortTerm') == true
                            )
                            ||
                            Yii::$app->dashboard->inSupervisorList()
                        ) : ?>
                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('shortterm') ? 'menu-open' : '' ?>">
                                <a href="#" title="Performance Management" class="nav-link <?= Yii::$app->recruitment->currentCtrl('appraisal') ? 'active' : '' ?>">
                                    <i class="nav-icon fa fa-balance-scale"></i>
                                    <p>
                                        Short Term Appraisal
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">


                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Objective Setting</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm/superglist" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'superglist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Supervisor Goals List</p>
                                        </a>
                                    </li>



                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm/ovglist" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'ovglist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Overview Goals List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm/approvedglist" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'approvedglist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Approved Goals List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm/superproblist" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'superproblist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Supervisor shortterm List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm/ovproblist" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'ovproblist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Overview shortterm List</p>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm/agreementlist" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'agreementlist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Agreement List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>shortterm/closedlist" class="nav-link <?= Yii::$app->recruitment->currentaction('shortterm', 'closedlist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Closed List</p>
                                        </a>
                                    </li>


                                </ul>

                            </li>
                        <?php endif; ?>

                        <!-- Short Term Probation -->

                        <!-- PIP -->

                        <?php if (
                            Yii::$app->dashboard->inAppraiseePIPList() ||
                            Yii::$app->dashboard->inSupervisorPIPList() ||
                            Yii::$app->dashboard->inOverviewPIPList() ||
                            Yii::$app->dashboard->inAgreementPIPList() ||
                            Yii::$app->dashboard->inClosedPIPList()
                        ) : ?>

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('pip') ? 'menu-open' : '' ?>">
                                <a href="#" title="Performance Improvement Program" class="nav-link <?= Yii::$app->recruitment->currentCtrl('pip') ? 'active' : '' ?>">
                                    <i class="nav-icon fa fa-balance-scale"></i>
                                    <p>
                                        PIP Appraisal
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">


                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>pip" class="nav-link <?= Yii::$app->recruitment->currentaction('pip', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Appraisee List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>pip/superlist" class="nav-link <?= Yii::$app->recruitment->currentaction('pip', 'superlist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Supervisor List</p>
                                        </a>
                                    </li>



                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>pip/ovlist" class="nav-link <?= Yii::$app->recruitment->currentaction('pip', 'ovlist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Overview List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>pip/agreementlist" class="nav-link <?= Yii::$app->recruitment->currentaction('pip', 'agreementlist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Agreementlist List</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>pip/closedlist" class="nav-link <?= Yii::$app->recruitment->currentaction('pip', 'closedlist') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Closed PIP List</p>
                                        </a>
                                    </li>




                                </ul>

                            </li>


                        <?php endif; //End checkinf existence of employee in all pip lists 
                        ?>
                        <!-- /PIP -->


                        <?php if (Yii::$app->user->identity->{'Is HR Admin'} || Yii::$app->dashboard->inSupervisorList()) : ?>

                            <!--Contract Management --->

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('contractrenewal') ? 'menu-open' : '' ?>">
                                <a href="#" title="Contract Management" class="nav-link <?= Yii::$app->recruitment->currentCtrl('contractrenewal') ? 'active' : '' ?>">
                                    <i class="nav-icon fa fa-paperclip"></i>
                                    <p>
                                        Contract Renewal
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>contractrenewal/create" class="nav-link <?= Yii::$app->recruitment->currentaction('contractrenewal', 'create') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Renew Conctract</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>contractrenewal" class="nav-link <?= Yii::$app->recruitment->currentaction('contractrenewal', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-check-square nav-icon"></i>
                                            <p> Contracts Renewal List</p>
                                        </a>
                                    </li>


                                </ul>

                            </li>

                            <!--end contract Management -->

                        <?php endif; ?>
                        <!--Exit Management-->

                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('exit') ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('exit') ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                <p>
                                    Employee Exit
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>exit" class="nav-link <?= Yii::$app->recruitment->currentaction('exit', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Exit List </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>exit/create" class="nav-link <?= Yii::$app->recruitment->currentaction('exit', 'create') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>New Exit Request </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>exit-form" class="nav-link <?= Yii::$app->recruitment->currentaction('exit-form', 'index') ? 'active' : '' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Clearance Form</p>
                                    </a>
                                </li>

                                <!--<li class="nav-item">
                                    <a href="<?/*= $absoluteUrl */ ?>exit-form/create" class="nav-link <?/*= Yii::$app->recruitment->currentaction('exit-form','create')?'active':'' */ ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Create an Exit Form </p>
                                    </a>
                                </li>-->

                            </ul>
                        </li>



                        <!-- power Bi -->

                        <?php if (Yii::$app->user->identity->{'View Power PI'}) : ?>

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl('powerbi') ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('powerbi') ? 'active' : '' ?>" title="Power BI Reports">
                                    <i class="nav-icon fa fa-chart-bar"></i>
                                    <p>
                                        Power Bi Reports
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>powerbi" class="nav-link <?= Yii::$app->recruitment->currentaction('powerbi', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Bi Reports </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        <?php endif;  ?>

                        <?php if (YII_ENV_DEV) { // start blocking phase2 modules if in prod env 
                        ?>
                            <!-- Employee Induction -->

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['induction', 'periodic-induction']) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['induction', 'periodic-induction']) ? 'active' : '' ?>" title="Employee Induction">
                                    <i class="nav-icon fa fa-chart-bar"></i>
                                    <p>
                                        Employee Induction
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <!-- <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>induction" class="nav-link <?= Yii::$app->recruitment->currentaction('induction', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Individual </p>
                                        </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>induction/individual-hod" class="nav-link <?= Yii::$app->recruitment->currentaction('induction', 'individual-hod') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Individual </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>periodic-induction" class="nav-link <?= Yii::$app->recruitment->currentaction('periodic-induction', ['index', 'update']) ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Periodic </p>
                                        </a>
                                    </li>

                                    <!-- <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>periodic-induction/periodic-hod" class="nav-link <?= Yii::$app->recruitment->currentaction('periodic-induction', 'periodic-hod') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Periodic HOD List </p>
                                        </a>
                                    </li> -->

                                </ul>
                            </li>

                            <!-- Complete Induction -->

                            <!-- Start Training -->


                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['training', 'training-group', 'training-program', 'training-academic', 'training-applications', 'training-pending', 'training-approved']) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['training', 'training-group', 'training-program', 'training-academic', 'training-applications', 'training-pending', 'training-approved']) ? 'active' : '' ?>" title="Employee Training Management">
                                    <i class="nav-icon fa fa-chart-bar"></i>
                                    <p>
                                        Training
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-academic" class="nav-link <?= Yii::$app->recruitment->currentaction('training-academic', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Approved CPD </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-group" class="nav-link <?= Yii::$app->recruitment->currentaction('training-group', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Group Training </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-program" class="nav-link <?= Yii::$app->recruitment->currentaction('training-program', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Program Training </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-applications" class="nav-link <?= Yii::$app->recruitment->currentaction('training-applications', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Training Applications </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-pending" class="nav-link <?= Yii::$app->recruitment->currentaction('training-pending', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Pending Applications </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-approved" class="nav-link <?= Yii::$app->recruitment->currentaction('training-approved', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Approved Applications </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-approved/line-manager" class="nav-link <?= Yii::$app->recruitment->currentaction('training-approved', 'line-manager') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Line Mgr. List </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-approved/hro" class="nav-link <?= Yii::$app->recruitment->currentaction('training-approved', 'hro') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>HRO list </p>
                                        </a>
                                    </li>



                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>training-approved/closed" class="nav-link <?= Yii::$app->recruitment->currentaction('training-approved', 'closed') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Closed List </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- Complete Training -->


                            <!-- Recruitment -->
                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['recruitment']) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['recruitment']) ? 'active' : '' ?>" title="Employee Induction">
                                    <i class="nav-icon fa fa-chart-bar"></i>
                                    <p>
                                        Recruitment
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>job-requisition" class="nav-link <?= Yii::$app->recruitment->currentaction('job-requisition', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p> Open Job Requisitions </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>

                            <!-- Disciplinary -->
                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['grievance']) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['grievance']) ? 'active' : '' ?>" title="Grievances and Disciplinary Management">
                                    <i class="nav-icon fa fa-chart-bar"></i>
                                    <p class="text-truncate">
                                        Grievances
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>grievance" class="nav-link <?= Yii::$app->recruitment->currentaction('grievance', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Grievances List </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>grievance/hro" class="nav-link <?= Yii::$app->recruitment->currentaction('grievance', 'hro') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>HRO List </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>grievance/hrm" class="nav-link <?= Yii::$app->recruitment->currentaction('grievance', 'hrm') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>HRM list </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>grievance/hoh" class="nav-link <?= Yii::$app->recruitment->currentaction('grievance', 'hoh') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>HOH list </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>grievance/closed" class="nav-link <?= Yii::$app->recruitment->currentaction('grievance', 'closed') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Closed list </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>

                            <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['discipline']) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['discipline']) ? 'active' : '' ?>" title="Grievances and Disciplinary Management">
                                    <i class="nav-icon fa fa-chart-bar"></i>
                                    <p class="text-truncate">
                                        Disciplinary
                                        <i class="fas fa-angle-left right"></i>
                                        <!--<span class="badge badge-info right">6</span>-->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>discipline" class="nav-link <?= Yii::$app->recruitment->currentaction('discipline', 'index') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Disciplinary Cases </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="<?= $absoluteUrl ?>discipline/closed" class="nav-link <?= Yii::$app->recruitment->currentaction('discipline', 'closed') ? 'active' : '' ?>">
                                            <i class="fa fa-chart-line nav-icon"></i>
                                            <p>Closed Disciplinary Cases </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        <?php } // End module blocking 
                        ?>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <!--<li class="breadcrumb-item"><a href="site">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>-->
                                <?=
                                Breadcrumbs::widget([
                                    'itemTemplate' => "<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                                    'homeLink' => [
                                        'label' => Yii::t('yii', 'Home'),
                                        'url' => Yii::$app->homeUrl,
                                    ],
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </ol>

                        </div><!-- /.col-6 bread ish -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?= $content ?>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->


        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= Yii::$app->params['generalTitle'] ?> - 2014 - <?= date('Y') ?> <a href="#"> <?= strtoupper(Yii::$app->params['demoCompany']) ?></a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b><?= Yii::signature() ?></b>
            </div>
        </footer>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-light">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->




    </div>

</body>


<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();

/*function currentCtrl($ctrl){
    $controller = Yii::$app->controller->id;

    if(is_array($ctrl)){
        if(in_array($controller,$ctrl)){
            return true;
        }
    }
    if($controller == $ctrl ){
        return true;
    }else{
        return false;
    }
}*/

/*function currentaction($ctrl,$actn){//modify it to accept an array of controllers as an argument--> later please
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if($controller == $ctrl && $action == $actn){
        return true;
    }else{
        return false;
    }
}*/

?>
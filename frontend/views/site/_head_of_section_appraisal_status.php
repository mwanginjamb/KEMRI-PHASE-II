<?php if (Yii::$app->user->identity->{'Head of Section'}) : ?>
    <div class="row">

        <!-- /.col Appraisal Status Lists for Hed of Sections -->
        <?php if (Yii::$app->dashboard->inSupervisorList()) : ?>

            <div class="col-12 col-sm-6 col-md-3">
                <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/prob-status-hsec' ?>" target="_blank">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-wrap">HoS probation Status</span>
                            <span class="primary-box-number"><?= number_format(Yii::$app->dashboard->getProbationHsCount()) ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->


            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/st-status-hsec' ?>" target="_blank">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-wrap">Hos ShortTerm Status</span>
                            <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getShorttermHsCount()) ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->


            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <a href="<?= Yii::$app->recruitment->absoluteUrl() . 'appraisal/lt-status-hsec' ?>" target="_blank">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-wrap">Hos LongTerm Status</span>
                            <span class="info-box-number"><?= number_format(Yii::$app->dashboard->getLongtermHsCount()) ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

        <?php endif; ?>
    </div>
<?php endif; ?>
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<?php if ($Questions) : ?>
    <form class="form-horizontal">
        <div class="table-responsive">
            <table class="table table-bordered  table-highlight ScoresTable">
                <thead>
                    <th style="width:70em">Question</th>
                    <th style="width:20em">Score</th>
                    <th style="width:20em">Remarks</th>
                </thead>
                <tbody>
                    <?php foreach ($Questions as $Question) : ?>
                        <tr>
                            <td>
                                <textarea rows="5" class="form-control" readonly><?= @$Question->Question ?></textarea>
                            </td>
                            <td>
                                <?= Html::dropDownList('Rating', [@$Question->Rating], ArrayHelper::map($getInterviewRatings, 'Code', 'Name'), ['prompt' => 'Select Criteria', 'required' => true, 'class' => 'form-control Score']) ?>
                                <input type="hidden" class="form-control Key" value="<?= @$Question->Key ?>">
                            </td>
                            <td>
                                <textarea rows="5" class="form-control OverallComments"><?= @$Question->Overall_Comments ?></textarea>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
<?php endif; ?>
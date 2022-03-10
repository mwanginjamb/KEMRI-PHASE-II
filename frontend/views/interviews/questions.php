<?php if($Questions): ?>
    <form class="form-horizontal">
        <div class="table-responsive">
            <table class="table table-bordered  table-highlight ScoresTable">
                <thead>
                    <th  style="width:70em">Question</th>
                    <th style="width:20em">Score</th>
                </thead>
                <tbody>
                    <?php foreach($Questions as $Question ): ?>
                        <tr>
                            <td>
                                <textarea rows="5" class="form-control" readonly ><?= @$Question->Question ?></textarea> 
                            </td>
                            <td>
                                <input type="text" class="form-control Score" value="<?= @$Question->Score ?>"/>
                                <input type="hidden"  class="form-control Key"  value="<?= @$Question->Key ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
    <?php endif; ?>
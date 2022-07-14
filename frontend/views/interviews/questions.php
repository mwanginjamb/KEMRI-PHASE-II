<?php if($Questions): ?>
    <form class="form-horizontal">
        <div class="table-responsive">
            <table class="table table-bordered  table-highlight ScoresTable">
                <thead>
                    <th  style="width:70em">Question</th>
                    <th style="width:20em">Score</th>
                    <th style="width:20em">Remarks</th>
                </thead>
                <tbody>
                    <?php foreach($Questions as $Question ): ?>
                        <tr>
                            <td>
                                <textarea rows="5" class="form-control" readonly ><?= @$Question->Question ?></textarea> 
                            </td>
                            <td>
                                <select class="form-control Score" id="cars">
                                    <option value="">Select Score</option>
                                    <?php foreach($getInterviewRatings as $InterviewRating): ?>
                                        <option value="<?= $InterviewRating['Code'] ?>"><?= $InterviewRating['Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                
                                <input type="hidden"  class="form-control Key"  value="<?= @$Question->Key ?>">
                            </td>
                            <td>
                            <textarea rows="5" class="form-control OverallComments" ><?= @$Question->Overall_Comments ?></textarea>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
    <?php endif; ?>
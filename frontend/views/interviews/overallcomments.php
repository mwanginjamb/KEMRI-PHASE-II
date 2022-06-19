    <form class="form-horizontal">
        <div class="table-responsive">
            <table class="table table-bordered  table-highlight ScoresTable">
                <thead>
                    <th  style="width:70em">Question</th>
                    <th style="width:20em">Score</th>
                </thead>
                <tbody>
                        <tr>
                            <td>
                                <textarea rows="5" class="form-control" readonly ><?= @$Question->Question ?></textarea> 
                            </td>

                        </tr>
                </tbody>
            </table>
        </div>
    </form>

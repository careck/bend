<?php if (!empty($readingdates)) : ?>
    <table width="80%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Number of Readings</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($readingdates as $date => $num) { ?>
                <tr>
                    <td><?php echo formatDate($date); ?></td>
                    <td><?php echo $num; ?></td>
                    <td><?php echo Html::b("/bend-electricity/assignperiodtoreadings/{$periodid}/{$date}", "Assign Period"); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Sorry no readings.</p>    
<?php endif; ?>
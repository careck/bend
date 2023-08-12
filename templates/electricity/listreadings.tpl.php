<?php if (!empty($readings)) : ?>
    <table width="80%">
        <thead>
            <tr>
                <th>Reading Date</th>
                <th>Electricity Period</th>
                <th>Reading Value</th>
                <th>Previous Value</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($readings as $r) { ?>
                <tr>
                    <td><?php echo formatDate($r->d_date); ?></td>
                    <td><?php echo $r->bend_electricity_period_id; ?></td>
                    <td><?php echo $r->value; ?></td>
                    <td><?php echo $r->previous_value; ?></td>
                    <td><?php echo Html::box("/bend-electricity/editreading/{$meter->id}/{$r->id}", "Edit", true); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Sorry no readings.</p>    
<?php endif; ?>
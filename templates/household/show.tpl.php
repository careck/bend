<h1>Household #<?php echo $household->streetnumber ?></h1>
<div class="tabs">
    <div class="tab-head">
        <a href="#household">Household</a>
        <a href="#occupants">Occupants</a>
        <a href="#meters">Meters</a>
        <a href="#readings">Readings</a>
    </div>
</div>
<div class="tab-body">
    <div id="household">
        <?php echo Html::box("/bend-household/edit/{$household->bend_lot_id}/" . $household->id, "Edit Household", true); ?>
        <div class="row-fluid small-12">
            <?php echo $table ?>
        </div>
    </div>
    <div id="occupants">
        <h2>Current Occupants</h2>
        <?php echo Html::box("/bend-household/editoccupant/{$household->id}", "Add Occupant", true); ?>

        <?php if (!empty($currentOccupants)) : ?>
            <table width="80%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Occupant From</th>
                        <th>Occupant To</th>
                        <th>Pays Electricity?</th>
                        <th>Does Workhours?</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($currentOccupants as $oc) { ?>
                        <tr>
                            <td><?php echo $oc->getFullName() ?></td>
                            <td><?php echo formatDate($oc->d_start) ?></td>
                            <td><?php echo formatDate($oc->d_end) ?></td>
                            <td><?php echo $oc->pays_electricity ? "YES" : "NO" ?>
                            <td><?php echo $oc->does_workhours ? "YES" : "NO" ?>
                            <td><?php echo Html::box("/bend-household/editoccupant/{$household->id}/{$oc->id}", "Edit", true); ?>
                                <?php echo Html::b("/bend-household/deleteoccupant/{$household->id}/{$oc->id}", "Remove", "Are you certain to remove this occupant?"); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif;
        if (!empty($pastOccupants)) : ?>
            <h2>Past Occupants</h2>
            <table width="80%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Occupant From</th>
                        <th>Occupant To</th>
                        <th>Paid Electricity?</th>
                        <th>Did Workhours?</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pastOccupants as $oc) { ?>
                        <tr>
                            <td><?php echo $oc->getFullName() ?></td>
                            <td><?php echo formatDate($oc->d_start) ?></td>
                            <td><?php echo formatDate($oc->d_end) ?></td>
                            <td><?php echo $oc->pays_electricity ? "YES" : "NO" ?>
                            <td><?php echo $oc->does_workhours ? "YES" : "NO" ?>
                            <td><?php echo Html::box("/bend-household/editoccupant/{$household->id}/{$oc->id}", "Edit", true); ?>
                                <?php echo Html::b("/bend-household/deleteoccupant/{$household->id}/{$oc->id}", "Remove", "Are you certain to remove this occupant?"); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div id="meters">
        <?php echo Html::box("/bend-electricity/editmeter/{$household->id}", "Add Meter", true); ?>
        
        <?php if (!empty($meters)) : ?>
            <table width="80%">
                <thead>
                    <tr>
                        <th>Meter Number</th>
                        <th>Last Reading</th>
                        <th>Last Reading Date</th>
                        <th>Start Date</th>
                        <th>Initial Reading</th>
                        <th>Is Inverter</th>
                        <th>Is Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($meters as $m) { ?>
                        <tr>
                            <td><?php echo $m->meter_number; ?></td>
                            <td><?php echo $m->last_reading_value; ?></td>
                            <td><?php echo formatDate($m->d_end); ?></td>
                            <td><?php echo formatDate($m->d_start); ?></td>
                            <td><?php echo $m->start_value; ?></td>
                            <td><?php echo $m->is_inverter ? "YES" : "NO"; ?></td>
                            <td><?php echo $m->is_active ? "YES" : "NO"; ?></td>
                            <td><?php echo Html::box("/bend-electricity/editmeter/{$household->id}/{$m->id}", "Edit", true); ?>
                            <?php echo Html::box("/bend-electricity/listreadings/{$household->id}/{$m->id}", "Readings", true); ?></td>
                       </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif;?>
    </div>
    <div id="readings">
        <?php echo Html::box("/bend-electricity/editreading/{$household->id}", "Add Reading", true); ?>
        
        <?php if (!empty($readings)) : ?>
            <table width="80%">
                <thead>
                    <tr>
                        <th>Meter Number</th>
                        <th>Type</th>
                        <th>Electricity Period</th>
                        <th>Date</th>
                        <th>Value</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($readings as $r) { 
                        $meter = $r->getMeter();?>
                        <tr>
                            <td><?php echo $meter->meter_number; ?></td>
                            <td><?php echo $meter->is_inverter ? "INVERTER" : "METER"; ?></td>
                            <td><?php echo !empty($r->getElectricityPeriod()) ? $r->getElectricityPeriod()->getSelectOptionTitle() : "" ?></td>
                            <td><?php echo formatDate($r->d_date); ?></td>
                            <td><?php echo $r->value; ?></td>
                            <td><?php echo Html::box("/bend-electricity/editreading/{$household->id}/{$r->id}", "Edit", true); ?></td>
                       </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No readings found</p>
        <?php endif;?>
    </div>
</div>
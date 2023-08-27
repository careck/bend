<h1>Electricity Admin</h1>
<div class="tabs">
    <div class="tab-head">
        <a href="#periods">Electricity Periods</a>
        <a href="#readings">Electricity Readings</a>
    </div>
</div>
<div class="tab-body">
    <div id="periods">
        <h2>Periods</h2>
        <?php echo Html::box("/bend-electricity/editperiod/", "Add Period", true); ?>

        <?php if (!empty($periods)) : ?>
            <table width="80%">
                <thead>
                    <tr>
                        <th>Invoice Date</th>
                        <th>Period Start</th>
                        <th>Period End</th>
                        <th>Invoice Total inc. GST</th>
                        <th>Provider Total Consumption</th>
                        <th>Provider Total Production</th>
                        <th>Bend Total Consumption</th>
                        <th>Bend Total Production</th>
                        <th>Bend Total Invoiced</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($periods as $p) { ?>
                        <tr>
                            <td><?php echo formatDate($p->d_provider_invoice) ?></td>
                            <td><?php echo formatDate($p->d_provider_period_start) ?></td>
                            <td><?php echo formatDate($p->d_provider_period_end) ?></td>
                            <td><?php echo $p->provider_invoice_total_inc_gst ?></td>
                            <td><?php echo $p->provider_total_consumption_kwh ?></td>
                            <td><?php echo $p->provider_total_production_kwh ?></td>
                            <td><?php echo $p->getBendTotalConsumption() ?></td>
                            <td><?php echo $p->getBendTotalProduction() ?></td>
                            <td><?php echo $p->bend_total_invoiced ?></td>
                            <td><?php echo Html::box("/bend-electricity/editperiod/{$p->id}", "Edit", true); ?>
                            <?php echo Html::box("/bend-electricity/listreadingsbydate/{$p->id}", "Assign Period", true); ?>
                            <?php echo Html::box("/bend-electricity/showhouseholdusageforperiod/{$p->id}", "Show", true); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div id="readings">
        <?php echo Html::b("/bend-electricity/readingwizard/", "Add Reading"); ?>
        <?php if (!empty($readings)) : ?>
            <table width="80%">
                <thead>
                    <tr>
                        <th>Household</th>
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
                        if (!empty($r->getMeter())) {
                            $meter = $r->getMeter();
                            $household = $meter->getHousehold();?>
                            <tr>
                                <td><?php echo $household->getSelectOptionTitle(); ?></td>
                                <td><?php echo $meter->meter_number; ?></td>
                                <td><?php echo $meter->is_inverter ? "INVERTER" : "METER"; ?></td>
                                <td><?php echo !empty($r->getElectricityPeriod()) ? $r->getElectricityPeriod()->getSelectOptionTitle() : "" ?></td>
                                <td><?php echo formatDate($r->d_date); ?></td>
                                <td><?php echo $r->value; ?></td>
                                <td><?php echo Html::box("/bend-electricity/editreading/{$meter->id}/{$r->id}?backto=".urlencode("bend-electricity/admin#readings"), "Edit", true); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No readings found</p>
        <?php endif; ?>
    </div>
</div>
<h1>Electricity Admin</h1>
<div class="tabs">
    <div class="tab-head">
        <a href="#periods">Electricity Periods</a>
        <a href="#meters">Electricity Meters</a>
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
                            <td><?php echo $p->bend_total_consumption_kwh ?></td>
                            <td><?php echo $p->bend_total_production_kwh ?></td>
                            <td><?php echo $p->bend_total_invoiced ?></td>
                            <td><?php echo Html::box("/bend-electricity/editperiod/{$p->id}", "Edit", true); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div id="meters">
    </div>
</div>
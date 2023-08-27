<h2><?php echo $period->getSelectOptionTitle() ?></h2>
<table width="80%">
    <thead>
        <tr>
            <th>Household</th>
            <th>Consumption</th>
            <th>Production</th>
            <th>Net</th>
            <th>$ Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($households as $h){ ?>
            <tr>
                <td><?php echo $h->getSelectOptionTitle(); ?></td>
                <td><?php echo $h->getConsumptionForElectricityPeriod($period->id); ?></td>
                <td><?php echo $h->getProductionForElectricityPeriod($period->id); ?></td>
                <td><?php echo $h->getConsumptionForElectricityPeriod($period->id) - $h->getProductionForElectricityPeriod($period->id); ?></td>
                <td><?php echo "$0"; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
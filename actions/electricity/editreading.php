<?php
function editreading_GET(Web $w)
{
    list($meterid, $readingid) = $w->pathMatch("meterid", "readingid");
    if (empty($meterid)) {
        $w->out("no meter id provided");
        return;
    }
    $meter = BendService::getInstance($w)->getMeterForId($meterid);
    $reading = empty($readingid) ? new BendMeterReading($w) : BendService::getInstance($w)->getReadingForId($readingid);

    $form ["Reading"] = [
        [
            ["Meter number", "text", "meter_number", $meter->meter_number],
            ["Electricity Period", "select", "bend_electricity_period_id", !empty($reading->getElectricityPeriod()) ? $reading->getElectricityPeriod()->getSelectOptionTitle() : "", 
                BendService::getInstance($w)->getAllElectricityPeriods()],
            ["Type", "select", "is_inverter", $meter->is_inverter ? "INVERTER" : "METER", ["INVERTER", "METER"]],
        ],
        [
            ["Date", "date", "d_date", formatDate($reading->d_date)],
            ["Value", "text", "value", $reading->value],
            ["Notes", "text", "notes", $reading->notes],
        ]
    ];

    $backto = "";
    if (!empty($_GET['backto'])) {
        $backto = "?backto=".$_GET['backto'];
    }
    $w->out(Html::multiColForm($form, "/bend-electricity/editreading/{$meterid}/{$readingid}".$backto, "POST", "Save")); 

}

function editreading_POST(Web $w)
{
    list($meterid, $readingid) = $w->pathMatch("meterid", "readingid");
    if (empty($meterid)) {
        $w->out("no meter id provided");
        return;
    }
    $meter = BendService::getInstance($w)->getMeterForId($meterid);
    $reading = empty($readingid) ? new BendMeterReading($w) : BendService::getInstance($w)->getReadingForId($readingid);

    $last_reading = $meter->getLastReading();
  
    $reading->fill($_POST);

    //check if reading date is before last reading date and not in the future 
    if ($reading->d2Time($reading->d_date) > time()) {
        $w->error("Reading date cannot be in the future", "/bend-household/show/{$meter->bend_lot_id}/{$meter->bend_household_id}#readings");
        return;
    } 
    if (empty($reading->id) && !empty($last_reading) && $reading->d2Time($reading->d_date) < $last_reading->d_date) {
        $w->error("Reading date must be after last reading date", "/bend-household/show/{$meter->bend_lot_id}/{$meter->bend_household_id}#readings");
        return;
    }

    $reading->bend_meter_id = $meterid;
    $reading->insertOrUpdate();

    $meter->update();

    $target = "/bend-household/show/{$meter->bend_lot_id}/{$meter->bend_household_id}#readings";
    if (!empty($_GET['backto'])) {
        $target = $_GET['backto'];
    }
    $w->msg("Reading Updated", $target);
}
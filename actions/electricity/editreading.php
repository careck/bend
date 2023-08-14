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
            ["Electricity Period", "text", "bend_electricity_period", $reading->bend_electricity_period_id],
            ["Date", "date", "d_date", $reading->d_date],
            ["Value", "text", "value", $reading->value],
            ["Notes", "text", "notes", $reading->notes],

        ]
    ];

    //$w->setLayout(null);
    
    $w->out(Html::multiColForm($form, "/bend-electricity/editreading/{$meterid}/{$readingid}", "POST", "Save")); 

}

function editmeter_POST(Web $w)
{
    list($meterid, $readingid, $householdid) = $w->pathMatch("meterid", "readingid", "householdid");
    if (empty($meterid)) {
        $w->out("no meter id provided");
        return;
    }
    $meter = BendService::getInstance($w)->getMeterForId($meterid);
    $reading = empty($readingid) ? new BendMeterReading($w) : BendService::getInstance($w)->getReadingForId($readingid);
    $household = BendService::getInstance($w)->getHouseholdForId($householdid);

    $reading->fill($_POST);
    $reading->bend_meter_id = $meterid;
    $reading->insertOrUpdate();

    $w->msg("Reading Updated", "/bend-household/show/{$household->bend_lot_id}/{$meter->bend_household_id}#readings");
}
<?php
function editmeter_GET(Web $w)
{
    list($householdid, $meterid) = $w->pathMatch("householdid", "meterid");
    if (empty($householdid)) {
        $w->out("no household id provided");
        return;
    }
    $household = BendService::getInstance($w)->getHouseholdForId($householdid);
    $meter = empty($meterid) ? new BendMeter($w) : BendService::getInstance($w)->getMeterforId($meterid);

    $form ["Meter"] = [
        [
            ["Meter number", "text", "meter_number", $meter->meter_number],
            ["Last Reading Date", "date", "d_end", $meter->d_end],
            //["Last Meter reading", "text", "last_reading_value", $meter->last_reading_value],
            ["Is Inverter", "select", "is_inverter", $meter->is_inverter, [1 => "Yes", 0 => "No"]],
            //is active

        ]
    ];

    //$w->setLayout(null);
    
    $w->out(Html::multiColForm($form, "/bend-electricity/editmeter/{$householdid}/{$meter->id}", "POST", "Save")); 

}

function editmeter_POST(Web $w)
{
    list($householdid, $meterid) = $w->pathMatch("householdid", "meterid");
    if (empty($householdid)) {
        $w->out("no household id provided");
        return;
    }
    $household = BendService::getInstance($w)->getHouseholdForId($householdid);
    $meter = empty($meterid) ? new BendMeter($w) : BendService::getInstance($w)->getMeterforId($meterid);


    $meter->fill($_POST);
    $meter->bend_household_id = $householdid;
    $meter->insertOrUpdate();

    $w->msg("Meter updated", "/bend-household/show/{$household->bend_lot_id}/{$householdid}#electricity");
}
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
            ["Start Date", "date", "d_start", formatDate($meter->d_start)],
            ["Initial Reading", "text", "start_value", $meter->start_value],
            ["Is Inverter", "select", "is_inverter", $meter->is_inverter, $meter->getSelectOptions("is_inverter")],
            ["Is Active", "select", "is_active", $meter->is_active, $meter->getSelectOptions("is_active")],
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
    $meter->bend_lot_id = $household->bend_lot_id;
    $meter->insertOrUpdate();

    $w->msg("Meter updated", "/bend-household/show/{$household->bend_lot_id}/{$householdid}#meters");
}
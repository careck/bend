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
            ["Meter number", "text", "meter_number", $meter->meter_number]
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
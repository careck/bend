<?php
function edit_GET(Web $w)
{
    list($lotId, $householdid) = $w->pathMatch("lotId", "householdid");
    if (empty($lotId)) {
        $w->out("no lot id provided");
        return;
    }
    $lot = BendService::getInstance($w)->getLotForId($lotId);
    $household = new BendHousehold($w);
    if (!empty($householdid)) {
        $household = BendService::getInstance($w)->getHouseholdForId($householdid);
    }

    $form["Lot"] = array(
        array(
            array("Lot Number", "static", "", $lot->lot_number),
            array("Occupancy", "static", "", $lot->occupancy),
        ),
    );

    $form["Household"] = [
        [
            array("Streetnumber", "text", "streetnumber", $household->streetnumber),
            array("Is CHL", "select", "is_chl", $household->is_chl, $household->getSelectOptions("is_chl")),
            array("Is Occupied", "select", "is_occupied", $household->is_occupied, $household->getSelectOptions("is_occupied")),
            array("Number of Occupants", "text", "num_occupants", $household->num_occupants),
        ]
    ];

    $w->setLayout(null);
    $w->out(Html::multiColForm($form, "/bend-household/edit/{$lotId}/{$household->id}", "POST", "Save"));
}

function edit_POST(Web $w)
{
    list($lotId, $householdid) = $w->pathMatch("lotId", "householdid");
    if (empty($lotId)) {
        $w->out("no lot id provided");
        return;
    }
    $lot = BendService::getInstance($w)->getLotForId($lotId);
    $household = new BendHousehold($w);
    if (!empty($householdid)) {
        $household = BendService::getInstance($w)->getHouseholdForId($householdid);
    }

    $household->fill($_POST);
    $household->bend_lot_id = $lotId;
    $household->insertOrUpdate();

    $w->msg("Household updated", "/bend-household/show/{$lot->id}/{$household->id}#household");
}

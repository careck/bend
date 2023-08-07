<?php
function deleteoccupant_GET(Web $w)
{
    list($householdid, $occupantid) = $w->pathMatch("a", "b");

    $household = BendService::getInstance($w)->getHouseholdForId($householdid);
    if (empty($household)) {
        $w->error("Household not found");
    }

    $occupant = BendService::getInstance($w)->getHouseholdOccupantForId($occupantid);
    if (empty($occupant)) {
        $w->error("Occupant not found");
    }

    $occupant->delete();

    $w->msg("Occupant deleted", "/bend-household/show/{$household->bend_lot_id}/{$householdid}#occupants");
}

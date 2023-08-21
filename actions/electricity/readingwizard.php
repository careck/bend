<?php
function readingwizard_GET(Web $w)
{
    list($householdid) = $w->pathMatch("householdid");

    $form ["Reading"] = [
        [
            ["Household", "select", "bend_household_id", $householdid, BendService::getInstance($w)->getAllHouseholds()],
        ],[
            ["Meter", "select", "bend_meter_id", "", BendService::getInstance($w)->getMetersForHouseholdId($householdid, false)],
        ],[
            ["Value", "text", "value"],
        ]
    ];
    $w->ctx("form", Html::multiColForm($form, "/bend-electricity/readingwizard/", "POST", "Save & Next")); 
}

function readingwizard_POST(web $w)
{
    $reading = new BendMeterReading($w);

    $reading->fill($_POST);
    $reading->d_date = time();
    $reading->insert();

    $w->msg("Reading Updated", "/bend-electricity/readingwizard/{$_POST["bend_household_id"]}");
}
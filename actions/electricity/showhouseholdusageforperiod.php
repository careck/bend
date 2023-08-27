<?php

function showhouseholdusageforperiod_GET(Web $w)
{
    list($periodid) = $w->pathMatch("periodid");

    $period = BendService::getInstance($w)->getElectricityPeriodForId($periodid);
    $households = BendService::getInstance($w)->getAllHouseholds();

    $w->ctx("households", $households);
    $w->ctx("period", $period);
}
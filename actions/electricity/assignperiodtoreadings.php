<?php

function assignperiodtoreadings_GET(Web $w)
{
    list($periodid, $date) = $w->pathMatch("periodid", "date");

    $readings = BendService::getInstance($w)->getAllElectricityReadings();

    foreach ($readings as $reading) {
        if ($reading->d_date == $date) {
            $reading->bend_electricity_period_id = $periodid;
            $reading->insertOrUpdate();
        }
    }
    $w->msg("Period Assigned", "/bend-electricity/admin#periods");
}

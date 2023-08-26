<?php

function assignperiodtoreadings_GET(Web $w)
{
    list($periodid, $date) = $w->pathMatch("periodid", "date");

    $readings = BendService::getInstance($w)->getObjects("BendMeterReading", ["d_date" => formatDate($date, "Y-m-d")]);

    foreach ($readings as $reading) {
        if ($reading->d_date == $date && empty($reading->bend_electricity_period_id)) {
            $reading->bend_electricity_period_id = $periodid;
            $reading->update();
        }
    }
    $w->msg("Period Assigned", "/bend-electricity/admin#periods");
}

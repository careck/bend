<?php

function listreadingsbydate_GET(Web $w)
{
    $w->pathMatch("periodid");
    $readings = BendService::getInstance($w)->getAllElectricityReadings();
    
    $dateoccurances = [];
    foreach ($readings as $reading) {
        $date = $reading->d_date;
        if ($reading->bend_electricity_period_id == null) {
            $dateoccurances[$date] = isset($dateoccurances[$date]) ? $dateoccurances[$date] + 1 : 1;
        }
    }
    
    $w->ctx("readingdates", $dateoccurances);
};
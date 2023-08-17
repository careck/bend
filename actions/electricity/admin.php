<?php

function admin_GET(Web $w)
{
    History::add("Bend Electricity Admin");

    $w->ctx("periods", BendService::getInstance($w)->getAllElectricityPeriods());
}

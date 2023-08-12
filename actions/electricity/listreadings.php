<?php
function listreadings_GET(Web $w)
{
    list($meterid) = $w->pathMatch("meterid");
    if (empty($meterid)) {
        $w->out("no meter id provided");
        return;
    }
    $meter = BendService::getInstance($w)->getMeterForId($meterid);
    if (empty($meter)) {
        $w->error("Meter {$meterid} does not exist");
    } 
    
    $w->ctx("readings", BendService::getInstance($w)->getReadingsForMeterId($meterid));
    $w->ctx("meter", $meter);
}

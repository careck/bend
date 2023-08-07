<?php
function index_ALL(Web $w)
{
    History::add("Bend Households");
    $w->ctx("households", BendService::getInstance($w)->getAllHouseholds());
}

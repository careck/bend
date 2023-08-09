<?php

function index_ALL(Web $w)
{
    History::add("Bend Electricity");

    $w->ctx("fullName", AuthService::getInstance($w)->user()->getFullName());
    
}

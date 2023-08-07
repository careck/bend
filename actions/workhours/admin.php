<?php

function admin_ALL(Web $w) {
    History::add("Workhours Admin");
    $w->ctx("workperiods",BendService::getInstance($w)->getAllWorkPeriods());
    $w->ctx("focusgroups",BendService::getInstance($w)->getTopLevelWorkCategories());   
}

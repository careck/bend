<?php

function admin_ALL(Web $w) {
    History::add("Workhours Admin");
    $w->ctx("workperiods",$w->Bend->getAllWorkPeriods());
    $w->ctx("focusgroups",$w->Bend->getTopLevelWorkCategories());   
}

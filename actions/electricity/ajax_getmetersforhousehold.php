<?php
function ajax_getmetersforhousehold_GET(Web $w)
{
    $w->setLayout(null);
    list($id) = $w->pathMatch("id");
    $meters = BendService::getInstance($w)->getMetersForHouseholdId($id, false);
    $out = [];
    if (!empty($meters)) {
        foreach ($meters as $m) {
            $out[] = $m->toArray();
        }
    }
    $w->out(json_encode($out));
}

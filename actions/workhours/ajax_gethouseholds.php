<?php
function ajax_gethouseholds_GET(Web $w) {
	$w->setLayout(null);
	list($userid) = $w->pathMatch("a");
	$households = BendService::getInstance($w)->getHouseholdsForOccupantId($userid);
	$out = [];
	if (!empty($households)) {
		foreach ($households as $h) {
			$out[] = $h->toArray();
		}
	}
	$w->out(json_encode($out));
}
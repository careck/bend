<?php
function showperiod_GET(Web $w) {
	list($id) = $w->pathMatch("a");
	
	$wp = BendService::getInstance($w)->getWorkperiodForId($id);
	if (empty($wp)) {
		$w->error("Workperiod does not exist","/bend-workhours/admin#workperiods");
	}
	History::add("Work Period: ".formatDate($wp->d_start));
	$w->ctx("workperiod",$wp);
	$w->ctx("categories", BendService::getInstance($w)->getTopLevelWorkCategories());
	$w->ctx("households",BendService::getInstance($w)->getAllHouseholds());
	
}
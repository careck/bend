<?php
function listfiltered_GET(Web $w) {
	History::add("List Workhours");

	$userid = $w->request("userid",null);
	$householdid = $w->request("householdid",null);
	$periodid = $w->request("periodid",null);
	
	// get the user
	$user = null;
	if (!empty($userid)) {
		$user = AuthService::getInstance($w)->getUser($userid);
	} 

	// get workperiod
	$workperiod = null;
	if (!empty($periodid)) {
		$workperiod = BendService::getInstance($w)->getWorkPeriodForId($periodid);
	} 
	
	// get household
	$household = null;
	if (!empty($householdid)) {
		$household = BendService::getInstance($w)->getHouseholdForId($householdid);
	}
	
	$workentries = BendService::getInstance($w)->getWorkhoursFiltered($userid, $householdid, $periodid);
	$total_hours = 0;
	if (!empty($workentries)) {
		foreach ($workentries as $wea) {
			$total_hours += $wea->hours;
		}
	}
	$w->ctx("total_hours",$total_hours);
	$w->ctx("user",$user);
	$w->ctx("workentries",$workentries);
	$w->ctx("workperiod",$workperiod);
	$w->ctx("household",$household);
	
}
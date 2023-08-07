<?php
function deletehousehold_GET(Web $w) {
	list($lotid,$householdid) = $w->pathMatch("lotid","housholdid");
	if (!empty($lotid)) {
		$lot = BendService::getInstance($w)->getLotForId($lotid);
	}
	if(empty($lot)) {
		$w->error("lot not found");
	}
	if (!empty($householdid)) {
		$household = BendService::getInstance($w)->getHouseholdForId($householdid);
	}
	if (empty($household)) {
		$w->error("lot owner not found");
	}
	
	$household->delete();
	$w->msg("Household removed.","bend-lot/showlot/{$lotid}#households");
}
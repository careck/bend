<?php
function deletelotowner_GET(Web $w) {
	list($lotid,$ownerid) = $w->pathMatch("lotid","ownerid");
	if (!empty($lotid)) {
		$lot = BendService::getInstance($w)->getLotForId($lotid);
	}
	if (empty($lot)) {
		$w->error("lot not found");
	}
	if (!empty($ownerid)) {
		$owner = BendService::getInstance($w)->getBendLotOwnerForId($ownerid);
	}
	if (empty($owner)) {
		$w->error("lot owner not found");
	}
	
	$owner->delete();
	$w->msg("Owner removed.","bend-lot/showlot/{$lotid}#owners");
}
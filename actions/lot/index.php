<?php
function index_ALL(Web $w) {
	History::add("Bend Lots");
	$w->ctx("lots",BendService::getInstance($w)->getAllLots());
}
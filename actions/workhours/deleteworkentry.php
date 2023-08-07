<?php
function deleteworkentry_GET(Web $w) {
	list($id) = $w->pathMatch("id");
	if (!empty($id)) {
		$entry = BendService::getInstance($w)->getWorkEntryForId($id);
		if (!empty($entry) && $entry->canDelete(AuthService::getInstance($w)->user())) {
			try {
				$entry->delete();
			} catch (Exception $ex) {
				$_SESSION['error'] = $ex->getMessage();
				$w->ctx('error', $_SESSION['msg']);
				$w->redirect($_SERVER['HTTP_REFERER']);	
			}
		}
	}
	$_SESSION['msg'] = "Work Entry Deleted";
	$w->ctx('msg', $_SESSION['msg']);
	$w->redirect($_SERVER['HTTP_REFERER']);	
}
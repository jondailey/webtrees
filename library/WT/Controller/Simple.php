<?php
// Controller for all popup pages
//
// webtrees: Web based Family History software
// Copyright (C) 2013 webtrees development team.
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

if (!defined('WT_WEBTREES')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

class WT_Controller_Simple extends WT_Controller_Page {

	// Popup windows don't always need a title
	public function __construct() {
		parent::__construct();
		$this->setPageTitle(WT_WEBTREES);
	}

	// Simple (i.e. popup) windows are deprecated.
	public function pageHeader() {
		global $view;
		$view='simple';
		parent::pageHeader();
		return $this;
	}

	// Restrict access
	public function requireAdminLogin() {
		if (!WT_USER_IS_ADMIN) {
			$this->addInlineJavascript('opener.window.location.reload(); window.close();');
			exit;
		}
		return $this;
	}

	// Restrict access
	public function requireManagerLogin($ged_id=WT_GED_ID) {
		if (
			$ged_id==WT_GED_ID && !WT_USER_GEDCOM_ADMIN ||
			$ged_id!=WT_GED_ID && userGedcomAdmin(WT_USER_ID, $gedcom_id)
		) {
			$this->addInlineJavascript('opener.window.location.reload(); window.close();');
			exit;
		}
		return $this;
	}

	// Restrict access
	public function requireMemberLogin() {
		if (!WT_USER_ID) {
			$this->addInlineJavascript('opener.window.location.reload(); window.close();');
			exit;
		}
		return $this;
	}
}

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\crm\modules\appeal\models;

use frontend\modules\access\models\AccessControl;

class AccessAppeal extends AccessControl {



	protected $applyObjectServices ="frontend\modules\crm\modules\appeal\services\accessAppeal\AccessAppealApplyObjectServices";
	protected $NotificationServices ="frontend\modules\crm\modules\appeal\services\accessAppeal\AccessAppealNotificationServices";

	protected $AfterApplyObjectServices ="frontend\modules\crm\modules\appeal\services\accessAppeal\AccessAppealAfterApplyObjectServices";
	protected $CustomFunctionServices ="frontend\modules\crm\modules\appeal\services\accessAppeal\AccessAppealCustomFunctionServices";

	function getAfterApplyObjectServices(){
		return $this->AfterApplyObjectServices;
	}


	function check_all() {
		return true;
	}







}

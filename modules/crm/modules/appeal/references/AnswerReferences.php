<?php

namespace frontend\modules\crm\modules\appeal\references;


class AnswerReferences
{
    const CHANEL_EMAIL = 3;
	const CHANEL_COMMENT = 5;
	const CHANEL_SMS = 4;
	const CHANEL_CALL = 6;

    const READ_NO = 0;
    const READ_DELIVERED = 1;
    const READ_OPEN = 2;

    public static $serviceChanelObj = [
        self::CHANEL_EMAIL => '\frontend\modules\crm\modules\appeal\services\sendAppealAnswer\SendEmailAnswerService',
        self::CHANEL_COMMENT => '\frontend\modules\crm\modules\appeal\services\sendAppealAnswer\SendCommentAnswerService',
        self::CHANEL_SMS => '\frontend\modules\crm\modules\appeal\services\sendAppealAnswer\SendSmsAnswerService',
        self::CHANEL_CALL => '\frontend\modules\crm\modules\appeal\services\sendAppealAnswer\SendCallAnswerService',
    ];
	public static $serviceChanelRenderName = [
		self::CHANEL_EMAIL => 'Email',
		self::CHANEL_COMMENT => 'Комментарий',
		self::CHANEL_SMS => 'СМС',
		self::CHANEL_CALL => 'Звонок',
	];
}
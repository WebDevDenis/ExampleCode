<?php

namespace frontend\modules\crm\modules\appeal\references;


class ItemsReferences
{
    const CHANEL_MANUAL = 1;
    const CHANEL_API = 2;
    const CHANEL_EMAIL = 2;

    const CATEGORY_OVER = 1;


    public static $serviceChanelObj = [
        self::CHANEL_EMAIL => '\frontend\modules\crm\modules\appeal\services\sendAppealAnswer\SendEmailAnswerService',
    ];
}
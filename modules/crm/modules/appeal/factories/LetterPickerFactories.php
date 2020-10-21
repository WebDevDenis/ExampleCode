<?php

namespace frontend\modules\crm\modules\appeal\factories;


use yii\base\Model;
use frontend\modules\crm\modules\appeal\services\letterPickers\EmailLetterPickerServices;

class LetterPickerFactories extends Model
{

    static function start(){

        $mailConfigs=EmailLetterPickerServices::getListEmails();
        foreach ($mailConfigs as $conf) {
            $model=EmailLetterPickerServices::greactConecting($conf);
            $model->startPickers();
        }
    }
}
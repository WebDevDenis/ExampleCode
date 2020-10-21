<?php

namespace frontend\modules\crm\modules\appeal\repository;

use frontend\modules\crm\modules\appeal\models\base\AppealAnswer;

class AppealAnswerRepository
{

    /**
     * @param AppealAnswer $entity
     * @return array|bool
     */
    public static function createAppealAnswer(AppealAnswer $entity){
        if ($entity->save()) {
            return false;
        } else {
            return $entity->getErrors();
        }
    }
}
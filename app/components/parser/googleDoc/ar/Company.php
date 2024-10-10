<?php

namespace app\components\parser\googleDoc\ar;


use Yii;
use app\models\Company as BaseCompany;

/**
 * This is the model class for table "company".
 *
 * @property int         $id
 * @property string|null $title      Наименование компании
 * @property string|null $created_at Создано
 * @property string|null $updated_at Обновлено
 *
 * @property Budget[]    $budgets
 */
class Company extends BaseCompany
{
}

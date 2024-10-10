<?php

namespace app\components\parser\googleDoc\ar;


use app\models\Category as BaseCategory;

/**
 * This is the model class for table "category".
 *
 * @property int         $id
 * @property string|null $title      Наименование компании
 * @property string|null $created_at Создано
 * @property string|null $updated_at Обновлено
 *
 * @property Budget[]    $budgets
 */
class Category extends BaseCategory
{
}

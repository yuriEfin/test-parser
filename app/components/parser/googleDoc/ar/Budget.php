<?php

namespace app\components\parser\googleDoc\ar;


use Yii;
use app\models\Budget as BaseBudget;

/**
 * This is the model class for table "budget".
 *
 * @property int         $id
 * @property int|null    $month       Месяц
 * @property int|null    $company_id  Компания
 * @property int|null    $product_id  Товар
 * @property int|null    $category_id Категория
 * @property string|null $created_at  Создано
 * @property string|null $updated_at  Обновлено
 *
 * @property Category    $category
 * @property Company     $company
 * @property Product     $product
 */
class Budget extends BaseBudget
{
}

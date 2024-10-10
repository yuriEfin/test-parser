<?php

namespace app\models;


use Yii;
use yii\behaviors\TimestampBehavior;

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
class Budget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budget';
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::class => [
                'class' => TimestampBehavior::class,
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'company_id', 'product_id', 'category_id'], 'default', 'value' => null],
            [['month', 'company_id', 'product_id', 'category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'month'       => Yii::t('app', 'Месяц'),
            'company_id'  => Yii::t('app', 'Компания'),
            'product_id'  => Yii::t('app', 'Товар'),
            'category_id' => Yii::t('app', 'Категория'),
            'created_at'  => Yii::t('app', 'Создано'),
            'updated_at'  => Yii::t('app', 'Обновлено'),
        ];
    }
    
    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    
    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }
    
    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}

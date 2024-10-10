<?php

use yii\db\Migration;

class m241010_161009_create_table_company extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'company',
            [
                'id'         => $this->primaryKey(),
                'title'      => $this->string(500)->comment('Наименование компании'),
                'created_at' => $this->dateTime()->comment('Создано'),
                'updated_at' => $this->dateTime()->comment('Обновлено'),
            ]
        );
        
        $this->createTable(
            'category',
            [
                'id'         => $this->primaryKey(),
                'title'      => $this->string(500)->comment('Наименование компании'),
                'company_id' => $this->integer()->comment('Компания'),
                'created_at' => $this->dateTime()->comment('Создано'),
                'updated_at' => $this->dateTime()->comment('Обновлено'),
            ]
        );
        $this->addForeignKey('fk_category_company', 'category', 'company_id', 'company', 'id', 'CASCADE');
        
        $this->createTable(
            'product',
            [
                'id'          => $this->primaryKey(),
                'title'       => $this->string(500)->comment('Наименование компании'),
                'company_id'  => $this->integer()->comment('Компания'),
                'category_id' => $this->integer()->comment('Категория'),
                'created_at'  => $this->dateTime()->comment('Создано'),
                'updated_at'  => $this->dateTime()->comment('Обновлено'),
            ]
        );
        $this->addForeignKey('fk_product_company', 'product', 'company_id', 'company', 'id', 'CASCADE');
        $this->addForeignKey('fk_product_category', 'product', 'category_id', 'category', 'id', 'CASCADE');
        
        $this->createTable(
            'budget',
            [
                'id'          => $this->primaryKey(),
                'month'       => $this->integer()->comment('Месяц'),
                'company_id'  => $this->integer()->comment('Компания'),
                'product_id'  => $this->integer()->comment('Товар'),
                'category_id' => $this->integer()->comment('Категория'),
                'amount'      => $this->float(2)->comment('Бюджет/сумма'),
                'created_at'  => $this->dateTime()->comment('Создано'),
                'updated_at'  => $this->dateTime()->comment('Обновлено'),
            ]
        );
        
        $this->addForeignKey('fk_budget_company', 'budget', 'company_id', 'company', 'id', 'CASCADE');
        $this->addForeignKey('fk_budget_product', 'budget', 'product_id', 'product', 'id', 'CASCADE');
        $this->addForeignKey('fk_budget_category', 'budget', 'category_id', 'category', 'id', 'CASCADE');
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('fk_budget_company', 'budget');
        $this->dropForeignKey('fk_budget_product', 'budget');
        $this->dropForeignKey('fk_budget_category', 'budget');
        $this->dropForeignKey('fk_category_company', 'category');
        $this->dropForeignKey('fk_product_company', 'product');
        $this->dropForeignKey('fk_product_category', 'product');
        
        $this->dropTable('budget');
        $this->dropTable('product');
        $this->dropTable('category');
        $this->dropTable('company');
    }
}

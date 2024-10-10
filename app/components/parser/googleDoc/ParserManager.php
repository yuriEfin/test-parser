<?php

namespace app\components\parser\googleDoc;


use app\components\parser\googleDoc\ar\Company;
use app\components\parser\googleDoc\ar\Product;
use app\models\Budget;
use app\models\Category;
use linslin\yii2\curl\Curl;
use Yii;

class ParserManager
{
    public function __construct(
        private readonly Curl $httpClient,
    ) {
    }
    
    public function handle(string $url): void
    {
        $filePath = Yii::getAlias('@app/runtime/sheet.scv');
        $content = file_get_contents($url);
        file_put_contents($filePath, $content);
        
        $items = SheetParserFactory::create()->parse($filePath);
        
        foreach ($items as $key => $itemsMonth) {
            [$companyName, $categoryName, $productName] = explode('::', $key);
            if (!$productName) {
                continue;
            }
            
            $companyId = $this->createOrUpdateCompany($companyName);
            $categoryId = $this->createOrUpdateCategory($companyId, $categoryName);
            $productId = $this->createOrUpdateProduct($companyId, $categoryId, $productName);
            foreach ($itemsMonth as $month => $amount) {
                $this->createOrUpdateBudget($companyId, $categoryId, $productId, $month, $amount);
            }
        }
    }
    
    public function createOrUpdateCompany($companyName)
    {
        static $companyId;
        if (!$companyId) {
            $companyModel = Company::findOne(['title' => $companyName]) ?? new Company(['title' => $companyName]);
            $companyModel->save(false);
            
            $companyId = $companyModel->id;
        }
        
        return $companyId;
    }
    
    public function createOrUpdateCategory($companyId, $categoryName)
    {
        $categoryModel = Category::findOne(['title' => $categoryName, 'company_id' => $companyId])
            ?? new Category(['title' => $categoryName, 'company_id' => $companyId]);
        $categoryModel->save(false);
        
        return $categoryModel->id;
    }
    
    public function createOrUpdateProduct($companyId, $categoryId, $productName)
    {
        $productModel = Product::findOne(['title' => $productName, 'category_id' => $categoryId, 'company_id' => $companyId])
            ?? new Product(['title' => $productName, 'category_id' => $categoryId, 'company_id' => $companyId]);
        $productModel->save(false);
        
        return $productModel->id;
    }
    
    public function createOrUpdateBudget($companyId, $categoryId, $productId, $month, $amount): Budget
    {
        $budgetModel = Budget::findOne(
            [
                'company_id'  => $companyId,
                'category_id' => $categoryId,
                'product_id'  => $productId,
            ]
        ) ?? new Budget(
            [
                'company_id'  => $companyId,
                'category_id' => $categoryId,
                'product_id'  => $productId,
                'month'       => $month,
                'amount'      => $amount,
            ]
        );
        $budgetModel->save(false);
        
        return $budgetModel;
    }
}

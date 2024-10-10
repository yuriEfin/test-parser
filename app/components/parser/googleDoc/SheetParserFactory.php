<?php

namespace app\components\parser\googleDoc;


use app\components\parser\googleDoc\budget\CsvParser;

class SheetParserFactory
{
    public static function create(string $type = null)
    {
        // $type приведена как пример
        // исходя из типа или иных условий можно возвращать другие парсеры
        // например, чтоб учесть специфику парсинга др листов документа
        
        return \Yii::$container->get(CsvParser::class);
    }
}

<?php

use app\components\parser\googleDoc\budget\CsvParser;
use app\components\parser\interfaces\ParserManager;
use app\components\parser\googleDoc\budget\ParserInterface;

Yii::$container->setDefinitions(
    [
        ParserManager::class   => ParserManager::class,
        ParserInterface::class => CsvParser::class,
    ]
);

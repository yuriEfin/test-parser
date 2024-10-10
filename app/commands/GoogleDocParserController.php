<?php

namespace app\commands;


use app\components\parser\googleDoc\ParserManager;
use yii\console\Controller;

class GoogleDocParserController extends Controller
{
    public function __construct($id, $module, private readonly ParserManager $parserManager, $config = [])
    {
        parent::__construct($id, $module, $config);
    }
    
    public function actionIndex(string $url)
    {
        $this->parserManager->handle($url);
    }
}

<?php

namespace app\components\parser\googleDoc\budget;


use app\components\MonthEnum;
use app\components\parser\interfaces\ParserInterface;

class CsvParser implements ParserInterface
{
    private array $config = [
        'categories' => [
            'Electronic',
            'Print',
            'Direct Mail',
            'Fixed Internet',
            'New Vehicles',
            'Used Vehicles',
            'Used Vehicles - non Internet',
            'Store Specific Other',
        ],
        'end'        => 'CO-OP',
    ];
    
    public function parse(string $filePath): array
    {
        $items = [];
        $i = 0;
        $companyName = $category = $product = null;
        foreach ($this->loadData($filePath) as $row) {
            if ($i === 0) {
                $companyName = $row[0];
                ++$i;
                continue;
            }
            if ($row[0] === 'Total') {
                ++$i;
                continue;
            }
            if (in_array($row[0], $this->config['categories'])) {
                $category = $row[0];
                unset($row[0]);
                sort($row);
                continue;
            } else {
                $product = $row[0];
            }
            if ($i >= 2) {
                $items[$companyName . '::' . $category . '::' . $product] = [
                    MonthEnum::JANUARY   => $row[1],
                    MonthEnum::FEBRUARY  => $row[2],
                    MonthEnum::MARCH     => $row[3],
                    MonthEnum::APRIL     => $row[4],
                    MonthEnum::MAY       => $row[5],
                    MonthEnum::JUNE      => $row[6],
                    MonthEnum::JULY      => $row[7],
                    MonthEnum::AUGUST    => $row[8],
                    MonthEnum::SEPTEMBER => $row[9],
                    MonthEnum::OKTOBER   => $row[10],
                    MonthEnum::NOVEMBER  => $row[11],
                    MonthEnum::DECEMBER  => $row[12],
                ];
            }
            ++$i;
        }
        
        return $items;
    }
    
    private function loadData($filePath)
    {
        $handle = fopen($filePath, "r"); // open in readonly mode
        while (($row = fgetcsv($handle)) !== false) {
            yield $row;
        }
        fclose($handle);
    }
}

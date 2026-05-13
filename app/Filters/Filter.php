<?php

namespace App\Filters;
use Illuminate\Http\Request;
use DeepCopy\Exceptions\PropertyException;

abstract class Filter
{
    protected array $allowedOperatorsFields = [];

    protected array $translateOperatorsFields = [
        'gt' => '>',
        'lt' => '<',
        'eq' => '=',
        'gte' => '>=',
        'ne' => '!=',
        'in' => 'in',
        'lte' => '<=',
    ];

    public function filter(Request $request)
    {
        $where = [];
        $whereIn = [];

        if(empty($this->allowedOperatorsFields)) {
            throw new PropertyException('The property allowedOperatorsFields is required'); 
        }

        foreach ($this->allowedOperatorsFields as $param => $operators) {
            $queryOperator = $request->query($param);

            if ($queryOperator) {

                foreach ($queryOperator as $operator => $value) {
                    if (!in_array($operator, $operators)) {
                        throw new \Exception("The operator $operator is not allowed for the field $param");  
                    }

                    if(str_contains($value, '[')){
                        $whereIn[] =[
                           $param,
                           explode(',', str_replace(['[', ']'], ['', ''], $value)),
                           $value 
                        ];

                    } else {
                        $where[] = [
                            $param,
                            $this->translateOperatorsFields[$operator],
                            $value
                        ];
                    }
                }

                if(empty($where) && empty($whereIn)) {
                    return [];
                }

                return [
                    'where' => $where,
                    'whereIn' => $whereIn
                ];
            }
        }
    }
}
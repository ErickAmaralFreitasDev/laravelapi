<?php

namespace App\Filters;
use Illuminate\Http\Request;

class InvoiceFilter extends Filter
{
    protected array $allowedOperatorsFields = [
        'value' => ['gt', 'lt', 'eq', 'gte', 'ne', 'lte'],
        'type' => ['eq', 'ne', 'in'],
        'paid' => ['eq', 'ne'],
        'payment_date' => ['gt', 'lt', 'eq', 'gte', 'ne', 'lte'],
    ];
}
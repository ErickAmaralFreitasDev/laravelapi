<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; 

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    private array $types = [
        'B' => 'Boleto',
        'C' => 'Cartão',
        'P' => 'Pix',
    ];

    public function toArray(Request $request): array
    {
        $paid = $this->paid;
        return [
            'user' => [
                'firstName' => $this->user->first_name,
                'lastName' => $this->user->last_name,
                'fullName' => $this->user->first_name . ' ' . $this->user->last_name,
                'email' => $this->user->email,
            ],
            'type' => $this->types[$this->type] ?? 'Desconecido',
            'value' => 'R$ ' . number_format($this->value, 2, ',', '.'),
            'paid' => $paid ? 'Sim' : 'Não',
            'paymentDate' => $paid ? Carbon::parse($this->paymentDate)->format('d/m/Y H:i:s') : null,
            'paymentSince' => $paid ? Carbon::parse($this->paymentSince)->diffForHumans() : null,
        ];
    }
}

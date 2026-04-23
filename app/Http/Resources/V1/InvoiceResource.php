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
                'firstName' => $this->user->firstName,
                'lastName' => $this->user->lastName,
                'fullName' => $this->user->firstName . ' ' . $this->user->lastName,
                'email' => $this->user->email,
            ],
            'type' => $this->types[$this->type] ?? 'Desconecido',
            'value' => 'R$ ' . number_format($this->value, 2, ',', '.'),
            'paid' => $paid ? 'Sim' : 'Não',
            'payment_date' => $paid ? Carbon::parse($this->payment_date)->format('d/m/Y H:i:s') : null,
            'payment_since' => $paid ? Carbon::parse($this->payment_since)->diffForHumans() : null,
        ];
    }
}

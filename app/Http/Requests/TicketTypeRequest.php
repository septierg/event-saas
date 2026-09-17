<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            // Informations générales
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            // Tarif et quantité
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            // Période de vente
            'sales_start' => [
                'nullable',
                'date',
            ],

            'sales_end' => [
                'nullable',
                'date',
                'after_or_equal:sales_start',
            ],

            // Statut
            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ];
    }
}
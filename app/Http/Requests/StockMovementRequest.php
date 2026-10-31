<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'  => ['required', 'integer', 'exists:products,id'],
            'type'        => ['required', 'in:entree,sortie'],
            'quantity'    => ['required', 'integer', 'min:1', 'max:1000000'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Veuillez sélectionner un produit.',
            'product_id.integer'  => 'Le produit sélectionné est invalide.',
            'product_id.exists'   => 'Le produit sélectionné n\'existe pas.',

            'type.required'       => 'Veuillez choisir le type de mouvement.',
            'type.in'             => 'Le type doit être « entrée » ou « sortie ».',

            'quantity.required'   => 'La quantité est obligatoire.',
            'quantity.integer'    => 'La quantité doit être un nombre entier.',
            'quantity.min'        => 'La quantité doit être supérieure ou égale à 1.',
            'quantity.max'        => 'La quantité ne peut pas dépasser 1 000 000.',

            'description.string'  => 'Le motif doit être un texte.',
            'description.max'     => 'Le motif ne peut pas dépasser 255 caractères.',
        ];
    }
}
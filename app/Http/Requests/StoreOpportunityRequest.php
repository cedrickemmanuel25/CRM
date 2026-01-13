<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Auth is handled by middleware
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:200',
            'contact_id' => 'required|exists:contacts,id',
            'montant_estime' => 'required|numeric|min:0',
            'stade' => 'required|in:prospection,qualification,proposition,negociation,gagne,perdu',
            'probabilite' => 'required|integer|between:0,100',
            'date_cloture_prev' => 'required|date|after:today',
            'description' => 'nullable|string|max:2000',
            'commercial_id' => 'required', // can be 'auto' or integer
        ];
    }
}

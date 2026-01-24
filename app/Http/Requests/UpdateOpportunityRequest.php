<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        $opportunity = $this->route('opportunity');
        
        // Commercials can only update their own opportunities
        if ($this->user()->isCommercial() && $opportunity->commercial_id != $this->user()->id) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => 'sometimes|required|string|max:200',
            'contact_id' => 'sometimes|required|exists:contacts,id',
            'montant_estime' => 'sometimes|required|numeric|min:0',
            'stade' => 'sometimes|required|in:prospection,qualification,proposition,negociation,gagne,perdu',
            'probabilite' => 'sometimes|required|integer|between:0,100',
            'date_cloture_prev' => 'sometimes|required|date', // Removed after:today to allow editing past dates or current dates
            'description' => 'nullable|string|max:2000',
            'commercial_id' => 'sometimes|required|exists:users,id',
        ];
    }
}

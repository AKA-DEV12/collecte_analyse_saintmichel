<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecensementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'quartier' => 'required|string|max:255',
            'baptise' => 'boolean',
            'confirme' => 'boolean',
            'profession_de_foi' => 'boolean',
            'situation_matrimoniale' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'numero_whatsapp' => 'nullable|string|max:20',
            'situation_professionnelle' => 'required|string|max:255',
            'ceb' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'telephone.max' => 'Le numéro de téléphone est trop long.',
            'numero_whatsapp.max' => 'Le numéro WhatsApp est trop long.',
            'situation_professionnelle.max' => 'La situation professionnelle ne doit pas dépasser 255 caractères.',
            'nom.required' => 'Le nom est obligatoire.',
            'quartier.required' => 'Le quartier est obligatoire.',
            'situation_professionnelle.required' => 'La situation professionnelle est obligatoire.',          
        ];
    }
}

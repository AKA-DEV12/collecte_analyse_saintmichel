<?php

namespace App\Http\Requests\RendezVous\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAumonierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'title' => ['required','in:Aumônier jeunes,Aumônier adultes,Aumônier enfants'],
            'photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ];
    }
}

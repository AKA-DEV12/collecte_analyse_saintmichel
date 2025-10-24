<?php

namespace App\Http\Requests\RendezVous\Client;

use Illuminate\Foundation\Http\FormRequest;

class BookRendezVousRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'aumonier_id' => ['required','integer','exists:aumoniers,id'],
            'date_id' => ['required','integer','exists:schedule_dates,id'],
            'slot_id' => ['required','integer','exists:schedule_slots,id'],
            'client_name' => ['required','string','max:255'],
            'client_email' => ['required','email'],
            'subject' => ['required','string','max:500'],
        ];
    }
}

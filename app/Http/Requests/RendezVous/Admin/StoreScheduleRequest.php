<?php

namespace App\Http\Requests\RendezVous\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'aumonier_id' => ['required','integer','exists:aumoniers,id'],
            'use_global_quota' => ['required','boolean'],
            'global_quota' => ['nullable','integer','min:1'],
            'dates' => ['required','array','min:1'],
            'dates.*.date' => ['required','date','after_or_equal:today'],
            'dates.*.per_date_quota' => ['nullable','integer','min:1'],
            'dates.*.slots' => ['required','array','min:1'],
            'dates.*.slots.*.start_time' => ['required','date_format:H:i'],
            'dates.*.slots.*.end_time' => ['nullable','date_format:H:i','after:dates.*.slots.*.start_time'],
        ];
    }
}

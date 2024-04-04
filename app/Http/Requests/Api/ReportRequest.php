<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'reported_id' => 'required|exists:users,id',
            'chat_id' => 'nullable|exists:chats,id',
            'report_type_id' => 'nullable|exists:report_types,id',
            'description' => ['nullable', 'string', 'max:700'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['reporter_id' => $this->user()->id]);
    }
}

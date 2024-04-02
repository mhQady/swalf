<?php

namespace App\Http\Requests;

use App\Enums\Chat\MessageTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'message' => [
                function ($attribute, $value, $fail) {
                    if (!$value && !((isset ($this->files) && count($this->files) > 0) || isset ($this->voice)))
                        $fail(__('validation.required', ['attribute' => __("validation.attributes.$attribute")]));
                }
            ],
            'images' => ['nullable', 'array'],
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
            'voice' => ['nullable', 'file', 'mimetypes:audio/*', 'max:5120'],
        ];
    }

    protected function passedValidation(): void
    {
        $type = MessageTypeEnum::TEXT->value;

        if (isset($this->voice)) {
            $type = MessageTypeEnum::VOICE->value;
        } elseif (count($this->files)) {
            $type = MessageTypeEnum::IMAGE->value;
        }

        $this->merge(['type' => $type]);
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\Product\CommunicationWayEnum;
use Illuminate\Validation\Rule;
use App\Enums\PublishStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
            'city_id' => ['required', 'exists:cities,id'],
            'interest_id' => ['required', 'exists:interests,id'],
            'is_published' => ['required', Rule::in(PublishStatusEnum::values())],
            'files_ids' => ['nullable', 'array'],
            'files_ids.*' => ['nullable', 'integer', 'exists:media,id'],
            'allowed_way' => ['required', Rule::in([1, 2, 3])],
        ];
    }
}

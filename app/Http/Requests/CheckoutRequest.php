<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool { return $this->user() !== null; }

    public function rules(): array
    {
        return [
            'address_id' => ['required', 'exists:addresses,id'],
            'payment_method' => ['required', 'in:pix,boleto,credit_card'],
            'coupon_code' => ['nullable', 'string'],
        ];
    }
}

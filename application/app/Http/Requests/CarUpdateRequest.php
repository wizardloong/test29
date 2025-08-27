<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarUpdateRequest extends FormRequest
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
            'car_mark_id' => 'sometimes|required|exists:car_marks,id',
            'car_model_id' => 'sometimes|required|exists:car_models,id',
            'year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'sometimes|required|numeric|min:0',
            'color' => 'sometimes|required|string|max:50'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $carMarkId = $this->input('car_mark_id');
            $carModelId = $this->input('car_model_id');

            if ($carMarkId && $carModelId) {
                $carModel = \App\Models\CarModel::where('id', $carModelId)
                    ->where('car_mark_id', $carMarkId)
                    ->first();
                if (!$carModel) {
                    $validator->errors()->add('car_model_id', 'The selected car model does not belong to the specified car mark.');
                }
            }
        });
    }
}

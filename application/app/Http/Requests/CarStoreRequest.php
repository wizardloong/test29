<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarStoreRequest extends FormRequest
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
            'car_mark_name' => 'required|string',
            'car_model_name' => 'required|string',
            'year' => 'integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'integer|min:0',
            'color' => 'string|max:50'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $carMarkName = $this->input('car_mark_name');
            $carModelName = $this->input('car_model_name');

            if ($carMarkName && $carModelName) {
                $carMark = \App\Models\CarMark::where('name', $carMarkName)->first();
                if ($carMark) {
                    $carModel = \App\Models\CarModel::where('name', $carModelName)
                        ->where('car_mark_id', $carMark->id)
                        ->first();
                    if ($carModel) {
                        $car = \App\Models\Car::where('car_mark_id', $carMark->id)
                            ->where('car_model_id', $carModel->id)
                            ->first();
                        if ($car) {
                            $validator->errors()->add('car_model_name', 'The selected car already exists.');
                        }
                    }
                }
            }
        });
    }
}

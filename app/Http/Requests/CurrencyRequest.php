<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'unit' => 'required',
            'country_id' => "required|unique:currency,country_id,{$this->currency_id}",
        ];

        $banknotes = $this->input('banknotes');

        if (!empty($banknotes)) {
            foreach ($banknotes as $index => $banknote) {
                $rules += [
                    "banknotes.{$index}.name" => 'required',
                    "banknotes.{$index}.buying" => 'required|regex:/^\d*(\.\d{1,6})?$/',
                    "banknotes.{$index}.selling" => 'required|regex:/^\d*(\.\d{1,6})?$/'
                ];
            }
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [];

        $banknotes = $this->input('banknotes');

        if (!empty($banknotes)) {
            foreach ($this->input('banknotes') as $index => $banknote) {
                $messages += [
                    "banknotes.{$index}.name.required" => 'The banknote field is required',
                    "banknotes.{$index}.buying.required" => 'The buying price field is required',
                    "banknotes.{$index}.selling.required" => 'The selling price field is required',
                    "banknotes.{$index}.buying.regex" => 'The buying price field is invalid format',
                    "banknotes.{$index}.selling.regex" => 'The selling price field is invalid format'
                ];
            }
        }

        return $messages;
    }
}

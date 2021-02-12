<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeBlockRequest extends FormRequest
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
        return [
            'description' => 'required|min:1|max:255',
            'category_id' => 'required|integer',
            'block_length' => 'required|integer|min:1|:max:1440',
            'block_date' => 'required|date',
        ];
    }
    
    public function messages() 
    {
        return [
            'description.required' => "Не введено описание",
            'description.min' => "Слишком короткое описание",
            'description.max' => "Слишком длинное описание",
            'category_id.required' => "Не выбрана категория",
            'сategory_id.integer' => "Некорректное значение категории",
            'block_length.required' => "Не задана продолжительность",
            'block_length.integer' => "Некорректное значение продолжительности",
            'block_length.min' => "Минимальное значение для поля 'Продолжительность' равно 1",
            'block_length.max' => "Максимальное значение для поля 'Продолжительность' равно 1440",
            'block_date.required' => "Не задана дата",
            'block_date.date' => "Некорректное значение даты",
        ];
    }
}

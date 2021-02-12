<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'comment' => 'max:255',
            'subcategory_id' => 'required|integer',
            'priority' => 'required|integer|min:1|:max:100',
        ];
    }
    
    public function messages() 
    {
        return [
            'description.required' => "Не введено описание",
            'description.min' => "Слишком короткое описание",
            'description.max' => "Слишком длинное описание",
            'comment.max' => "Слишком длинный комментарий",
            'subсategory_id.required' => "Не выбрана подкатегория",
            'subсategory_id.integer' => "Некорректное значение подкатегории",
            'priority.required' => "Не задан приоритет",
            'priority.integer' => "Некорректное значение приоритета",
            'priority.min' => "Минимальное значение для поля 'Приоритет' равно 1",
            'priority.max' => "Максимальное значение для поля 'Приоритет' равно 100",
        ];
    }
    
}

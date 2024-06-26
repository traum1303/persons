<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\PersonGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexPeopleRequest extends FormRequest
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
        //first_name, last_name, age, gender, mobile_number, email, city, login, car_model, salary
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'age' => 'int|min:0|max:130',
            'age_min' => 'int|min:0|max:130',
            'age_max' => 'int|min:1|max:130',
            'gender' => [Rule::enum(PersonGender::class)],
            'mobile_number' => 'string',
            'email' => 'email',
            'city' => 'string',
            'login' => 'string',
            'car_model' => 'nullable|string',
            'salary' => 'int|min:0',
            'salary_min' => 'int|min:0',
            'salary_max' => 'int|min:1',
            'page' =>'int|min:1',
            'per_page' =>'int|min:1',
            'order' => 'array|min:1',
            'order.*' => ['string', Rule::in([
                'first_name',
                'last_name',
                'age',
                'gender',
                'mobile_number',
                'email',
                'city',
                'login',
                'car_model',
                'salary'])
            ],
            'order_first_name_direction' => Rule::in(['asc', 'desc']),
            'order_last_name_direction' => Rule::in(['asc', 'desc']),
            'order_age_direction' => Rule::in(['asc', 'desc']),
            'order_gender_direction' => Rule::in(['asc', 'desc']),
            'order_mobile_number_direction' => Rule::in(['asc', 'desc']),
            'order_email_direction' => Rule::in(['asc', 'desc']),
            'order_city_direction' => Rule::in(['asc', 'desc']),
            'order_login_direction' => Rule::in(['asc', 'desc']),
            'order_car_model_direction' => Rule::in(['asc', 'desc']),
            'order_salary_direction' => Rule::in(['asc', 'desc'])
        ];
    }
}

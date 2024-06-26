<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class PersonService
{

    public function index(array $request): Collection|array
    {
        $personQuery = Person::query();
        //first_name, last_name, age, gender, mobile_number, email, city, login, car_model, salary
        if (isset($request['first_name'])) {
            $personQuery->where('first_name', 'like', '%' . $request['first_name'] . '%');
        }
        if (isset($request['last_name'])) {
            $personQuery->where('last_name', 'like', '%' . $request['last_name'] . '%');
        }

        if (isset($request['age_min']) &&
            isset($request['age_max']) &&
            $request['age_max'] > $request['age_min'])
        {
            $personQuery->whereBetween('age', [$request['age_min'], $request['age_max']]);
        }
        elseif (isset($request['age_min']))
        {
            $personQuery->where('age', '>=', $request['age_min']);
        }
        elseif (isset($request['age_max']))
        {
            $personQuery->where('age', '<=', $request['age_max']);
        }
        elseif (isset($request['age']))
        {
            $personQuery->where('age', '=', $request['age']);
        }

        if (isset($request['gender'])) {
            $personQuery->where('gender', '=', $request['gender']);
        }
        if (isset($request['mobile_number'])) {
            if ('unset' == $request['mobile_number']) {
                $personQuery->whereNull('mobile_number');
            }else{
                $personQuery->where('mobile_number', '=', $request['mobile_number']);
            }
        }
        if (isset($request['email'])) {
            $personQuery->where('email', '=', $request['email']);
        }
        if (isset($request['city'])) {
            if ('unset' == $request['city']) {
                $personQuery->whereNull('city');
            }else{
                $personQuery->where('city', '=', $request['city']);
            }
        }
        if (isset($request['login'])) {
            $personQuery->where('login', '=', $request['login']);
        }
        if (isset($request['car_model'])) {
            if ('unset' == $request['car_model']) {
                $personQuery->whereNull('car_model');
            }else{
                $personQuery->where('car_model', '=', $request['car_model']);
            }
        }

        if (isset($request['salary_min']) &&
            isset($request['salary_max']) &&
            $request['salary_max'] > $request['salary_min'])
        {
            $personQuery->whereBetween('salary', [$request['salary_min'], $request['salary_max']]);
        }
        elseif (isset($request['salary_min']))
        {
            $personQuery->where('salary', '>=', $request['salary_min']);
        }
        elseif (isset($request['salary_max']))
        {
            $personQuery->where('salary', '<=', $request['salary_max']);
        }
        elseif (isset($request['salary']))
        {
            $personQuery->where('salary', '=', $request['salary']);
        }

        if (isset($request['page'])) {
            $personQuery->offset(($request['page'] - 1) * ($request['per_page'] ?? 50));
        }

        if (isset($request['order']) && is_array($request['order'])) {
            foreach ($request['order'] as $order) {
                $personQuery->orderBy($order, $request['order_'.$order.'_direction'] ?? 'asc');
            }
        }

        $personQuery->limit($request['per_page'] ?? 50);

        return $personQuery->get();
    }
}

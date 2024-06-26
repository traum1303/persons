<?php

namespace App\Traits;

use App\Enum\PersonGender;
use Faker\Generator;

trait PersonData
{
    private function getPersonData(Generator $faker = null): array
    {
        if (is_null($faker))
        {
            $faker = fake();
        }

        $gender = $this->getRandomGender($faker);

        return [
            'first_name' => $faker->firstName($gender->text()),
            'last_name' => $faker->lastName($gender->text()),
            'login' => $faker->unique()->userName(),
            'email' => $faker->unique()->safeEmail(),
            'mobile_number' => $this->getRandomPhoneNumber($faker),
            'age' => $faker->numberBetween(0, 130),
            'gender' => $gender->value,
            'city' => $faker->city(),
            'car_model' => $faker->randomElement(['bmw', 'audi', null, 'porsche', 'mercedes']),
            'salary' => $faker->numberBetween(0, 10000000000),
        ];
    }

    private function getRandomGender(Generator $faker): PersonGender
    {
        return $faker->randomElement(PersonGender::cases());
    }

    private function getRandomPhoneNumber(Generator $faker): ?string
    {
        return $faker->randomElement([true, false]) ? $faker->phoneNumber() : null;
    }
}

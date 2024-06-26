<?php
declare(strict_types=1);

namespace App\Services\Import\CSV;

use App\Enum\PersonGender;
use App\Interfaces\StorePeopleJobServiceInterface;
use App\Models\Person;
use Illuminate\Support\Facades\Log;
use Throwable;

class StoreFromCSVService implements StorePeopleJobServiceInterface
{
    /**
     * @throws Throwable
     */
    public function store(array $chunk): void
    {
        $personData = array_map([$this, 'getChunkedRows'], $chunk);
        try {
            Person::query()->getConnection()->transaction(function () use ($personData) {
                Person::query()->insertOrIgnore($personData);
            });
        } catch (Throwable $e)
        {
            Log::error($e->getMessage());
        }
    }

    private function getChunkedRows(string $chunk):array
    {
        $chunkedRows = str_getcsv($chunk);
        return [
            'first_name' => $chunkedRows[0],
            'last_name' => $chunkedRows[1],
            'login' => $chunkedRows[2],
            'email' => $chunkedRows[3],
            'mobile_number' => empty($chunkedRows[4]) ? null : $chunkedRows[4],
            'age' => (int) $chunkedRows[5],
            'gender' => PersonGender::from($chunkedRows[6]),
            'city' => $chunkedRows[7],
            'car_model' => empty($chunkedRows[8]) ? null : $chunkedRows[8],
            'salary' => empty($chunkedRows[9]) ? null : (int) $chunkedRows[9],
        ];
    }
}

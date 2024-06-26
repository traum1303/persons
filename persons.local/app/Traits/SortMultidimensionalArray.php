<?php

namespace App\Traits;

use Exception;

trait SortMultidimensionalArray
{

    /**
     * Retrieves the sorted array of banks and posts.
     *
     * @param  array  $array
     * @param  string  $firstLevelKey
     * @param  string  $secondLevelKeySort1
     * @param  string  $secondLevelKeySort2
     * @return array The sorted $data array.
     * @throws Exception
     */
    private function sortMultidimensionalArray(array $array, string $firstLevelKey, string $secondLevelKeySort1, string $secondLevelKeySort2): array {
        $column1Values = [];
        $column2Values = [];

        foreach ($array as $index => $item) {

            if (!isset($item[$firstLevelKey][$secondLevelKeySort1]) ){
                throw new Exception(sprintf('Element of the array does not have field [%1$s][%2$s]', $firstLevelKey, $secondLevelKeySort1 ));
            }

            if(!isset($item[$firstLevelKey][$secondLevelKeySort2])) {
                throw new Exception(sprintf('Element of the array does not have field [%1$s][%2$s]', $firstLevelKey, $secondLevelKeySort2 ));
            }

            $column1Values[$index] = $item[$firstLevelKey][$secondLevelKeySort1];
            $column2Values[$index] = $item[$firstLevelKey][$secondLevelKeySort2];
        }

        if (!$column1Values || !$column2Values) {
            return $array;
        }

        // Sort the arrays while preserving the keys
        array_multisort($column1Values, SORT_ASC, $column2Values, SORT_ASC, $array);

        return $array;
    }
}
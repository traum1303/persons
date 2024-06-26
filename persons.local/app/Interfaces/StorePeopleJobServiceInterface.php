<?php

namespace App\Interfaces;

use Throwable;

interface StorePeopleJobServiceInterface
{
    /**
     * @param array $chunk
     * @return void
     * @throws Throwable
     */
    public function store(array $chunk):void;
}

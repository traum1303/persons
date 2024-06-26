<?php

namespace App\Interfaces;

interface ImportProcessJobServiceInterface
{

    public function import(string $filePath):void;
}

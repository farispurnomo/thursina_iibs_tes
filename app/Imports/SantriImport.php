<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SantriImport implements WithStartRow, ToArray
{
    use Importable;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param  array  $array
     */
    public function array(array $array)
    {
        return $array;
    }
}

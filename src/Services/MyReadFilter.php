<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class MyReadFilter implements IReadFilter
{
    public function readCell($columnAddress, $row, $worksheetName = ""): bool
    {
        if ($row > 1) {
            return true;
        }
        return false;
    }

}
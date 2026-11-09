<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserTemplateExport implements Export, WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new UserTemplateDataSheet,
            // new UserTemplateInstructionsSheet,
        ];
    }
}

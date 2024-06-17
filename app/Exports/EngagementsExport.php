<?php

namespace App\Exports;

use App\Models\Engagement;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class EngagementsExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Engagement::query();
    }
}


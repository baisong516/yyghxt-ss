<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    public static function getReportData($start, $end)
    {
        $offices=Aiden::getAuthdOffices();
        $reports=Report::whereIn('office_id',array_keys($offices))
            ->where([
                ['date_tag','>=',$start],
                ['date_tag','<=',$end],
            ])->get();
        return $reports;
    }
}

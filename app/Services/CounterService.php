<?php
namespace App\Services;

use App\Models\Officer\OfficerModel;

class CounterService
{
    public function handleCounter($officer = null)
    {
        $counter = OfficerModel::findOrFail($officer)->counter()->first();

        if ($counter->status == 'Open') {
            $buttonChange = 'Close Counter';
            $buttonColor = 'btn-danger';
        } elseif ($counter->status == 'Close') {
            $buttonChange = 'Open Counter';
            $buttonColor = 'btn-primary';
        } else {
            $buttonChange = 'Open Counter';
            $buttonColor = 'btn-primary';
        }

        return [
            'counter' => $counter,
            'buttonChange' => $buttonChange,
            'buttonColor' => $buttonColor,
        ];
    }
}

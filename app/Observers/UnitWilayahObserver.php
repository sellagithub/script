<?php

namespace App\Observers;

use App\Models\Unit_wilayah;

class UnitWilayahObserver
{

    /**
     * @param Unit_wilayah $item
     */
    public function saving(Unit_wilayah $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->last_updated_by = user()->id;
        }
    }

    public function creating(Unit_wilayah $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->added_by = user()->id;
        }
    }

}

<?php

namespace App\Observers;

use App\Models\Pos_anggaran;

class PosAnggaranObserver
{

    /**
     * @param Pos_Anggaran $item
     */
    public function saving(Pos_Anggaran $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->last_updated_by = user()->id;
        }
    }

    public function creating(Pos_Anggaran $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->added_by = user()->id;
        }
    }

}

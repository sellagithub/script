<?php

namespace App\Observers;

use App\Models\Rekanan;

class RekananObserver
{

    /**
     * @param Rekanan $item
     */
    public function saving(Rekanan $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->last_updated_by = user()->id;
        }
    }

    public function creating(Rekanan $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->added_by = user()->id;
        }
    }

}

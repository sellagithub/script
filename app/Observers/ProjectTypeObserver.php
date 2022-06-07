<?php

namespace App\Observers;

use App\Models\Project_type;

class ProjectTypeObserver
{

    /**
     * @param Project_type $item
     */
    public function saving(Project_type $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->last_updated_by = user()->id;
        }
    }

    public function creating(Project_type $item)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $item->added_by = user()->id;
        }
    }

}

<?php


namespace App\Models;

use App\Observers\ProjectTypeObserver;
use Froiden\RestAPI\ApiModel;

/**
 * App\Models\ProjectCategory
 *
 * @property int $id
 * @property string $category_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $added_by
 * @property int|null $last_updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $project
 * @property-read int|null $project_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory whereLastUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Project_type extends ApiModel
{
    protected $table = 'project_types';
    protected $default = ['id','project_type_name'];

    protected static function boot()
    {
        parent::boot();
        static::observe(ProjectTypeObserver::class);
    }

    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public static function allTipeprojek()
    {
        if (user()->permission('view_project_type') == 'all') {
            return Project_type::all();
        }
        else {
            return Project_type::where('added_by', user()->id)->get();
        }
    }

}

//namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//class Project_type extends Model
//{
  //  use HasFactory;
//}

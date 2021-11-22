<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'title',
        'relation_id',
        'description',
        'deadline',
        'status_id'
    ];

    protected $table = 'tasks';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function relation()
    {
        return $this->belongsTo(Relation::class);
    }

    public function usercomments()
    {
        return $this->hasMany(Comment::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function admin($user_id)
    {

        if ($this->relation()->first()->admin_id == $user_id) {
            return true;
        }

        else return false;
    }
}

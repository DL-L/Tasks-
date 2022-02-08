<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Relation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'relations';

    protected $primaryKey = 'id';

    protected $fillable = [ 'admin_id', 'sub_id'];

    public $timestamps = false;

    public function usertasks()
    {
        return $this->hasMany(Task::class);
    }
}

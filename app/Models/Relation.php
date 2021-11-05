<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    protected $table = 'relations';

    protected $primaryKey = 'id';

    public function usertasks()
    {
        return $this->hasMany(Task::class);
    }
}

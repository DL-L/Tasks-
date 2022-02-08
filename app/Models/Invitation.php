<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Invitation extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'invitations';

    protected $fillable = ['from', 'to', 'validated'];

    protected $primaryKey = 'id';

    public function toUser()
    {
        return $this->belongsTo(User::class,'to');
    }
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }
    
}

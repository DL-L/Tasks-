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
        return $relation = $this->belongsTo(Relation::class);
    }

    public function usercomments()
    {
        return $this->hasMany(Comment::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function updateStatus($task)
    {
        $connected_user_id= auth()->user()->id;
       
        if ($task->admin($connected_user_id)) {
            return null;
        }else {
            $t = tap($task)->update([
                'status_id'=> 3,
            ])->save();
            return $task;
        }
    }

    public function updateTaskComment($task)
    {
        $connected_user_id= auth()->user()->id;
       
        if ($task->admin($connected_user_id)) {
            $comments =$task->usercomments()->get();
            foreach ($comments as $comment) {
                if ($comment->seen == false) {
                    $comment->updateStatus($comment);
                }else {
                    return null;
                }
            }
            return $task;
        }else {
            return null;
        }
    }

    public function updateStatusToReceived()
    {
        $connected_user_id= auth()->user()->id;
        if ($this->status->name == 'sent' ) {          
            tap($this)->update([
                'status_id'=> 2,
            ])->save();
        }
        return $this;
    }

    public function sub_user_id()
    {
        return $this->relation()->first()->sub_id;
    }

    public function admin_id()
    {
        return $this->relation()->first()->admin_id;
    }

    public function admin($user_id)
    {

        if ($this->relation()->first()->admin_id == $user_id) {
            return true;
        }

        else return false;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Relation;
use App\Models\Comment;
use App\Models\Status;
use App\Http\Resources\TasksResource;
use App\Http\Requests\TasksRequest;

class TasksController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        $connected_user_id= auth()->user()->id;
        $relation_id = Relation::where('sub_id', '=', $connected_user_id)
                            ->get();
        $array = array();
        foreach ($relation_id as $rel_id) {
            $relation_id = $rel_id->id;
            $array[] = $rel_id->id;
        }
        $tasks = Task::whereIn('relation_id', $array)->get();
        return response()->json($tasks, 200);
    }

    public function indexSub()
    {
        $connected_user_id= auth()->user()->id;
        $relation_id = Relation::where('admin_id', '=', $connected_user_id)
                            ->get();
        $array = array();
        foreach ($relation_id as $rel_id) {
            $relation_id = $rel_id->id;
            $array[] = $rel_id->id;
        }
        $tasks = Task::whereIn('relation_id', $array)->get();
        return response()->json($tasks, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = auth()->user();
        $admin_id = $admin->id;
        $sub_number = $request->sub_user;
        //TODO:change the number to username
        $sub_id = $admin->sub_user()
                        ->where('phone_number','=',$sub_number)
                        ->firstOrFail()
                        ->id;
        // $sub_id = User::where('phone_number','=', $sub_number)->firstOrFail()->id;
        $relation_id = Relation::where('admin_id', '=', $admin_id)
                            ->where('sub_id','=', $sub_id)
                            ->firstOrFail()
                            ->id;
        $task = Task::create([
            // 'uuid'=> Str::uuid(),
            'relation_id' => $relation_id,
            'title' => $request->title,
            'description' => $request->description,
            'status_id' => 1,
            'deadline' => $request->deadline,
        ]);

        return new TasksResource($task);
    }

    public function store_comment(Request $request, Task $task)
    {
        Comment::create([
            'task_id' => $task->id,
            'user_id' => auth()->user()->id,
            'seen' => false,
            'body' => $request->input('body'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return new TasksResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_update(Request $request, Task $task)
    {
        $task-> update([  
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline')
        ]);

        return new TasksResource($task);
    }

    public function sub_update(Request $request, Task $task)
    {
        $status_name = $request->input('status_name');
        $status_id = Status::where('name','=', $status_name)
                            ->firstOrFail()
                            ->id;
        $task->update([  
            'status_id' => $status_id,
        ]);

        return new TasksResource($task);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Relation;
use App\Models\Comment;
use App\Models\Status;
use App\Http\Resources\TasksResource;
use App\Http\Requests\TasksRequest;
use App\Notifications\TaskAdded;
use App\Events\ActionEvent;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('task.status.updater');
    }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $connected_user_id= auth()->user()->id;
        $relation_id = Relation::where('admin_id', '=', $connected_user_id)
                            -> orWhere('sub_id', '=', $connected_user_id)
                            ->get();
        $array = array();
        foreach ($relation_id as $rel_id) {
            $relation_id = $rel_id->id;
            $array[] = $rel_id->id;
        }
        $tasks = Task::whereIn('relation_id', $array)->get();
        return TasksResource::collection($tasks);

        // return response()->json($tasks, 200);
    }

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
        return TasksResource::collection($tasks);
        // return response()->json($tasks, 200);
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
        return TasksResource::collection($tasks);

        // return response()->json($tasks, 200);
    }

    public function getTasksAdmin(Request $request)
    {
        $connected_user_id= auth()->user()->id;
        $relation_id = Relation::where('admin_id', '=', $request-> admin_id)
                            ->where('sub_id', '=', $connected_user_id)
                            ->get();
        $array = array();
        foreach ($relation_id as $rel_id) {
            $relation_id = $rel_id->id;
            $array[] = $rel_id->id;
        }
        $tasks = Task::whereIn('relation_id', $array)->get();
        return TasksResource::collection($tasks);

        // return response()->json($tasks, 200);
    }

    public function getTasksSub(Request $request)
    {
        $connected_user_id= auth()->user()->id;
        $relation_id = Relation::where('admin_id', '=', $connected_user_id)
                            ->where('sub_id', '=', $request->sub_id)
                            ->get();
        $array = array();
        foreach ($relation_id as $rel_id) {
            $relation_id = $rel_id->id;
            $array[] = $rel_id->id;
        }
        $tasks = Task::whereIn('relation_id', $array)->get();
        return TasksResource::collection($tasks);

        // return response()->json($tasks, 200);
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
        $user_notify = $admin->sub_user()
                        ->where('phone_number','=',$sub_number)
                        ->firstOrFail();
        
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
        event(new ActionEvent($task));
        // $user_notify->notify(new TaskAdded($task));
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
        if ($task->status->name == 'sent' || $task->status->name =='received') {
            $task->updateStatus($task);
        }
        $task->updateTaskComment($task);
        return new TasksResource($task->fresh());
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
    public function admin_update(Request $request, $task)
    {
        $task = Task::find($task);
        $task-> update([  
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline')
        ]);
        

        return new TasksResource($task);
    }

    public function sub_update(Request $request, Task $task)
    {
        $task = Task::find($task)->first();
        $status_name = $request->input('status_name');
        $status_id = Status::where('name','=', $status_name)
                            ->firstOrFail()
                            ->id;
        $task->update([  
            'status_id' => $status_id,
        ]);
        if ($request->input('body')== null) {
            
        }else{
        Comment::create([
            'task_id' => $task->id,
            'user_id' => auth()->user()->id,
            'seen' => false,
            'body' => $request->input('body'),
        ]);}

        return new TasksResource($task);
    }

    public function status_update(Request $request, $task)
    {
        $task = Task::find($task);
        $task-> update([  
            'status_id' => $request->input('status_id'),
        ]);
        

        return new TasksResource($task);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $task = Task::find($id);
        $task->delete();
        return response(null, 204);
    }
}

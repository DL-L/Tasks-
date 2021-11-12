<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Relation;
use App\Models\User;
use App\Models\Status;
use App\Http\Resources\TasksResource;
use App\Http\Requests\TasksRequest;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $sub_number = $request->input('sub_user');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TasksRequest $task)
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
    public function admin_update(TasksRequest $request, $id)
    {
        $task = Task::where('id', $id)->update([  
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline')
        ]);

        return new TasksResource($task);
    }

    public function sub_update(TasksRequest $request, $id)
    {
        $status_name = $request->input('status_name');
        $status_id = Status::where('name','=', $status_name)
                            ->firstOrFail()
                            ->id;
        $task = Task::where('id', $id)->update([  
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

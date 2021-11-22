<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Relation;
use App\Http\Resources\UsersResource;
use App\Http\Resources\TasksResource;

class UsersController extends Controller
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
    public function indexAdmins()
    {
        $connected_user= auth()->user();
        $admin_users= $connected_user->admin_user;
        // return UsersResource::collection($admin_users);
        return response()->json($admin_users, 200);
    }

    public function indexSubs()
    {
        $connected_user= auth()->user();
        $sub_users= $connected_user->sub_user;
        return UsersResource::collection($sub_users);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAdminTasks($id)
    {
        $connected_user_id= auth()->user()->id;
        $relation_admin= Relation::where(['admin_id'=> $id,
                                    'sub_id' => $connected_user_id ])
                            ->firstOrFail();
        $tasks_admin= $relation_admin->usertasks;
        return TasksResource::collection($tasks_admin);
    }

    public function showSubTasks($id)
    {
        $connected_user_id= auth()->user()->id;
        $relation_sub= Relation::where(['admin_id'=> $connected_user_id,
                                    'sub_id' => $id ])
                                ->firstOrFail();
        $tasks_sub= $relation_sub->usertasks;
        $user_comments = User::where('id', '=', $id)->firstOrFail()->comments;
        // dd($user_comments);
        if ($user_comments) {
            foreach ($user_comments as $user_comment) {
                $user_comment->update([
                    'seen' => true
                    //notification
                ]);
            }
        }
        return TasksResource::collection($tasks_sub);
    }

    public function create_task($request,$id)
    {
       
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

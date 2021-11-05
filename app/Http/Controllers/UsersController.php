<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Relation;

class UsersController extends Controller
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
    public function indexAdmins()
    {
        $connected_user= auth()->user();
        $admin_users= $connected_user->admin_user->toJson(JSON_PRETTY_PRINT);
        if(!json_decode($admin_users)){
            abort(404, 'No admin found');
        }
        else return $admin_users;
        // dd($admin_users);
    }

    public function indexSubs()
    {
        $connected_user= auth()->user();
        $sub_users= $connected_user->sub_user->toJson(JSON_PRETTY_PRINT);
        if(!json_decode($sub_users)){
            abort(404, 'No sub found');
        }
        else return $sub_users;
        // dd($sub_users);
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
        $tasks_admin= $relation_admin->usertasks->toJson(JSON_PRETTY_PRINT);
        if(!json_decode($tasks_admin)){
            abort(404, 'No tasks found');
        }
        else return $tasks_admin;
        // dd($tasks_admin);   
    }

    public function showSubTasks($id)
    {
        $connected_user_id= auth()->user()->id;
        $relation_sub= Relation::where(['admin_id'=> $connected_user_id,
                                    'sub_id' => $id ])
                            ->firstOrFail();
        $tasks_sub= $relation_sub->usertasks->toJson(JSON_PRETTY_PRINT);
        if(!json_decode($tasks_sub)){
            abort(404, 'No tasks found');
        }
        else return $tasks_sub;        // dd($tasks_sub);   
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

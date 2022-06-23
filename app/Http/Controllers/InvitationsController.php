<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\User;
use App\Http\Resources\InvitationsResource;
use App\Events\InvitationEvent;

class InvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_my_invitations()
    {
        $connected_user_id= auth()->user()->id;
        $invitations = Invitation::where('from','=',$connected_user_id)->get();
        return InvitationsResource::collection($invitations);
    }

    public function index_new_invitations()
    {
        $connected_user_id= auth()->user()->id;
        $invitations = Invitation::where('to','=',$connected_user_id)
                                ->where('validated','=',false)
                                ->get();
        return InvitationsResource::collection($invitations);
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
        $connected_user_id= auth()->user()->id;
     
        $invitation = Invitation::create([
            'from' => $connected_user_id,
            'to' => $request->to,
            'validated' => false,
        ]);

        event(new InvitationEvent($invitation,$request->to,'You have a new Invitation'));

        return response()->json($invitation, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update_accept_inv(Request $request, $invitation)
    {
        $invitation = Invitation::find($invitation);
        $invitation-> update([  
            'validated' => true,
        ]);
        $result = (new RelationsController)->store($request);

        return new InvitationsResource($invitation);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Invitation::find($id);
        $task->delete();
        return response(null, 204);
    }
}

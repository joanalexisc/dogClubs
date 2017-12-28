<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\UserService;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = Input::all();
        return response()->json($this->userService->getUsers($filters));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(UserRequest $request)
    {
        $user = $this->userService->create($request);
        return response()->json($user,201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->userService->findWithDogs($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $this->userService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $this->userService->disableUser($i);
    }

    public function approve($id){
        $this->userService->approveUser($id);
    }

    public function expel($id){
        $this->userService->expelUser($id);
    }
}

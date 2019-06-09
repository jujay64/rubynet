<?php

namespace App\Http\Controllers\UserTree;

use App\UserTree;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserTreeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userTrees = UserTree::all();

        return $this->showAll($userTrees);
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
     * @param  \App\UserTree  $userTree
     * @return \Illuminate\Http\Response
     */
    public function show(UserTree $userTree)
    {
        return $this->showOne($userTree);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserTree  $userTree
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserTree $userTree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserTree  $userTree
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserTree $userTree)
    {
        //
    }
}

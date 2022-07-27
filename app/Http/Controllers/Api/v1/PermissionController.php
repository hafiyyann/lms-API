<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permissions = Permission::all();

      return response()->json([
        'success' => true,
        'permissions' => $permissions
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $permission = Permission::updateOrCreate([
        'id' => $request->id
      ],[
        'name' => $request->name
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Permission saved successfully!',
        'permission' => $permission
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $permission = Permission::with('roles')->where('id', $id)->first();

      return response()->json([
        'success' => true,
        'permission' => $permission
      ]);
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
      $permission = Permission::find($id);
      $permission->delete();

      return response()->json([
        'success' => true,
        'message' => 'Permission removed!'
      ]);
    }
}

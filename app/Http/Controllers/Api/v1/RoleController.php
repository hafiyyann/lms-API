<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return response()->json([
          'success' => true,
          'roles' => $roles
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
      $role = Role::updateOrCreate([
        'id' => $request->id
      ],[
        'name' => $request->name
      ]);

      if ($request->has('permission')) {
        $role->syncPermissions($request->permission);
      }

      return response()->json([
        'success' => true,
        'message' => 'Role saved successfully!',
        'role' => $role
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
        $role = Role::with('permissions')->where('id', $id)->first();

        return response()->json([
          'success' => true,
          'role' => $role
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
      $role = Role::find($id);
      $role->syncPermissions();
      $role->delete();

      return response()->json([
        'success' => true,
        'message' => 'Role removed!'
      ]);
    }

    public function assign_role_to_user(Request $request){
      try {
        $user = User::find($request->id);
        $user->assignRole($request->roles);

        return response([
          'id'    => $user->id,
          'name'  => $user->name,
          'role'  => $user->getRoleNames()
        ], 200);
      } catch (\Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage()
        ], 500);
      }
    }
}

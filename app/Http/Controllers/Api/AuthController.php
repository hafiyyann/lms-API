<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
  /**
  * Create a new AuthController instance.
  *
  * @return void
  */
  public function __construct() {
    $this->middleware('CheckToken', ['except' => ['login', 'register']]);
  }
  /**
  * Get a JWT via given credentials.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function login(Request $request){
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    if (! $token = auth()->attempt($validator->validated())) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->createNewToken($token);
  }
  /**
  * Register a User.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function register(Request $request) {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|between:2,100',
      'email' => 'required|string|email|max:100|unique:users',
      'password' => 'required|string|confirmed|min:6',
    ]);

    if($validator->fails()){
      return response()->json($validator->errors()->toJson(), 400);
    }

    $user = User::create(array_merge(
      $validator->validated(),
      ['password' => bcrypt($request->password)]
    ));

    return response()->json([
      'message' => 'User successfully registered',
      'user' => $user
    ], 201);
  }

  /**
  * Log the user out (Invalidate the token).
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function logout() {
    auth()->logout();
    return response()->json(['message' => 'User successfully signed out']);
  }
  /**
  * Refresh a token.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function refresh_token() {
    return $this->createNewToken(auth()->refresh());
  }
  /**
  * Get the authenticated User.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function show_logged_user_data() {
    try {
      $user = auth()->user();

      $logged_user_data = [
        'id'            => $user->id,
        'name'          => $user->name,
        'email'         => $user->email,
        'registered_at' => $user->created_at,
        'role'          => $user->getRoleNames()
      ];

      return response()->json($logged_user_data, 200);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
    return response()->json($logged_user_data);
  }
  /**
  * Get the token array structure.
  *
  * @param  string $token
  *
  * @return \Illuminate\Http\JsonResponse
  */
  protected function createNewToken($token){
    try {
      $user = auth()->user();

      $logged_user_data = [
        'access_token'  => $token,
        'id'            => $user->id,
        'name'          => $user->name,
        'email'         => $user->email,
        'registered_at' => $user->created_at,
        'role'          => $user->getRoleNames()
      ];

      return response()->json($logged_user_data, 200);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }
}

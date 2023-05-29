<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\validation\validationException;
use App\Models\User;
use DB;

class AuthController extends Controller
{
   /* public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login','signup']]);
    }
    */

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
            ]);

            if (Auth::attempt($validatedData)) {
                return response()->json(Auth::user(), 200);
            }
        
            return response()->json(['error' => 'Unauthorized'], 401);
            
        //    $credentials = $request->only(['email', 'password']);
   
        //    if (Auth::attempt($credentials)) {
        //        return response()->json(Auth::user(), 200);
        //    }

        //    throw validationException::withMessages([
        //     'email' => ['The Provided Credentials Are Incorrect']
        //    ]);

        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'device_name' => 'required',
        // ]);
     
        // $user = User::where('email', $request->email)->first();
     
        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['The provided credentials are incorrect.'],
        //     ]);
        // }
     
        // return $user->createToken($request->device_name)->plainTextToken;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function signup(Request $request){
     
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        DB::table('users')->insert($data);

        return response()->json('user signed up successful');
    }

}

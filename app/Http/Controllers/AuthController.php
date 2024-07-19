<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Register a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        // return response()->json(['message' => 'Register']);

        Log::info($request->all());
        // return response()->json(['message' => 'Register']);
        // return response()->json($request->all());

        $validUser = User::where('email', $request->email)->first();
        if ($validUser) {
            return response()->json(['message' => 'Email already exists'], 400);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'patient'
        ]);

        if ($user->save()){
            return response()->json(
                [
                    'user' => $user,
                    'message' => 'User created successfully'
                ], 201);
        } else {
            return response()->json(
                [
                    'message' => 'Failed to create user'
                ], 400);
        }
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        // get logged in user
        $user = User::where('email', $credentials['email'])->first();

        if (!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
        ]);
    }
    
    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sucessfully Logged out'
        ]);
    }

    /**
     * Refresh token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers() {
        $users = User::all();

        return response()->json($users);

    }

    /**
     * Get all superadmins
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuperAdmins() {
        $users = User::where('role', 'super-admin')->paginate(10);

        return response()->json($users);
    }

    /**
     * Get all doctors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctors() {
        $users = User::where('role', 'doctor')->paginate(10);

        return response()->json($users);
    }

    /**
     * Get all patients
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatients() {
        $users = User::where('role', 'patient')->paginate(10);

        return response()->json(
            $users
        );
    }
}
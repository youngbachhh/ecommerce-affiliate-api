<?php

namespace App\Http\Controllers;

//use http\Env\Request;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('phone', $request->phone)->orwhere('email',$request->phone)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            if (!$token = Auth::login($user)) {
                return ApiResponse::error('Unauthorized', 401);
            }
            return $this->respondWithToken($token);
        }
        return response()->json(['status' => 'error'] );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->tokens()->delete();
        return ApiResponse::success('Successfully logged out', 201);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();
        $user->tokens()->delete();
        $userData = [
            'id' => $user->id,
            'fullname' => $user->name,
            'username' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'role' => 'admin',
            'referral_code' => $user->referral_code,
            'referrer_id' => $user->referrer_id,
            'address' => $user->address,
            'total_revenue' => $user->total_revenue,
            'wallet' => $user->wallet,
            'bonus_wallet' => $user->bonus_wallet,
            'phone' => $user->phone,
            'status' => $user->status,
        ];

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'userAbilityRules' => [
                [
                    'action' => 'manage',
                    'subject' => 'all'
                ]
            ],
            'userData' => $userData,
            'status' => 'success',
        ]);
    }
    public function getUser(Request $request) {
        try {
            $user = Auth::user();
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

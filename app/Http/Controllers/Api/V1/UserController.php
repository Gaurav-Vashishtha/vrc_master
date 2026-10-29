<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CheckIpMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * status response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'total_records' => $users->count(),
            'data' => $users
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect Email',
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect Password',
            ], 400);
        }

        $checkIp = CheckIpMaster::first();

        if ($checkIp) {

                $today = now()->format('l');    
                $todayStatus = $checkIp->days[$today] ?? 0;

                if ($todayStatus == 1) {
                    $currentIp = $request->ip();
                    if ($checkIp->ip_address !== $currentIp) {
                        return response()->json([
                            'status' => false,
                            'message' => 'IP address mismatch. Login not allowed.',
                            'current_ip' => $currentIp,
                        ], 403);
                    }
                }
            }

        $token = Auth::guard('api')->login($user);

        UserLog::create([
            'user_id'    => $user->id,
            'action'     => 'login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message'      => 'Login successful',
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
            'user'         => Auth::guard('api')->user(),
        ]);
     }

    public function me()
    {
        return $this->sendResponse(Auth::guard('api')->user(), '');
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        UserLog::create([
            'user_id'    => $user->id,
            'action'     => 'logout',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Auth::guard('api')->logout();

        return $this->sendResponse([], 'Successfully logged out');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|max:10|confirmed',
        ]);

        $user = Auth::guard('api')->user();

        if (!$user) {
            return $this->sendError('User not authenticated', [], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->sendError('Current password is incorrect', [], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return $this->sendResponse([], 'Password changed successfully');
    }

    public function Unauthenticated()
    {

        $user = Auth::guard('api')->user();

        if (!$user) {

            return response()->json([
                'status' => false,
                'message' => 'User not authorised.'

            ], 401);
        }
    }


    
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error.', ['error' => $validator->errors()]);
        }

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->sendError('The email you entered is not registered with us.', [
                'error' => 'The email you entered is not registered with us.'
            ]);
        }

        // Generate reset token
        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => bcrypt($token),
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        $resetLink = route('password.reset', ['token' => $token]) . '?email=' . urlencode($user->email);
        $resetLink = str_replace('http://', 'https://', $resetLink);

        // Try to send the reset link to the user's email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->sendResponse([], 'Password reset link has been sent to your email address..');
        } else {
            return $this->sendError('Unable to send reset link.', ['error' => __($status)]);
        }
    }
}

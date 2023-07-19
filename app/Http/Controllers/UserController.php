<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller {
    public function LoginPage() {
        return view( 'pages.auth.login-page' );
    }

    public function RegistrationPage() {
        return view( 'pages.auth.registration-page' );
    }

    public function SendOtpPage() {
        return view( 'pages.auth.send-otp-page' );
    }

    public function VerifyOTPPage() {
        return view( 'pages.auth.verify-otp-page' );
    }

    public function ResetPasswordPage() {
        return view( 'pages.auth.reset-password-page' );
    }


    public function UserRegistration( Request $request ) {
        try {
            $request->validate( [
                'firstName' => [ 'required', 'string', 'max:50' ],
                'lastName'  => [ 'required', 'string', 'max:50' ],
                'email'     => [ 'required', 'string', 'email:rfc,dns', 'max:50', 'unique:'.User::class ],
                'mobile'     => [ 'required', 'string', 'max:13'],
                'password'  => [ 'required', 'confirmed', Password::defaults() ],
            ] );

            $user = User::create( [
                'firstName' => $request->firstName,
                'lastName'  => $request->lastName,
                'mobile'     => $request->mobile,
                'email'     => $request->email,
                'password'  => Hash::make( $request->password ),
            ] );

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ],200);
        }catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'User Registration Failed. Something went wrong. Please try again later.'
            ],400);
        }
    }

    /**
     * User Login
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function UserLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // User is found and password is correct. Issue JWT Token.
            $token = JWTToken::CreateToken($request->email, $user->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Login Successful',
            ], 200)->cookie('token', $token, 60*24);
        } else {
            // User not found or password is incorrect.
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized. Email or password is incorrect.'
            ], 401);
        }
    }
}

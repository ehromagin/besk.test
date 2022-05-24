<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApiController extends BaseController
{
    public function register(Request $request)
    {
        $user = new User();
        $user->email = $request->post('email');
        $user->password = Hash::make($request->post('password'));
        $user->confirmation_code = strtr(base64_encode(random_bytes(32)), '+/', '-_');
        $user->save();
        Mail::to($user->email)->send(new EmailConfirmation($user));
        return $user;
    }
}

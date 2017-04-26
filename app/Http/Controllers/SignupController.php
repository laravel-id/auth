<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\User;
use Auth;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Mail;

class SignupController extends Controller
{
    public function form()
    {
        return view('signup.form');
    }

    public function store(Request $request)
    {
        // validate request data
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        DB::transaction(function () use ($request) {
            // save into table
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // send email verification
            Mail::to($user->email)->send(new VerifyEmail($user));
        });

        // redirect to home
        return redirect()->back();
    }

    public function verify()
    {
        if (empty(request('token'))) {
            // if token is not provided
            return redirect()->route('signup.form');
        }

        // descrypt token as email
        $decryptedEmail = Crypt::decrypt(request('token'));

        // find user by email
        $user = User::whereEmail($decryptedEmail)->first();

        if ($user->status == 'activated') {
            // user is already active, do something
        }

        // otherwise change user status to "activated"
        $user->status = 'activated';
        $user->save();

        // autologin
        Auth::loginUsingId($user->id);

        return redirect('/home');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccountsController extends Controller
{
    public function showAdd()
    {
        return view('settings.accounts.add_account');
    }

    public function showEdit()
    {
        $users = User::select('id', 'username')->get();
        return view('settings.accounts.edit_account')
            ->with(compact('users'));
    }

    public function showDelete()
    {
        $users = User::select('id', 'username')->get();
        return view('settings.accounts.delete_account')
            ->with(compact('users'));
    }

    public function store(Request $request)
    {
        //add check hashed rule
        Validator::extend('checkHashedPass', function ($attribute, $value, $parameters) {
            if (!Hash::check($value, $parameters[0])) {
                return false;
            }
            return true;
        });

        $validator = Validator::make(
            $request->all(),
            array(
                'admin_password' => ['required', 'string', 'checkHashedPass:' . Auth::user()->password],
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'role' => ['required', 'string', 'max:255', Rule::in(['admin', 'seller'])],
                'password' => ['required', 'string', 'min:5'],
                'password_confirmation' => ['required', 'min:5', 'same:password'],
            )
        );
        if ($validator->fails()) {
            $messages = $validator->messages();
            return $this->showAdd()->with('messages', $messages);

        } else {
            User::Create([
                'username' => $request->username,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);
            return redirect(Route('home'));
        }
    }

    public function update(Request $request)
    {
        //add check hashed rule
        Validator::extend('checkHashedPass', function ($attribute, $value, $parameters) {
            if (!Hash::check($value, $parameters[0])) {
                return false;
            }
            return true;
        });

        $validator = Validator::make(
            $request->all(),
            array(
                'admin_password' => ['required', 'string', 'checkHashedPass:' . Auth::user()->password],
                'old_username' => ['required', 'string', 'exists:users,username'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $request->old_username],
                'role' => ['required', 'string', 'max:255', Rule::in(['admin', 'seller'])],
                'password' => ['required', 'string', 'min:5'],
                'password_confirmation' => ['required', 'min:5', 'same:password'],
            )
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            return $this->showEdit()->with('messages', $messages);

        } else {
            User::where('username',$request->old_username)->Update([
                'username' => $request->username,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);
            return redirect(Route('home'));
        }
    }

    public function destroy(Request $request)
    {
        //add check hashed rule
        Validator::extend('checkHashedPass', function ($attribute, $value, $parameters) {
            if (!Hash::check($value, $parameters[0])) {
                return false;
            }
            return true;
        });

        $validator = Validator::make(
            $request->all(),
            array(
                'admin_password' => ['required', 'string', 'checkHashedPass:' . Auth::user()->password],
                'username' => ['required', 'string', 'max:255'],
            )
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            return $this->showDelete()->with('messages', $messages);

        } else {
            User::find($request->username)->delete();
            return redirect(Route('home'));
        }
    }

    /******* TRASHED USERS *******/
    public function showTrashed(){
        $trashedUsers = User::onlyTrashed()->get();
        return view('trash.users')
            ->with(compact('trashedUsers'));
    }

    public function restoreTrashed($id){
        $trashedUser = User::onlyTrashed()->find($id);
        $trashedUser->restore();
        return redirect()->back();
    }

    public function dropTrashed($id){
        $trashedUser = User::onlyTrashed()->find($id);
        $trashedUser->forceDelete();
        return redirect()->back();
    }
}

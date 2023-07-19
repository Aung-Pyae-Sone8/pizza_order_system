<?php

namespace App\Http\Controllers;

use Storage;    // required for image
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    // change password
    public function changePassword(Request $request){
        /*
            1. all field must be fill (required)
            2. new password & confirm password length must be greather than 6
            3. new password & confirm password must be same
            4. client old password must be same with db password
            5. password change
        */
        $this->passwordValidationCheck($request);

        $currentUserId = Auth::user()->id;
        $user = User::select('password')->where('id',$currentUserId)->first();
        $dbHashValue = $user->password;

        // $clientPassword = Hash::make('aung');
        // Hash::check('aung',$clientPassword)

        if(Hash::check($request->oldPassword, $dbHashValue)){
            User::where('id',$currentUserId)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            return back()->with(['changeSuccess'=>'Password Change Success...']);
        }
        return back()->with(['notMatch' => 'The old password not match. Try again!']);
    }

    // direct admin details page
    public function details(){
        return view('admin.account.details');
    }

    // direct admin profile page
    public function edit(){
        return view('admin.account.edit');
    }

    // update account
    public function update($id,Request $request){
        // dd($id,$request->all());
        $this->accountValidationCheck($request);
        $data = $this->getUserDAta($request);

        // for image
        if($request->hasFile('image')){
            // 1. old image name | check => if image has => delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;
            // dd($dbImage);
            if($dbImage != null){
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            // dd($fileName);
            $request->file('image')->storeAs('public',$fileName);   // storage image in storage folder under public folder
            $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin Account Updated...']);
    }

    // admin list
    public function list(){
        $admin = User::when(request('key'),function($query){
                    $query->orWhere('name','like','%'.request('key').'%')
                        ->orWhere('email','like','%'.request('key').'%')
                        ->orWhere('gender','like','%'.request('key').'%')
                        ->orWhere('phone','like','%'.request('key').'%')
                        ->orWhere('address','like','%'.request('key').'%');
                })
                ->where('role','admin')
                ->paginate(4);
        $admin->appends(request()->all());
        return view('admin.account.list',compact('admin'));
    }

    // delete account
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'Admin account deleted!']);
    }

    // change role
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('account'));
    }

    // change
    public function change($id,Request $request){
        $data = $this->requestUserData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    // request user data
    private function requestUserData($request){
        return [
            'role' => $request->role
        ];
    }

    // account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',    //chck file image only
            'address' => 'required',
        ])->validate();
    }

    // request user data
    private function getUserData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(), // carbon => current time
        ];
    }

    // password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:18',
            'newPassword' => 'required|min:6|max:18',
            'confirmPassword' => 'required|min:6|same:newPassword|max:18',
        ])->validate();
    }
}

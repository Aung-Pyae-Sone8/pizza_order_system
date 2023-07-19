<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // user home page
    public function home()
    {
        $pizza = Product::orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));
    }

    // filter pizza
    public function filter($categoryId)
    {
        $pizza = Product::where('category_id', $categoryId)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));
    }

    // direct pizza details page
    public function pizzaDetails($pizzaId)
    {
        $pizza = Product::where('id', $pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details', compact('pizza', 'pizzaList'));
    }

    // change password page
    public function changePasswordPage()
    {
        return view('user.password.change');
    }

    // change password
    public function changePassword(Request $request)
    {
        $this->passwordValidationCheck($request);

        $currentUserId = Auth::user()->id;
        $user = User::select('password')->where('id', $currentUserId)->first();
        $dbHashValue = $user->password;

        if (Hash::check($request->oldPassword, $dbHashValue)) {
            User::where('id', $currentUserId)->update([
                'password' => Hash::make($request->newPassword),
            ]);
            // Auth::logout()     (direct logout)
            return back()->with(['changeSuccess' => 'Password Change Success...']);
        }
        return back()->with(['notMatch' => 'The old password not match. Try again!']);
    }

    // user account change page
    public function accountChangePage()
    {
        return view('user.profile.account');
    }

    // user account change
    public function accountChange($id, Request $request)
    {
        $this->accountValidationCheck($request);
        $data = $this->getUserDAta($request);

        // for image
        if ($request->hasFile('image')) {
            // 1. old image name | check => if image has => delete | store
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;
            // dd($dbImage);
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            // dd($fileName);
            $request->file('image')->storeAs('public', $fileName); // storage image in storage folder under public folder
            $data['image'] = $fileName;
        }

        User::where('id', $id)->update($data);
        return back()->with(['updateSuccess' => 'Account Updated...']);
    }

    // cart list
    public function cartList()
    {
        $cartList = Cart::select('carts.*', 'products.name as pizza_name', 'products.price as pizza_price', 'products.image as pizza_image')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        $totalPrice = 0;
        foreach ($cartList as $c) {
            $totalPrice += $c->pizza_price * $c->qty;
        }
        return view('user.main.cart', compact('cartList', 'totalPrice'));
    }

    // direct history page
    public function history()
    {
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate('5');
        return view('user.main.history', compact('order'));
    }

    // direct user list page
    public function userList()
    {
        $users = User::where('role','user')->paginate(3);
        return view('admin.user.list',compact('users'));
    }

    // change user role
    public function userChangeRole(Request $request){
        // logger($request->all());
        $updateSource = [
            'role' => $request->role
        ];
        User::where('id',$request->userId)->update($updateSource);
    }

    // direct admin contact page
    public function contactList()
    {
        $data = Contact::orderBy('id','desc')->paginate(5);
        $data->appends(request()->all());
        return view('admin.contact.contact',compact('data'));
    }

    // password validation check
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6|max:18',
            'newPassword' => 'required|min:6|max:18',
            'confirmPassword' => 'required|min:6|same:newPassword|max:18',
        ])->validate();
    }

    // account validation check
    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file', //chck file image only
            'address' => 'required',
        ])->validate();
    }

    // request user data
    private function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(), // carbon => current time
        ];
    }
}

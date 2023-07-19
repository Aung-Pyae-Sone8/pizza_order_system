<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // direct contact page
    public function contactPage(){
        return view('user.contact.contact');
    }

    // contact
    public function contact(Request $request){
        // dd($request->all());
        $data = $this->getData($request);
        Contact::create($data);
        return redirect()->route('user#contactPage');
    }

    // get data
    private function getData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'message' => $request->message
        ];
    }
}

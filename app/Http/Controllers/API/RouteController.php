<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    // get all product list
    public function productList(){
        $products = Product::get();
        $users = User::get();
        $data = [
            'products' => $products,
            'users' => $users
        ];
        return response()->json($data, 200);
    }

    // get all category list
    public function categoryList(){
        $categories = Category::get();
        return response()->json($categories, 200);
    }

    // create category
    public function categoryCreate(Request $request)
    {
        // dd($request->header());
        // dd($request->header('headerData'));
        // dd($request->all());
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now() ,
        ];
        $response = Category::create($data);
        return response()->json($response, 200);
    }

    // get contact list
    public function contactList(){
        $contacts = Contact::get();
        return response()->json($contacts, 200);
    }

    // delete category
    public function deleteCategory(Request $request)
    {
        $data = Category::where('id',$request->category_id)->first();
        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status'=>true,'message'=>'delete success'], 200);
        }
        return response()->json(['status'=>false,'message'=>'There is no category...'], 500);
    }

    // category details
    public function categoryDetails(Request $request)
    {
        $data = Category::where('id',$request->category_id)->first();
        if(isset($data)){
            // Category::where('id',$request->category_id)->delete();
            return response()->json(['status'=>true,'category'=>$data], 200);
        }
        return response()->json(['status'=>false,'category'=>'There is no category...'], 500);
    }

    // update category
    public function updateCategory(Request $request)
    {
        $categoryId = $request->category_id;
        $dbSource = Category::where('id',$categoryId)->first();
        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            Category::where('id',$categoryId)->update($data);
            $response = Category::where('id',$categoryId)->first();
            return response()->json(['status'=>true,'category'=>$response], 200);
        }
        return response()->json(['status'=>false,'category'=>'There is no category...'], 500);
    }

    // get category data
    private function getCategoryData($request)
    {
        return [
            'name' => $request->category_name ,
            'updated_at' => Carbon::now()
        ];
    }
}

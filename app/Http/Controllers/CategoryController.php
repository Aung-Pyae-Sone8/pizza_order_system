<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category list page
    function list() {
        $categories = Category::when(request('key'),function($query){
                                    $query->where('name','like','%'. request('key') .'%');
                                })
                                ->orderBy('id','desc')->paginate(5);
        $categories->appends(request()->all()); // for carry search key to another page (pagination)
        return view('admin.category.list',compact('categories'));
    }

    // direct category create page
    public function createPage()
    {
        return view('admin.category.create');
    }

    // crate category
    public function create(Request $request)
    {
        // dd($request->all());
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list');
    }

    // delete category
    public function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Category Deleted...']);
    }

    // edit page
    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }

    // update page
    public function update(Request $request){
        $this->categoryVAlidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where('id',$request->categoryId)->update($data);
        return redirect()->route('category#list');
    }

    // category validation check
    private function categoryValidationCheck($request)
    {
        Validator::make($request->all(), [
            'categoryName' => 'required|min:2|unique:categories,name,'.$request->categoryId  //category table,name field
        ])->validate();
    }

    // request category data
    private function requestCategoryData($request)
    {
        return [
            'name' => $request->categoryName,
        ];
    }
}

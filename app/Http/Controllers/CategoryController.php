<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('checkroll');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('categories','name')
            ],
            'description'=>['required'],

        ]);

        if ($validator->fails()) {
            return redirect('categories/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $category = new Category([
            'name' => $request->get('name'),
            "description" => $request->get('description')
            ]);

        $category->save();

        return redirect('categories')->with('success', 'Category saved successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category',$category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('categories','name')->ignore($category->id)
            ],
            'description'=>['required'],

        ]);

        if ($validator->fails()) {
            return redirect('categories/'. $category->id .'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $category->name = $request->get('name');
        $category->description = $request->get('description');

        $category->save();

        return redirect('categories')->with('success', 'Category edited successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/categories')->with('success', 'Category deleted!');
    }

    public static function getallCategories()
    {
               $categories = Category::all();
               //return view('user', ['categories' => Category::all()]);
               return $categories;
    }
}

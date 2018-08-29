<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;

class CategorysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('category.view')->with('category',$user->categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cat_name' =>'required'
        ]);
        
        //create category
        $cat = new Category();
        $cat->cat_name= $request->input('cat_name');
        $user_id = auth()->user()->id;
        $cat->user_id = $user_id;
        $cat->save();

        $catsaved = Category::orderBy('created_at','desc')->first();

        return redirect('/levels/'.$catsaved->cat_id)->with('success', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Category::find($id);
        return view('category.edit')->with('cat',$cat);
    }

    public function ajax(Request $req){
        echo "i am in the controller";
        $cat = Category::find($req->id);
        $cat->cat_name = $req->name;
        $cat->save();
        return response()->json($cat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo "i am in the controller";
        // $this->validate($request, [
        //     'cat_name' =>'required'
        // ]);
        
        //FInd category
        $cat = Category::find($id);
        $cat->cat_name= $request->name;
        $cat->save();

        return redirect('/categories')->with('success', 'Category Name Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Category::find($id);
        $cat->delete();
        return redirect('/categories')->with('success', 'Category Deleted');
    }
}

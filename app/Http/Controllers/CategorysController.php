<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use DB;

class CategorysController extends Controller
{
    /**
     * Display all the games (category) belonging to the user.
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
     * Create a new game and send back the information in json format 
     * to be displayed on the page without reload
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function ajaxcreate(Request $req){
        $cat = new Category();
        $cat->cat_name= $req->name;
        $user_id = auth()->user()->id;
        $cat->user_id = $user_id;
        $cat->save();
        
        return response()->json($cat);
    }

    /**
     * Editing the Game name: this is to save the new name 
     * and return the instance without page reload
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $req){
        $cat = Category::find($req->id);
        $cat->cat_name = $req->name;
        $cat->save();
        
        return response()->json($cat);
    }

    /**
     * Deleting the Game name: this is to delete the selected game
     * and return a response to indicate success
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function ajaxdelete(Request $req){
        
        $cat = Category::find($req->id);
        $cat->delete();
        
        return response()->json($cat);
    }

    /**
     * Before publishing a game it is checked if there are levels 
     * and if there are levels it will check if there is questions in the level
     * otherwise it will return a error stating what is missing 
     *
     * @param  Category $cid
     * @return \Illuminate\Http\Response
     */
    public function checkpublish($cid){
        $cat = Category::find($cid);
        // var_dump($cat->cat_name);
        $message = $cat->cat_name.' has been ';
        $type = "success";
        $emptyLevels = "";
        if($cat->published == 0){               // Check if published
            $adequate = true;
            $levels = DB:: select('select * from levels where cat_id =? order by lev_num asc',[$cid]);
            if(count($levels) > 0){             // Check if the game has levels       
                foreach($levels as $level){
                    if(DB::table('questions')->where('lev_id',$level->lev_id)->where('ques_hide','0')->doesntExist()){
                        $adequate = false;
                        $emptyLevels .= $level->lev_num .", ";
                    }
                }
                if($adequate){
                    $cat->published = 1;
                    $cat->save();
                    $message .= 'published.';
                }else{                          // Check if the levels have questions in them
                    $type = "error";
                    $message = "Please Add Questions to Level(s) ".$emptyLevels;
                }
            }else{
                $type = "error";
                $message = "Please Add Levels before Publishing";
            }
            
        }else{
            $cat->completed = 1;
            $cat->save();
            $message .= 'ended.';
            event(new \App\Events\gameOver($cid));
        }
        return redirect('categories')->with($type, $message);
    }


    /**
     * The game is OPEN by default this function allows the user
     * to set the course to which the game will belong
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function setCourse(Request $request){
        $category = Category::find($request->id);
        $category->c_id = $request->course;
        $category->save();

        return response()->json($category);
    }
}

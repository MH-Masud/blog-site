<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;
use Redirect;

class BackendController extends Controller
{
    public function category(){

    	return view('backend.pages.category');
    }

    public function save_category(Request $request){

    	if ($request->acction_btn == "insert") {
    		
    		$data=array();
    		$data['categoryName']=$request->categoryName;
    		$data['categoryDescription']=$request->categoryDescription;
    		$data['publicationStatus']=$request->publicationStatus;

    		DB::table('categories')->insert($data);
    		return response()->json(['success'=>'Category Save Successfull']);
    	}elseif ($request->acction_btn == "update") {

            $data=array();
    		$data['categoryName']=$request->categoryName;
    		$data['categoryDescription']=$request->categoryDescription;
    		$data['publicationStatus']=$request->publicationStatus;
    		DB::table('categories')
    		      ->where('id',$request->categoryID)
    		      ->update($data);

    		return response()->json(['success'=>'Category Update Successfull']);
    	}
    }

    public function showcategory(){

    	$allCategories = DB::table('categories')->get();
    	return Datatables::of($allCategories)
    	->addColumn('action',function($allCategories){
    		return '<a href="#" class="btn btn-info btn-sm edit" id="'.$allCategories->id.'">Edit</a>'.' '.
    		'<a href="#" class="btn btn-danger btn-sm delete" id="'.$allCategories->id.'">Delete</a>';
    	})->make(true);
    }

    public function editcategory(Request $request){
        $id = $request->id;
    	$categoryById = DB::table('categories')
    	                  ->where('id',$id)
    	                  ->first();
    	echo json_encode($categoryById);
    }

    public function deletecategory(Request $request){

    	$id = $request->id;
    	DB::table('categories')
    	   ->where('id',$id)
    	   ->delete();
    	return response()->json(['success'=>'Category Delete Successfull']);
    }

    public function add_blog(){

        $published_categories = DB::table('categories')
                                   ->where('publicationStatus',1)
                                   ->get();
                                   
        return view('backend.pages.blog',compact('published_categories'));
    }

    public function save_blog(Request $request){
        

        $data=array();
        $data['categoryId'] = $request->categoryId;
        $data['blogTitle'] = $request->blogTitle;
        $data['authorName'] = $request->authorName;
        $data['shortDescription'] = $request->shortDescription;
        $data['longDescription'] = $request->longDescription;
        $data['publicationStatus'] = $request->publicationStatus;
        $image =  $request->file('blogImage');

        if ($image) {
            
            $image_name = str_random(20);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name.'.'.$ext;
            $image_path = 'public/blog_image/';
            $image_store = $image->move($image_path,$image_full_name);
            $image_url = $image_path.$image_full_name;
            if ($image_store) {

                $data['blogImage'] = $image_url;
                DB::table('blogs')->insert($data);
                return response()->json(['success'=>'Blog Insert Successfull']);
            }
        }else{

            DB::table('blogs')->insert($data);
            return response()->json(['success'=>'Blog Insert Successfull']);
        }
        
    }

    public function show_blog(){

        $blogs = DB::table('blogs')->get();
        return Datatables::of($blogs)->make(true);
    }

    public function comments(){

        $comments = DB::table('comments')
                       ->join('blogs','comments.blog_id','=','blogs.id')
                       ->join('register','comments.user_id','=','register.id')
                       ->select('comments.*','register.*','blogs.*')
                       ->orderBy('comments.comments_id','desc')   
                       ->paginate(5);
        // echo "<pre>";
        // print_r($comments);
        // exit();           
        return view('backend.pages.comments',compact('comments'));
    }

    public function comments_published($id){

        $data=array();
        $data['commentsPublicationStatus']=0;
        DB::table('comments')
              ->where('comments_id',$id)
              ->update($data);
        return Redirect::to('/comments');
    }

    public function comments_unpublished($id){

        $data=array();
        $data['commentsPublicationStatus']=1;
        DB::table('comments')
              ->where('comments_id',$id)
              ->update($data);
        return Redirect::to('/comments');
    }

    public function comments_delete($id){

        DB::table('comments')
           ->where('comments_id',$id)
           ->delete();   
        return Redirect::to('/comments');
    }
}

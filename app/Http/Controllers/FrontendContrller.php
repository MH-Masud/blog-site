<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;

class FrontendContrller extends Controller
{
    public function index(){

        $categories = DB::table('categories')
                         ->where('publicationStatus',1)
                         ->get();

        $all_published_blogs = DB::table('blogs')
                            ->where('publicationStatus',1)
                            ->orderBy('id','desc')
                            ->paginate(3);

        $popular_blogs = DB::table('blogs')
                         ->where('publicationStatus',1)
                         ->orderBy('hitCount','desc')
                         ->take(5)
                         ->get();

        $most_comments_blogs = DB::table('blogs')
                                  ->where('publicationStatus',1)
                                  ->orderBy('comment_count','desc')
                                  ->take(5)
                                  ->get();

        return view('frontend.pages.home',compact('categories','all_published_blogs','popular_blogs','most_comments_blogs'));
    }
    public function contact(){

        return view('frontend.pages.contact');
    }
    public function terms(){

        return view('frontend.pages.terms');
    }
    public function login(){

        return view('frontend.pages.login');
    }
    public function register(){

        return view('frontend.pages.register');
    }
    public function details($id){
        
        $categories = DB::table('categories')
                         ->where('publicationStatus',1)
                         ->get();

        $all_published_blogs_by_id = DB::table('blogs')
                                     ->where('id',$id)
                                     ->first();
       
        $data=array();
        $data['hitCount']=$all_published_blogs_by_id->hitCount +1;

                      DB::table('blogs')
                           ->where('id',$id)
                           ->update($data);

        $new_all_published_blogs_by_id = DB::table('blogs')
                                     ->where('id',$id)
                                     ->first();

        $popular_blogs = DB::table('blogs')
                         ->where('publicationStatus',1)
                         ->orderBy('hitCount','desc')
                         ->take(3)
                         ->get();

        $published_comments = DB::table('comments')
                             ->join('register','comments.user_id','=','register.id')
                             ->select('comments.*','register.name')
                             ->where('comments.commentsPublicationStatus',1)
                             ->where('comments.blog_id',$id)
                             ->orderBy('comments.comments_id','desc')
                             ->paginate(3);

        $most_comments_blogs = DB::table('blogs')
                                ->where('publicationStatus',1)
                                ->orderBy('comment_count','desc')
                                ->take(5)
                                ->get();

    	return view('frontend.pages.details',compact('new_all_published_blogs_by_id','categories','popular_blogs','published_comments','most_comments_blogs'));
    }

    public function category_blog($id){
        
        $categories = DB::table('categories')
                         ->where('publicationStatus',1)
                         ->get();

        $all_blog_by_category_id = DB::table('blogs')
                                   ->where('categoryId',$id)
                                   ->orderBy('id','desc')
                                   ->paginate(3);

        $popular_blogs = DB::table('blogs')
                         ->where('publicationStatus',1)
                         ->orderBy('hitCount','desc')
                         ->take(3)
                         ->get();


        $most_comments_blogs = DB::table('blogs')
                                ->where('publicationStatus',1)
                                ->orderBy('comment_count','desc')
                                ->take(5)
                                ->get();
        
        return view('frontend.pages.category',compact('all_blog_by_category_id','categories','popular_blogs','most_comments_blogs'));
    }

    public function  user_register(Request $request){

        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $data['password']=$request->password;

        $registerID = DB::table('register')->insertGetId($data);
        Session::put('registerID',$registerID);
        Session::put('user_name',$request->name);
        return Redirect::to('/');
    }

    public function user_logout(Request $request){

        Session::put('registerID','');
        return Redirect::to('/');
    }

    public function user_login(Request $request){

        $email = $request->email;
        $password=$request->password;

        $register = DB::table('register')
                      ->where('email',$email)
                      ->where('password',$password)
                      ->first();
        $registerID = $register->id;
        $user_name = $register->name;
        Session::put('registerID',$registerID);
        Session::put('user_name',$user_name);
        return Redirect::to('/');
        
    }

    public function save_comments(Request $request){

        $data=array();
        $data['user_id']=$request->user_id;
        $data['blog_id']=$request->blog_id;
        $data['comments']=$request->comments;
        DB::table('comments')->insert($data);

        $blogs = DB::table('blogs')
                  ->where('id',$request->blog_id)
                  ->first();
        
        $data=array();
        $data['comment_count'] = $blogs->comment_count + 1;
        
        DB::table('blogs')
               ->where('id',$request->blog_id)
               ->update($data);
        
        return Redirect::to('/details/'.$request->blog_id)->with('message','Your comment send for admin approval.');
    }

    public function search(Request $request){


        $search = $request->search;

        if ($search != null) {
            
           $datas = DB::table('blogs')
                     ->where('blogTitle','LIKE', '%'.$search. '%')
                     ->orWhere('authorName','LIKE', '%'.$search. '%')
                     ->orWhere('shortDescription','LIKE', '%'.$search. '%')
                     ->orWhere('longDescription','LIKE', '%'.$search. '%')
                     ->orderBy('id','desc')
                     ->paginate(5);

            $categories = DB::table('categories')
                         ->where('publicationStatus',1)
                         ->get();

            $popular_blogs = DB::table('blogs')
                         ->where('publicationStatus',1)
                         ->orderBy('hitCount','desc')
                         ->take(3)
                         ->get();


        $most_comments_blogs = DB::table('blogs')
                                ->where('publicationStatus',1)
                                ->orderBy('comment_count','desc')
                                ->take(5)
                                ->get();

            if (count($datas)>0) {
                
                return view('frontend.pages.search',compact('datas','categories','popular_blogs','most_comments_blogs'));
            }else{

                return view('frontend.pages.notfoundsearch');
            }
        }else{
            
            return view('frontend.pages.emptysearch');
        }
    }
}

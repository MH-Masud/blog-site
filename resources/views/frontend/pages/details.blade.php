@extends('frontend.layouts.master')
@section('content')
<div class="content">
	 <div class="container">
		 <div class="content-grids">
			 <div class="col-md-8 content-main">
				 <div class="content-grid">
					 <div class="content-grid-head">
					 	<h3>বিস্তারিত তথ্য</h3>
						 <h4>{{$new_all_published_blogs_by_id->created_at}},পোস্ট করেছেন: <a href="#">{{$new_all_published_blogs_by_id->authorName}}</a></h4>
						 <div class="clearfix"></div>
					 </div>
					 <div class="content-grid-single">
						 <h3>{{$new_all_published_blogs_by_id->blogTitle}}</h3>
						 <img class="single-pic" style="height: 300px; width: 650px;" src="{{asset($new_all_published_blogs_by_id->blogImage)}}" alt=""/>
						 <span>{{$new_all_published_blogs_by_id->shortDescription}}</span>
						 <p>{{$new_all_published_blogs_by_id->longDescription}}</p>
						 <?php
                         $registerID=Session::get('registerID');
                         if ($registerID != NULL) {
						 ?>
						 <div class="content-form">
							 <h3>Leave a comment</h3>
							 <form method="post" action="{{URL::to('/save-comments')}}">
							 {{csrf_field()}}
							 <textarea rows="5" name="comments" cols="30" placeholder="Write your comment.."></textarea>
							 <input type="hidden" name="user_id" value="{{Session::get('registerID')}}">
							 <input type="hidden" name="blog_id" value="{{$new_all_published_blogs_by_id->id}}">
							 <input type="submit" value="COMMENT"/>
							 </form>
						 </div>
						 <?php
                         }else{
						 ?>
						 <div class="content-form">
							 <h3><a class="btn btn-info btn-lg" href="{{URL::to('/login')}}">মন্তব্য লিখুন</a></h3>
						 </div>
						 <?php } ?>
						 <br>
						 <h3><span class="text-warning">{{Session::get('message')}}</span></h3>
						 <div class="comments">
							 <h3>সব মন্তব্য</h3>
							 @foreach($published_comments as $published_comment)
							 <div class="comment-grid">
								 
								 <div class="comment-info">
								 <h4>{{$published_comment->name}}</h4>
								 <p>{{$published_comment->comments}}</p>
								 <h5>{{$published_comment->created_at}}</h5>
								 
								 </div>
								 <div class="clearfix"></div>
							 </div>
							 @endforeach
							 <div >
								{{$published_comments->links()}}
							 </div>	
						</div>
					  </div>
					 
				 </div>			 			 
			 </div>
			 <div class="col-md-4 content-main-right">
				 <div class="search">
						 <h3>অনুসন্ধান করুন</h3>
						<form method="POST" action="{{URL::to('/search')}}">
							{{csrf_field()}}
							<input type="text" id="search" name="search" placeholder="এখানে লিখুন..">
							<input type="submit" value=""  id="submit">
						</form>
				 </div>
				 <div class="categories">
					 <h3>বিভাগ</h3>
					 @foreach($categories as $category)
					 <li class="active"><a href="{{URL::to('/category_blog/'.$category->id)}}">{{$category->categoryName}}</a></li>
					 @endforeach
				 </div>
				 <div class="archives">
					 <h3>জনপ্রিয় পোস্ট</h3>
					 @foreach($popular_blogs as $popular_blog)
					 <li class="active"><a href="{{URL::to('/details/'.$popular_blog->id)}}">{{$popular_blog->blogTitle}}</a></li>
					 @endforeach
				 </div>
				 <div class="archives">
					 <h3>সর্বাধিক মন্তব্য</h3>
					 @foreach($most_comments_blogs as $most_comments_blog)
					 <li class="active"><a href="{{URL::to('/details/'.$most_comments_blog->id)}}">{{$most_comments_blog->blogTitle}}</a></li>
					 @endforeach
				 </div>
			 </div>
			 <div class="clearfix"></div>
		 </div>
	 </div>
</div>
@endsection
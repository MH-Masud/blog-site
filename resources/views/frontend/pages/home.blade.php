@extends('frontend.layouts.master')
@section('content')
<div class="content">
	 <div class="container">
		 <div class="content-grids">
			 <div class="col-md-8 content-main">
				<div class="content-grid-head">
						 <h3>সর্বশেষ পোস্ট</h3>
						 <div class="clearfix"></div>
					 </div>
				 @foreach($all_published_blogs as $all_published_blog)
				 <div class="content-grid-sec">
					 <div class="content-sec-info">
							 <h3><a href="{{URL::to('/details/'.$all_published_blog->id)}}">{{$all_published_blog->blogTitle}}</a></h3>
							 <h4>{{$all_published_blog->created_at}}, পোস্ট করেছেন: <a href="#">{{$all_published_blog->authorName}}</a></h4>
							 <p>{{$all_published_blog->shortDescription}}</p>
							 <img  style="height: 250px;width: 500px;" src="{{asset($all_published_blog->blogImage)}}" alt=""/><br>
							 <a class="bttn" href="{{URL::to('/details/'.$all_published_blog->id)}}">আরও</a>
					 </div>
				 </div>
				 @endforeach
				 <div>
				 	{{$all_published_blogs->links()}}
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
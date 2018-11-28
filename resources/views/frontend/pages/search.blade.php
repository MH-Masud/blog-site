@extends('frontend.layouts.master')
@section('content')
<div class="content">
	 <div class="container">
		 <div class="content-grids">
			 <div class="col-md-8 content-main">
				<div class="content-grid-head">
						 <h3>অনুসন্ধান ফলাফল</h3>
						 <span class="text-center text-success">{{Session::get('message')}}</span>
						 <div class="clearfix"></div>
					 </div>
				 @foreach($datas as $data)
				 <div class="content-grid-sec">
					 <div class="content-sec-info">
							 <h3><a href="{{URL::to('/details/'.$data->id)}}">{{$data->blogTitle}}</a></h3>
							 <h4>{{$data->created_at}}, পোস্ট করেছেন: <a href="#">{{$data->authorName}}</a></h4>
							 <p>{{$data->shortDescription}}</p>
							 <img  style="height: 250px;width: 500px;" src="{{asset($data->blogImage)}}" alt=""/><br>
							 <a class="bttn" href="{{URL::to('/details/'.$data->id)}}">আরও</a>
					 </div>
				 </div>
				 @endforeach
				 <div>
				 	{{$datas->links()}}
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
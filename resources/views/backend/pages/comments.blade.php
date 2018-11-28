@extends('backend.layouts.master')
@section('content')
<br><br>
<div class="container">
	<div class="row">
		<div class="col-lg-11">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Blog Title</th>
						<th>User Name</th>
						<th>Comments</th>
						<th>Publication Status</th>
						<th>Action</th>
					</tr>
				</thead>
				@foreach($comments as $comment)
				<tbody>
					<tr>
						<td>{{$comment->blogTitle}}</td>
						<td>{{$comment->name}}</td>
						<td>{{$comment->comments}}</td>
						<td>{{$comment->commentsPublicationStatus == 1 ? 'Published':'Unpublished'}}</td>
						<td>
							<?php if ($comment->commentsPublicationStatus == 1) { ?>
							<a title="Unpublished" href="{{URL::to('/comments-published/'.$comment->comments_id)}}" class="btn btn-info btn-sm">
								<span class="fa fa-thumbs-up"></span>
							</a>
							<?php } else { ?>
							<a title="Published" href="{{URL::to('/comments-unpublished/'.$comment->comments_id)}}" class="btn btn-info btn-sm">
								<span class="fa fa-thumbs-down"></span>
							</a>
							<?php } ?>
							<a title="view" href="{{URL::to('/comments-view/'.$comment->comments_id)}}" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-eye-open"></span>
							</a>
							<a href="{{URL::to('/comments-delete/'.$comment->comments_id)}}" class="btn btn-info btn-sm" title="delete" onclick="return confirm('are you sure to delete this !');">
								<span class="glyphicon glyphicon-trash"></span>
							</a>
							
						</td>
					</tr>
				</tbody>
				@endforeach
			</table>
			<div>
				{{$comments->links()}}
			</div>
		</div>
	</div>
</div>
<br>
@endsection
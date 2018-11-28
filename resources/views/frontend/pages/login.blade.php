@extends('frontend.layouts.master')
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4">
			<h3 class="text-center">Login Here</h3><br>
			<form method="POST" action="{{URL::to('/login-user')}}">
				{{csrf_field()}}
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value="Login" class="btn btn-info btn-lg">
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
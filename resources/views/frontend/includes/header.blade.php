<!---strat-banner---->
<div class="banner">				
	 <div class="header">  
		  <div class="container">
			  <div class="logo">
					<a href="{{URL::to('/')}}"> <img src="{{asset('public/frontend/images/logo.png')}}" title="soup" /></a>
			 </div>
			 <!---start-top-nav---->
			 <div class="top-menu">
				  <span class="menu"> </span> 
				   <ul>
						
				 </ul>
			 </div>
			 <div class="clearfix"></div>
					<script>
					$("span.menu").click(function(){
					$(".top-menu ul").slideToggle("slow" , function(){
					});
					});
					</script>
				<!---//End-top-nav---->					
		 </div>
	 </div>
	 <div class="container">
		 <div class="banner-head">
			 <h1>anirban.com</h1>
		 </div>
		 <div class="banner-links">
			 <ul>
			 	<li class="active"><a href="{{URL::to('/')}}">HOME</a></li>						
			 	<li><a href="{{URL::to('/contact')}}">CONTACT</a></li>	
			 	<li><a href="{{URL::to('/terms')}}">TERMS</a></li>
			 	
			 	<?php
                 $registerID=Session::get('registerID');
                 if ($registerID == NULL) {  ?>
                 <li><a href="{{URL::to('/login')}}">Login</a></li>
			 	<li><a href="{{URL::to('/register')}}">Register</a></li>
			 	<?php } else { ?>
			 	<li><a href="{{URL::to('/user-logout')}}">Logout</a></li>
			 	<?php } Session::put('logout','') ?>			
			 	<div class="clearfix"> </div>
			 </ul>
		 </div>
	 </div>
</div>
<!---//End-banner---->
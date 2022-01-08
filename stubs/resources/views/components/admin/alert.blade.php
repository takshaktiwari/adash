@if ($errors->any() || session('success'))
	<style>
		.toast{
			position: fixed;
		    bottom: 20px;
		    right: 20px;
		    z-index: 9999999999;
		    min-width: 300px;
		    max-width: 400px;

		    animation-name: shake;
	      	animation-duration: 0.5s;
	      	animation-delay: 1s;
	      	animation-iteration-count: 2;
		}
		.toast-body { max-height: 80vh; overflow-y: scroll; }

		@keyframes shake {
		  0%   	{right: 10px;}
		  20% 	{right: 30px;}
		  40%   {right: 15px;}
		  60%   {right: 25px;}
		  80%   {right: 15px;}
		  100% 	{right: 20px;}
		}
	</style>
	<div class="toast" data-delay="{{ session('life') ? session('life') : 6000 }}">
	  	<div class="toast-header 
	  		{{ 	session('bg-color') 
	  				? session('bg-color') 
	  				: (
	  					session('success') 
		  					? 'bg-success' 
		  					: 'bg-danger'
	  			  	  ) }}">

	    	<strong class="mr-auto text-white font-size-16 p-1">
	    		{{ session('success')?'Notification':'Something Went Wrong' }}
	    	</strong>
	    	<button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
	  	</div>
	  	<div class="toast-body p-3 font-size-16">
	  		@if(is_array(session('success')))
	  			<ul class="mb-0">
	  			    @foreach (session('success') as $msg)
	  			        <li class="font-size-16">{{ $msg }}</li>
	  			    @endforeach
	  			</ul>
	  		@else
	  			{{ session('success') }}
	  		@endif
	  		
	    	<ul class="mb-0 pl-3">
	    	    @foreach ($errors->all() as $error)
	    	        <li class="font-size-16">{{ $error }}</li>
	    	    @endforeach
	    	</ul>
	  	</div>
	</div>
@endif

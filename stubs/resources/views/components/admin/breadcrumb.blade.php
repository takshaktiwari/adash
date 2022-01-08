<div class="row align-items-center">
    <div class="col-sm-6">
        <div class="page-title-box">
            <h4 class="font-size-18">{{ $title }}</h4>

            @if(count($links) > 0)
	            <ol class="breadcrumb mb-0">
		            @foreach($links as $link)
		            	@if(isset($link['url']) && $link['url'] != '')
			                <li class="breadcrumb-item">
			                	<a href="{{ $link['url'] }}">
			                		{{ $link['text'] }}
			                	</a>
			                </li>
		                @else
		                	<li class="breadcrumb-item active">{{ $link['text'] }}</li>
		                @endif
		            @endforeach
	            </ol>
            @endif
        </div>
    </div>

    @if(isset($actions) && count($actions) > 0)
	    <div class="col-sm-6">
	        <div class="float-right d-none d-md-block">
	        	@if(url()->previous())
		        	<a href="{{ url()->previous() }}" class="btn btn-loader" >
		        		<i class="fas fa-reply"></i> Back
		        	</a>
	        	@endif
	        	        	
	        	@foreach($actions as $action)
        			@if(isset($action['permission']))
        				@can($action['permission'])
			            	<a 	href="{{ isset($action['url']) ? $action['url'] : 'javascript:void(0)' }}" 
			            		class="btn {{ (isset($action['class']) && $action['class'] != '') ? $action['class'] : 'btn-dark' }}"
			            		@if(isset($action['data']))
			            			@foreach ($action['data'] as $key => $data)
			            				{{ 'data-'.$key.'='.$data }}
			            			@endforeach
			            		@endif
			            		>
			            		@if(!empty($action['icon']))
			            			<i class="{{ $action['icon'] }}"></i>
			            		@endif
			            		{{ $action['text'] }}
			            	</a>
		            	@endcan
		            @else
		            	<a 	href="{{ isset($action['url']) ? $action['url'] : 'javascript:void(0)' }}" 
		            		class="btn {{ (isset($action['class']) && $action['class'] != '') ? $action['class'] : 'btn-dark' }}"
		            		@if(isset($action['data']))
		            			@foreach ($action['data'] as $key => $data)
		            				{{ 'data-'.$key.'='.$data }}
		            			@endforeach
		            		@endif
		            		>
		            		@if(!empty($action['icon']))
		            			<i class="{{ $action['icon'] }}"></i>
		            		@endif
		            		{{ $action['text'] }}
		            	</a>
	            	@endif
	            @endforeach
	        </div>
	    </div>
    @endif
</div>
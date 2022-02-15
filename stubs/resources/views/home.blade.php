<x-app-layout>
	<x-breadcrumb 
		title="Home" 
		:links="[
			['text' => 'Welcome']
		]" />
	@include('welcome')
</x-app-layout>
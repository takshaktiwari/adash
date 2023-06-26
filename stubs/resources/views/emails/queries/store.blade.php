<x-mail::message>
# New Query Recieved

We have got a new query on {{ now()->format('d-M-Y h:i A') }}. Details are given below.

<x-mail::table>
|         |           |
| ------------- |:-------------:|
@if($query->name)
| Name      | {{ $query->name }} |
@endif
@if($query->email)
| Email      | {{ $query->email }} |
@endif
@if($query->mobile)
| Mobile      | {{ $query->mobile }} |
@endif
@if($query->subject)
| Subject      | {{ $query->subject }} |
@endif
@if($query->title)
| Title      | {{ $query->title }} |
@endif
@if($query->content)
| Content      | {{ $query->content }} |
@endif
| Created at      | {{ $query->created_at->format('d-M-Y h:i A') }} |
@if($query->others)
@foreach($query->others as $key => $value)
| {{ str()->of($key)->title() }}      | {{ $value }} |
@endforeach
@endif
</x-mail::table>

<x-mail::button :url="route('admin.queries.index')">
All Queries
</x-mail::button>

- - -

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

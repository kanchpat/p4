@extends('layouts._master')

@section('title')
Books
@stop

@section('body')

@if(sizeof($books) == 0)
No results
@else
@foreach($books as $book)
</section class='book'>

    {{{ $book['title'] }}}
       <a href='/book/edit/{{$book['id']}}'>Edit</a>
    </p>

</section>
@endforeach
@endif

@stop








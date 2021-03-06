@extends('layouts._master')

@section('title')
Welcome to Book Buddy Contact Page
@stop

@section('head')

<title>
    Welcome to Book Buddy Contact Page
</title>

@stop

<div class="container">
    <header class="row">
        <h1>Welcome to Book Swapper </h1>
    </header>
</div>

@section('parainfo')
<div class="container">
    <blockquote>
        Why did I create this website?
    </blockquote>
    <p>
        As a mother of two children who have immense pleasure in reading books and also an avid reader myself we end up spending money buying the books which is read one time.
        With this website I am hoping we could swap the books within the community so that friends can see your books and rent them as needed.
    </p>

    <blockquote>
        What works and what does not to make this site fully functional?
    </blockquote>
    <ol>
        <li>
            This book currently does not have a community concept , as long as you are registered with the website you could see the books available for rental. Future update would be to create a group admin representing a community and a book could only be swapped inside that community
        </li>
        <li>
            I am hoping to restrict this website only to add Children books to avoid polluting the website.
        </li>
        <li>
            Currently the messaging process for initiation of rental and return is done only when the concerned user is logged in to the system. Would like to change this to a emailing
        </li>
        <li>
            I would like to have a tag for books so that it could be filtered based on the genre
        </li>
        <li>
            I would like to validate the address against USPS Street Address validator.
        </li>
    </ol>

    <p>
        Further Questions ->
        Please contact the admin - ksanthanakrishnan@g.harvard.edu
    </p>
</div>
@stop
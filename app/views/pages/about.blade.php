@extends('layouts._master')

@section('title')
Welcome to Book Swapper
@stop
@section('parainfo')
<div class="container">
    <h4>
        Book Rental is an Online community to create your own library with a collection of books we have at home
    </h4>
    <blockquote>
        How it works?
    </blockquote>
    <strong>
        First time Login/Registration:
    </strong>
    <ol>
        <li>
            Create your login account
        </li>
        <li>
            An email would be sent to verify account
        </li>
        <li>
            Click the link in your email , enter your personal details
        </li>
    </ol>
    <strong>
        Returning users:
    </strong>
    <br>
    <ol>

        <mark>
            To add a book to your library
        </mark>
        <li>
            Click
            <a href="/book/create">
                Add a book
            </a>
            under My Library Management. Enter the title / author of the book
        </li>
        <li>
            Add the book you would like using the checkbox and pressing Add Book button
        </li>
    </ol>
    <ol>

        <mark>
            To rent a book from other's library
        </mark>
        <li>
            Click
            <a href="/book/rent">
                Browse Books available to Rent
            </a>
            under my Library Management.
        </li>
        <li>
            Rent the book you would like using the checkbox and pressing Rent now button
        </li>
        <li>
            This would initiate a message to Owner of the book when he logs in to his profile and him initiating the rental(by either handing the book to the renter or sending through postal address)
        </li>
    </ol>
    <ol>

        <mark>
            To browse the books you have rented and initiate return
        </mark>
        <li>
            Click
            <a href="/book/loan">
                Show Books I have rented
            </a>
            under My Library Management.
        </li>
        <li>
            Click the checkbox and have Initiate Return button clicked for the owner to be notified of your intention to return it (by either handing the book to the renter or sending through postal address)
        </li>
        <li>
            You could also view all your past rentals by clicking the Past Rental button on the screen
        </li>
    </ol>
    <ol>

        <mark>
            To view the messages you have received till now
        </mark>
        <li>
            Click
            <a href="/messages">
                Show my Messages
            </a>
            under My Library Management. Approve / Reject the request.
        </li>
    </ol>
    <ol>

        <mark>
            To Delete the books you own
        </mark>
        <li>
            Click
            <a href="/book/list">
                Show my Books
            </a>
            under My Library Management and check Delete. Press Save. You cannot delete the book while it is rented out.
        </li>
    </ol>
    <p>
        I have used Open Source.Org for some of the cover pictures.
    </p>
</div>
@stop

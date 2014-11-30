<?php

class BookController extends \BaseController {


    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();

        $this->beforeFilter('auth', array('except' => 'getIndex'));

    }


    /**
     * Process the searchform
     * @return View
     */
    public function getSearch() {


        $books = Book::search(Auth::user()->id);
        return View::make('pages.book_search')->with('books',$books);

    }


    /**
     * Display all books
     * @return View
     */
    public function getIndex() {

        # Format and Query are passed as Query Strings
        $format = Input::get('format', 'html');

        $query  = Input::get('query');

        $books = Book::search($query);

        # Decide on output method...
        # Default - HTML
        if($format == 'html') {
            return View::make('book_index')
                ->with('books', $books)
                ->with('query', $query);
        }
        # JSON
        elseif($format == 'json') {
            return Response::json($books);
        }
        # PDF (Coming soon)
        elseif($format == 'pdf') {
            return "This is the pdf (Coming soon).";
        }


    }


    /**
     * Show the "Add a book form"
     * @return View
     */
    public function getCreate() {

        return View::make('pages.book_add')->with('owners', Auth::user()->id);

    }


    /**
     * Process the "Add a book form"
     * @return Redirect
     */
    public function postCreate() {

        # Instantiate the book model
        $book = new Book();

        $book->fill(Input::all());

        # Magic: Eloquent
        $book->save();

        return Redirect::to ('/')->with('flash_message','Book added');
 //       return Redirect::action('BookController@getIndex')->with('flash_message','Your book has been added.');

    }


    /**
     * Show the "Edit a book form"
     * @return View
     */
    public function getEdit($id) {

        try {
            $book    = Book::findOrFail($id);
            $authors = Author::getIdNamePair();
        }
        catch(exception $e) {
            return Redirect::to('/book')->with('flash_message', 'Book not found');
        }

        return View::make('book_edit')
            ->with('book', $book)
            ->with('authors', $authors);

    }


    /**
     * Process the "Edit a book form"
     * @return Redirect
     */
    public function postEdit() {

        try {
            $book = Book::findOrFail(Input::get('id'));
        }
        catch(exception $e) {
            return Redirect::to('/book')->with('flash_message', 'Book not found');
        }

        # http://laravel.com/docs/4.2/eloquent#mass-assignment
        $book->fill(Input::all());
        $book->save();

        return Redirect::action('BookController@getIndex')->with('flash_message','Your changes have been saved.');

    }


    /**
     * Process book deletion
     *
     * @return Redirect
     */
    public function postDelete() {

        try {
            $book = Book::findOrFail(Input::get('id'));
        }
        catch(exception $e) {
            return Redirect::to('/book/')->with('flash_message', 'Could not delete book - not found.');
        }

        Book::destroy(Input::get('id'));

        return Redirect::to('/book/')->with('flash_message', 'Book deleted.');

    }


    /**
     * Process a book search
     * Called w/ Ajax
     */
    public function postSearch() {

        if(Request::ajax()) {

            $query  = Input::get('query');

            # We're demoing two possible return formats: JSON or HTML
            $format = Input::get('format');

            # Do the actual query
            $books  = Book::search($query);

            # If the request is for JSON, just send the books back as JSON
            if($format == 'json') {
                return Response::json($books);
            }
            # Otherwise, loop through the results building the HTML View we'll return
            elseif($format == 'html') {

                $results = '';
                foreach($books as $book) {
                    # Created a "stub" of a view called book_search_result.php; all it is is a stub of code to display a book
                    # For each book, we'll add a new stub to the results
                    $results .= View::make('book_search_result')->with('book', $book)->render();
                }

                # Return the HTML/View to JavaScript...
                return $results;
            }
        }
    }



}
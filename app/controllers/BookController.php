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


    /** List all the books you own
     */
    public function getSearch() {


        $books = Book::searchWithOwnerId(Auth::user()->id);
        return View::make('pages.book_search')->with('books',$books);

    }

    public function postSearch() {

        $value = Input::get('Delete');

        if(is_array($value))
        {
            if(Book::delete_book($value))
                return Redirect::to ('/book/list')->with('flash_message','Book Deleted');
            else
                return Redirect::to ('/book/list')->with('error_message','Book Delete , error');

        }
        $rent_value = Input::get('AvailableforRent');

        if(is_array($rent_value))
        {
            if(Book::change_rent($rent_value))
                return Redirect::to ('/book/list')->with('flash_message','Swap value updated');
            else
                return Redirect::to ('/book/list')->with('error_message','Book swap , error');
         }

    }

    public function getRent() {


        $books = Book::rent(Auth::user()->id);
        return View::make('pages.book_rent')->with('books',$books);

    }

    public function postRent() {


        $books = Book::rent(Auth::user()->id);
        return View::make('pages.book_rent')->with('books',$books);

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
        $value = Input::get('select');
        foreach($value as $bookInfo){
            $book = new Book();

            $values = Helper::multiexplode(array(":",","),$bookInfo,6);
            $book->title = $values[1];
            $book->author = $values[3];
            $book->isbn = $values[5];
            $book->cover = 'http://'.$values[8];
            $book->owner_id = Auth::user()->id;
            $book->ready_to_swap = 'n';

            $book->save();

            return Redirect::to ('/book/create')->with('flash_message','Book added');
        }
    }


    public function showGoogleBooks(){

        $books = Helper::showGoogleBooks();

        return View::make('pages.book_google_add')->with('books',$books);
    }

    public function getEdit($id) {
        try {
            $book    = Book::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/book/list')->with('flash_message', 'Book not found');
        }
             return View::make('pages.book_edit')
                 ->with('book', $book);
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

        return Redirect::action('BookController@getSearch')->with('flash_message','Your changes have been saved.');

    }

 }
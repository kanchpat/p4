<?php

class BookController extends \BaseController {
    /**
     *
     */
    public function __construct()   {

        # Make sure BaseController construct gets called
        parent::__construct();

        $this->beforeFilter('auth', array(
            'except' => 'getIndex'
        ));

    }


    /** List all the books you own Show Books you own
     */
    public function getSearch()     {
        // Searching the Books table by passing the current user id to the owner_id field

        $books = Book::searchWithOwnerId(Auth::user()->id);

        return View::make('pages.book_search')->with('books', $books);

    }

    /* User has an option to either delete/update the rental availability
     * to Delete - We find all the Renter records in the renter table
     *                  ->detach the book ids and the renter id's
     *                  ->destroy the renter table for the rows
     *                  ->delete the book (In turn does on delete cascade in the messages table
     * to update the indicator for availability of rental -
     *                  ->check if the current value in the table and the user supplied value or the same
     *                          ->do nothing
     *                  -> if different, and if yes -> update and save
     *                  -> if different, and if no ->
     *                          ->check if the return indicator in rental table is "N", it means that it is rented out
     *                          -> no change
     *                          -> if the return indicator in rental table is "Y" or " " or no row available,
     *                              update the indicator to "Y"
     */
    public function postSearch()   {

        $idNos      = Input::get('Delete');
        $rent_value = Input::get('AvailableforRent');
        $id         = Input::get('id');

        $i = 0;

        foreach ($rent_value as $value) {
            $returnMsg[] = Book::changeRentForBookID($id[$i], $value); #Get the rental availability ind updated
            $i++;
        }

        $book_deleted = false;

        if (!(is_null($idNos))) {
            $book_deleted = true;
            foreach ($idNos as $idValue) {
                if (!(Book::delete_book($idValue))) #delete books
                    return Redirect::to('/book/list')->with('flash_message', 'Book Delete , error');
            }
        }

        # Print message based on the action perforemd
        if ($book_deleted)
            return Redirect::to('/book/list')->with('flash_message', 'Swap value deleted');

        $msg = '';

        foreach ($returnMsg as $message) {
            if ($message == 'Performed' || 'Same Value')
                continue;
            else
                $msg = $msg . $message . "<br>";
        }

        return Redirect::to('/book/list')->with('flash_message', $msg);

    }

    /* This is for new books creation takes only one field
     */

    public function getCreate()  {

        return View::make('pages.book_add')->with('owners', Auth::user()->id);

    }

    /*
     * This is for the data to be validated and the user selection is added to your inventory
     */

    public function postCreate() {
        $rules = array(
            'select_book' => 'required'
        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if ($validator->fails()) {

            return Redirect::to('/book/create')->with('flash_message', 'Problem with the input, fix and try again')->withInput()->withErrors($validator);
        }
        $value  = Input::get('select_book'); #Take from the Input based on the Google API Output
        $title  = Input::get('title');
        $author = Input::get('author');
        $isbn   = Input::get('isbn');
        $cover  = Input::get('cover');

        foreach ($value as $index) {
            $book                = new Book();
            $book->title         = $title[$index];
            $book->author        = $author[$index];
            $book->isbn          = $isbn[$index];
            $book->cover         = $cover[$index];
            $book->owner_id      = Auth::user()->id;
            $book->ready_to_swap = 'Y';

            $book->save();
        }
        return Redirect::to('/book/create')->with('flash_message', 'Book added');

    }

    /*
     * This function calls the Helper model which has the Google API interaction.
     * They provide the list of books which closely fall towards the book title or author
     */
    public function showGoogleBooks()  {

        $rules = array(
            'search_text' => 'required|min:8'
        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if ($validator->fails()) {

            return Redirect::to('/book/create')->with('flash_message', 'Problem with the input, fix and try again')->withInput()->withErrors($validator);
        }
        $books = Helper::showGoogleBooks();
        return View::make('pages.book_google_add')->with('books', $books);
    }

    /*
     * These are edit functions. They are mainly taken from Susan buck's foobooks
     */
    public function getEdit($id)  {
        try {
            $book = Book::findOrFail($id);
        }
        catch (exception $e) {
            return Redirect::to('/book/list')->with('flash_message', 'Book not found');
        }
        return View::make('pages.book_edit')->with('book', $book);
    }


    /**
     * Process the "Edit a book form"
     * @return Redirect
     * This is mainly taken from Susan Buck's Foobooks
     */
    public function postEdit()  {

        try {
            $book = Book::findOrFail(Input::get('id'));
        }
        catch (exception $e) {
            return Redirect::to('/book')->with('flash_message', 'Book not found');
        }

        # http://laravel.com/docs/4.2/eloquent#mass-assignment
        $book->fill(Input::all());
        $book->save();

        return Redirect::action('BookController@getSearch')->with('flash_message', 'Your changes have been saved.');

    }

}
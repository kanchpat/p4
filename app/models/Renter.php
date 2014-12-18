<?php

class Renter extends Eloquent {

    protected $guarded = array('id', 'created_at', 'updated_at', 'return_ind');

    /*
     * This has a many to many relationship with books.
     * Accesses pivot table
     */

    public function books() {
        # Tags belong to many Books
        return $this->belongsToMany('Book', 'book_renter');
    }

    /*
     * Simple Retrieval call for Renter table by passing the id
     */
    public static function getRenter($id) {
        $renter = Renter::find($id);
        return $renter;
    }

    /*
     * Retrieves the pivot table and renter table for information when Renter id is passed with the return Ind is passed
     * Used in approval process/msgs/list post method
     */
    public static function getRenterForRenterUserId($renterId, $bookId) {

        $books_renters = DB::table('book_renter')->where('book_id', '=', $bookId)->get();

        foreach ($books_renters as $book_renter) {
            $renter = Renter::where('id', '=', $book_renter->renter_id)->where('renter_id', '=', $renterId)->where('return_ind', '=', ' ')->first();
            return $renter;
        }
        return null;
    }

    /*retrieve the Renter records for a book id
     *
     *
     */
    public static function getRentersForBook($book) {
        $id = $book->id;
        $renters = Book::with('renter')->whereHas('renter', function($query) use ($id)
                        {
                            $query->where('book_id', '=', $id);
                         })->get();
        return $renters;
    }
    /* Create a new Rental record, this is initiated from the /book/rent post controller
     */
    public static function createRent($id)     {
        $rent              = new Renter();
        $rent->renter_id   = Auth::user()->id;
        $rent->rental_date = Carbon::now()->toDateString();
        $dt                = Carbon::now()->addMonth();
        $rent->return_date = $dt->toDateString();
        $rent->return_ind  = ' ';
        $rent->save();

        $book = Book::find($id);
        $rent->books()->attach($book);

    }

    /*Accepts the user id and returns the books rented out by the individual with the books information
     * This is called from /book/loan get and post methods
     */
    public static function rentInfo($query) {

        # If there is a query, search the library with that query
        if ($query) {

            # Eager load tags and author
            $rentInfo = Renter::with('books')->where('renter_id', '=', $query)->where('return_ind', '=', 'N')->get();

        }
        # Otherwise, just fetch all books
        else {
            $rentInfo = Book::all();
        }

        return $rentInfo;
    }

    /*Same as above , but gets the past rental info of an individual with the books
     *
     */
    public static function pastRentInfo($query) {

        # If there is a query, search the library with that query
        if ($query) {

            # Eager load tags and author
            $rentInfo = Renter::with('books')->where('renter_id', '=', $query)->where('return_ind', '=', 'Y')->get();
        }
        # Otherwise, just fetch all books
        else {
            $rentInfo = Book::all();
        }

        return $rentInfo;
    }

    /* Queries the Renters table for the renter id from screen and sets the return_ind and return date
     * called from /book/loan - post method - Initiate Return button
     */
    public static function initiateReturn($value) {

        foreach ($value as $id) {
            try {
                $renter = Renter::find($id)->first();
            }
            catch (exception $e) {
                return "Exception";
            }

            if ($renter->return_ind == 'Y')
                return "Something incorrect with the data";
            else {
                $renter->return_ind  = 'Y';
                $renter->return_date = Carbon::now()->toDateString();
            }
            $renter->save();
        }

        return "Initiation performed. Please send the book back to owner";
    }

    /* Queries for Books and Rental with the book id specified.
     *  Sets the return ind =' N' to signify that this book is initiated for rental request
     *
     */

    public static function initiateRent($value) {
        try {
            $renter = Renter::find($value);
        }
        catch (exception $e) {
            return "Exception";
        }

        if ($renter->return_ind == 'N')
            return "Something incorrect with the data";
        else {
            $renter->return_ind = 'N';
            $renter->save();
            return "Performed";
        }
    }

    /*
     * Deletes the Renter record including the pivot table record during Rejection of a request
     */
    public static function deleteRenterRowForRejection($id, $book) {
        try {
            $renter = Renter::find($id);
        }
        catch (Exception $e) {
            var_dump($e);
        }
        $book->renter()->detach($id); # Detaching the renter from the book
        Renter::destroy($id);
        $renter->save();

    }

    /*
     * Find all the Renters for the bookId so that all could be deleted based on the request
     * This is used in /books/list and Delete option is pressed
     */
    public static function findAndDeleteAllRentersForBookId($book) {
        $books = Renter::getRentersForBook($book);

        foreach ($books as $book) {
            foreach ($book->Renter as $renter) {
                try {
                    $book->renter()->detach($renter->id);
                    Renter::destroy($renter->id);
                    $renter->save();
                }
                catch (Exception $e) {
                    return false;
                }

            }
        }

        return true;
    }

}
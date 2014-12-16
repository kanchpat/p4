<?php

class Renter extends Eloquent {

    protected $guarded = array('id', 'created_at', 'updated_at','return_ind');

    public function books() {
        # Tags belong to many Books
        return $this->belongsToMany('Book','book_renter');
    }


    /* Create a new Rental record, this is initiated from the /book/rent post controller
    */
    public static function createRent($id){
        $rent = new Renter();
        $rent->renter_id = Auth::user()->id;
        $rent->rental_date =  Carbon::now()->toDateString();
        $dt = Carbon::now()->addMonth();
        $rent->return_date = $dt->toDateString();
        $rent->return_ind = ' ';
        $rent->save();

        $book = Book::find($id);
        $rent->books()->attach($book);
    }

    /* Queries the book table for available books which are not owned by the current user
     * and renter table for the same book  not rented out or initiated for rental
     * Called from /book/rent get method
     */
    public static function availableRentInfo($id) {

        # If there is a query, search the library with that query
        if($id) {

            # Eager load tags and author
            $rentInfo = Renter::with(array('books' => function($query) use($id){
                    $query->where('owner_id','!=',$id);
                }))
                  ->where('return_ind','!=','N')
                  ->orWhere('return_ind','!=',' ')
                  ->get();
            return $rentInfo;
        }
        # Otherwise, just fetch all books
        else {
           return false;        # Eager load tags and author
        }

    }

    /*Accepts the user id and returns the books rented out by the individual with the books information
     * This is called from /book/loan get and post methods
     */
    public static function rentInfo($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load tags and author
            $rentInfo = Renter::with('books')
                 ->where('renter_id','=',$query)
                 ->where('return_ind','=','N')
                ->get();
            # Note on what `use` means above:
            # Closures may inherit variables from the parent scope.
            # Any such variables must be passed to the `use` language construct.

        }
        # Otherwise, just fetch all books
        else {
            # Eager load tags and author
            $rentInfo = Book::all();
        }

        return $rentInfo;
    }

    /*Same as above , but gets the past rental info of an individual with the books
     *
     */
    public static function pastRentInfo($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load tags and author
            $rentInfo = Renter::with('books')
                ->where('renter_id','=',$query)
                ->where('return_ind','=','Y')
                ->get();
            # Note on what `use` means above:
            # Closures may inherit variables from the parent scope.
            # Any such variables must be passed to the `use` language construct.

        }
        # Otherwise, just fetch all books
        else {
            # Eager load tags and author
            $rentInfo = Book::all();
        }

        return $rentInfo;
    }

    /* Queries the Renters table for the renter id from screen and sets the return_ind and return date
     * called from /book/loan - post method - Initiate Return button
     */
    public static function initiateReturn($value) {

        foreach($value as $id){
            try {
                $renter = Renter::find($id)
                    ->first();
                }
            catch(exception $e) {
                return "Exception";
            }

            if($renter->return_ind == 'Y')
                return "Something incorrect with the data";
            else
            {
                $renter->return_ind='Y';
                $renter->return_date =  Carbon::now()->toDateString();
            }
                $renter->save();
        }

        return "Initiation performed";
    }

    /* Queries for Books and Rental with the book id specified.
    *  Sets the return ind =' N' to signify that this book is initiated for rental request
     *
     */

 /*   public static function initiateRent($value) {

        foreach($value as $id){
            try {
                $renter = Renter::where('book_id','=',$id)
                    ->first();
            }
            catch(exception $e) {
                return "Exception";
            }

            if($renter->return_ind == 'N')
                return "Something incorrect with the data";
            else
            {
                $renter->return_ind='N';
            }
            $renter->save();
        }

        return "Initiation performed";
    }*/

    /* Queries the books and Renter table for the book id specified. Retrieves the record and sets the return_ind
    * to 'N' to indicate that the owner of the book has approved the request
     * Called from /msgs/list post method
     */

    public static function approveRentalForBookId($id) {
        try {
            $renters = Renter::with('books')
                      ->whereHas('books' ,function($query) use($id){
                    $query->where('book_id','=',$id);
                        })
                 ->get();

                 foreach($renters as $renter)
                    {
                        $renter->return_ind = 'N';
                        $renter->save();
                    }
             return true;
        }
            catch(exception $e) {
                return false;
            }
        }

    public static function findRentalForBookId($id) {
       try {
            $renter = Renter::with('books')
                ->whereHas('books' ,function($query) use($id){
                    $query->where('book_id','=',$id);
                })
                ->where('return_ind','=',' ')
                ->first();
            return $renter;
        }
        catch(exception $e) {
            return null;
        }
    }


}
<?php

class Book extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at','owner_id','cover');

    /**
     * Book belongs to Author
     * Define an inverse one-to-many relationship.
     */
    public function user() {

        return $this->belongsTo('User');

    }

    /**
     * Books belong to many Tags
     */
    public function renter() {

        return $this->belongsToMany('Renter');

    }

    public static function getBook($id){
        $book = Book::find($id);
        return $book;
    }

    public static function getRenter($book){
        $id=$book->id;
        $renter = Book::with('renter')
            ->whereHas('renter' ,function($query) use($id){
                $query->where('book_id','=',$id)
                    ->where('return_ind','=','N');
            })
            ->first();
        return $renter;
    }

    /* Queries the book table for available books which are not owned by the current user
  * and renter table for the same book  not rented out or initiated for rental
  * Called from /book/rent get method
  */
    public static function availableRentInfo($id) {

        # If there is a query, search the library with that query
        if($id) {
            # Eager load tags and author
            $rentInfo = Book::where('owner_id','!=',$id)
                ->where('ready_to_swap','=','Y')
                ->get();
            return $rentInfo;
        }
        # Otherwise, just fetch all books
        else {
            return false;        # Eager load tags and author
        }

    }

    /**
     * Queries for the books table for all the books this current user id
     * Used in /book/list get Method
     */
    public static function searchWithOwnerId($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load tags and author
            $books = Book::where('owner_id','=',$query)->get();

            # Note on what `use` means above:
            # Closures may inherit variables from the parent scope.
            # Any such variables must be passed to the `use` language construct.

        }
        # Otherwise, just fetch all books
        else {
            # Eager load tags and author
            $books = Book::all();
        }

        return $books;
    }


    /*
    * Delete book based on the id
    */
    public static function delete_book($value) {

        try {
            $book = Book::findOrFail($value);
        }
        catch(exception $e) {
            return false;
        }

        if(Renter::findAndDeleteAllRentersForBookId($book))
        {
            Book::destroy($value);
            $book->save();
            return true;
        }
        else
            return false;
    }

    /*Queries book for the id specified and updates the ready_to_swap indicator
     * Used in /book/list post method.
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


    public static function changeRentForBookID($id,$futureValue) {
        $book = Book::find($id);

        if($book->ready_to_swap == $futureValue)
            return "Same Value";

        if($book->ready_to_swap == 'Y')
        {
            $book->ready_to_swap=$futureValue;
            $book->save();
            return "Performed";
        }
        else
        {
            $renters = Renter::getRentersForBook($book);
            if(count($renters) > 0)
            {
                foreach($renters as $renter)
                    if($renter->return_ind = 'N')
                        return "Book Already rented out :".$book->title;
            }
            $book->ready_to_swap=$futureValue;
            $book->save();
            return "Performed";
        }
        return "Performed";
    }
}
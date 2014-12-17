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
                    $query->where('book_id','=',$id);
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

        foreach($value as $id){
            try {
                $book = Book::findOrFail($id);
            }
            catch(exception $e) {
                return false;
            }

            Book::destroy($id);
            $book->save();
        }

        return true;
   }

/*Queries book for the id specified and updates the ready_to_swap indicator
 * Used in /book/list and also the msg/list post method for edit operation
 */

    public static function changeRentForBookID($id) {
       try {
                $book = Book::findOrFail($id);
            }
            catch(exception $e) {
                return "Something wrong with the data";
            }

            if($book->ready_to_swap == 'Y')
            {
                $book->ready_to_swap='N';
                $book->save();
                return "Performed";
            }
            else
              return "Book already out for rental";
    }
}
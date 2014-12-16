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

/*    public static function searchWithBookId($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load tags and author
            $books = Book::find($query)->get();

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
    }*/

    /*
     *
     */
/*    public static function rent($query){
            # If there is a query, search the library with that query
            if($query) {
                try{
                $rentInfo = Book::where('owner_id','!=',$query)
                            ->where('ready_to_swap','=','Y')
                    ->get();
                    return $rentInfo;
                }
                catch(Exception $e){
                    return null;
                }
            }
            # Otherwise, just fetch all books
            else {
                # Eager load tags and author
                $rentInfo = Book::all();
            }
            return $rentInfo;
        }*/

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
                return false;
            }

            if($book->ready_to_swap == 'Y')
                $book->ready_to_swap='N';
            else
                $book->ready_to_swap='Y';
            $book->save();

        $ownerInfo = Message::createMessageForApproveRental($id);
        return $ownerInfo;
    }
}
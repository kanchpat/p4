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

    /**
     * Search among books, authors and tags
     * @return Collection
     */
    public static function search($query) {

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

    public static function rent($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load tags and author
            $books = Book::where('owner_id','!=',$query)
                -> where('ready_to_swap','=','n')
                ->get();

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


public static function change_rent($value) {

    foreach($value as $id){
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
    }

    return true;
}

}
<?php

class Book extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at');

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


}
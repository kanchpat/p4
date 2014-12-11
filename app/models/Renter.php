<?php

class Renter extends Eloquent {

    protected $guarded = array('id', 'created_at', 'updated_at');

    public function books() {
        # Tags belong to many Books
        return $this->belongsToMany('Book');
    }


    public static function createRent($id){
        $rent = new Renter();
        $rent->renter_id = Auth::user()->id;
        $rent->book_id = $id;
        $rent->rental_date =  Carbon::now()->toDateString();
        $dt = Carbon::now()->addMonth();
        $rent->return_date = $dt->toDateString();
        $rent->save();
    }

    public static function rentInfo($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load tags and author
            $rentInfo = Renter::where('renter_id','=',$query)
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
}
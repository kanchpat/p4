<?php

class Renter extends Eloquent {

    protected $guarded = array('id', 'created_at', 'updated_at','return_ind');

    public function books() {
        # Tags belong to many Books
        return $this->belongsToMany('Book');
    }


    public static function createRent($id){
        $rent = new Renter();
        $rent->renter_id = Auth::user()->id;
        $rent->rental_date =  Carbon::now()->toDateString();
        $dt = Carbon::now()->addMonth();
        $rent->return_date = $dt->toDateString();
        $rent->return_ind = ' ';
        $rent->save();

        $book = Book::find($id);
        $book->renters()->attach($rent);
    }

    public static function rentInfo($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load tags and author
            $rentInfo = Renter::with('books')
                 ->where('renter_id','=',$query)
                 ->where('return_ind','=',' ')
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

    public static function initiateReturn($value) {

        foreach($value as $id){
            try {
                $renter = Renter::where('id','=',$id)
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
}
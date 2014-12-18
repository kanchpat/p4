<?php

class Book extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at', 'owner_id', 'cover');

    /**
     * Book belongs to user, this relation ship is one user to many books
     * Book table has a field OWNER_ID to maintain the relationship
     */
    public function user() {

        return $this->belongsTo('User');

    }

    /**
     * Books belong to many Renters. A book could be rented multiple times
     * This relationship is maintained through a Pivot table Book_Renter
     * It has a Many to Many Relationship
     */
    public function renter() {

        return $this->belongsToMany('Renter');

    }

    /* Simple retrieval of book table based on the id
     * Called from the msgs/list post method during the approval / reject process
     */

    public static function getBook($id) {
        $book = Book::find($id);
        return $book;
    }

    /* Queries the book table for available books which are not owned by the current user
     * and renter table for the same book  not rented out or initiated for rental
     * Called from /book/rent get method
     */
    public static function availableRentInfo($id) {

        if ($id) {
            # Fetch book wihen the owner id is not current user id and ready to swap is set
            $rentInfo = Book::where('owner_id', '!=', $id)->where('ready_to_swap', '=', 'Y')->get();
            return $rentInfo;
        }
        # Otherwise, return false
        else {
            return false;
        }

    }

    /**
     * Queries for the books table for all the books this current user id
     * Used in /book/list get Method
     */
    public static function searchWithOwnerId($query) {

        if ($query) {

            # Retrieves the book when the owner id is specified. This is to display all the books you own
            $books = Book::where('owner_id', '=', $query)->get();

            }
        # Otherwise, return null
        else {
            return null;
        }

        return $books;
    }


    /*
     * Delete book based on the id. Used the in /book/list post method when the delete option is selected
     */
    public static function delete_book($value) {

        try {
            $book = Book::findOrFail($value);
        }
        catch (exception $e) {
            return false;
        }
        # Delete all records in Renter table
        # Deletes records in message table through OnDelete Cascade specified during the migration
        if (Renter::findAndDeleteAllRentersForBookId($book)) {
            Book::destroy($value);
            $book->save();
            return true;
        } else
            return false;
    }

    /*Queries book for the id specified and updates the ready_to_swap indicator
     * Used in /book/list post method and msgs/list post method
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


    public static function changeRentForBookID($id, $futureValue) {
        $book = Book::find($id);

        #Checks if the current book value and future value are same
        if ($book->ready_to_swap == $futureValue)
            return "Same Value";

        #If the current ready to swap is "Y" , then sets it to "N"

        if ($book->ready_to_swap == 'Y') {
            $book->ready_to_swap = $futureValue;
            $book->save();
            return "Performed";
        }
        else {
            #Retrieves the Renters related to this book in Renters table
            $renters = Renter::getRentersForBook($book);
            if (count($renters) > 0) {
                foreach ($renters as $renter)
                    if ($renter->return_ind = 'N') #Checks if the Return Indicator is "N" , this signifies this is currently on rent
                        return "Book Already rented out :" . $book->title;
            }
            $book->ready_to_swap = $futureValue;
            $book->save();
            return "Performed";
        }
        return "Performed";
    }
}
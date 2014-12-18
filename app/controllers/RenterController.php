<?php

class RenterController extends \BaseController
{


    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();

        $this->beforeFilter('auth', array(
            'except' => 'getIndex'
        ));
    }

    /*
     * Called from /book/rent to identify books rented by the user id
     */
    public function getRent() {
        $books = Book::availableRentInfo(Auth::user()->id);
        if (is_null($books))
            return Redirect::to('/book/rent')->with('error_message', 'Issue accessing the book rental');
        else
            return View::make('pages.book_rent')->with('books', $books);
    }

    /**
     * Process the /books/rent post method  to initiate a rental
     * @return Redirect
     */
    public function postRent() {
        $value = Input::get('BookRent');
        if (is_array($value)) {
            foreach ($value as $bookInfo) {
                Renter::createRent($bookInfo); #Create a new record in Renter
                Message::createMessageForInitiateRental($bookInfo, Auth::user()->id); # Create a new message
            }
            return Redirect::to('/book/rent')->with('flash_message', 'Book Rent Initiated. Wait for the owner to get back, meanwhile proceed with the next selection');
        }
        else {
            return Redirect::to('/book/rent')->with('flash_message', 'Pick a selection');
        }
    }


    /*Identifies the books rented by the owner
     *
     *
     */
    public function getLoan()   {
        $renter = Renter::rentInfo(Auth::user()->id);
        return View::make('pages.book_loan')->with('renters', $renter);

    }

    /*
     * Gets Past Rental Info or initiates the return
     */
    public function postLoan()  {
        if (Input::get('action') == 'Past Rental') {
            $renter = Renter::pastRentInfo(Auth::user()->id);
            return View::make('pages.past_rental')->with('renters', $renter);
        }
        else {
            $val = Input::get('BookReturn');
            if (is_array($val))
                $msg = Renter::initiateReturn($val); #Sets the Return Ind to "Y"
            else
                $msg = "No Initiate Books clicked";
            $renter = Renter::rentInfo(Auth::user()->id);
            return View::make('pages.book_loan')->with('renters', $renter)->with('flash_message', $msg);
        }
    }

}
<?php

class RenterController extends \BaseController {


    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();

        $this->beforeFilter('auth', array('except' => 'getIndex'));

    }


    /**
     * Process the "Add a book form"
     * @return Redirect
     */
    public function postRent() {
        $value = Input::get('BookRent');
        if(is_array($value))
        {
        foreach($value as $bookInfo){
            Renter::createRent($bookInfo);
            Book::make_rent($bookInfo);
            return Redirect::to ('/book/rent')->with('flash_message','Book Rent');
        }
        }
    }


    public function getLoan() {
        $renter = Renter::rentInfo(Auth::user()->id);
    //    var_dump($renter);
        return View::make('pages.book_loan')->with('renters',$renter);

    }

    public function postLoan() {
        if(Input::get('action') == 'Past Rental')
        {
            $renter = Renter::pastRentInfo(Auth::user()->id);
            return View::make('pages.past_rental')->with('renters',$renter);
        }
        else
        {
            $val= Input::get('BookReturn');
            if(is_array($val))
                $msg = Renter::initiateReturn($val);
            else
                $msg = "No Initiate Books clicked";
            $renter = Renter::rentInfo(Auth::user()->id);
            return View::make('pages.book_loan')->with('renters',$renter)
                ->with('flash_message',$msg);
        }
    }

}
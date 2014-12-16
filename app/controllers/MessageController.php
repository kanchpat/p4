<?php

class MessageController extends \BaseController {


    /**
     *
     */
    public function __construct() {

        # Make sure BaseController construct gets called
        parent::__construct();

        $this->beforeFilter('auth', array('except' => 'getIndex'));

    }


    /** List all the books you own
     */
    public function getList() {
        $messages = Message::getInfo(Auth::user()->id);

        if(is_null($messages))
            return Redirect::to ('/')->with('flash_message','Error reading Messages');

        foreach($messages as $message)
            $owner_names[]= Owner::getName($message['user_id']);

        if(!isset($owner_names))
            return Redirect::to ('/')->with('flash_message','Error reading Messages');


        return View::make('pages.messages_list')
                    ->with('messages',$messages)
                    ->with('owner_names',$owner_names);

    }

    public function postList() {

        $values = Input::get('select');
        if(is_null($values))
            return Redirect::to ('/msgs/list')->with('flash_message','Pick a selection');

        $bookIds = Input::get('id');
        $msgIds = Input::get('msg_id');

        foreach($bookIds as $bookId){
            $book = Book::getBook($bookId);
            $renter= Book::getRenter($book);
        }

        //  $message = Message::getMessage($msgId);
        print_r($renter);
        print_r($book);
    }


    public function xxxpostList() {

        $values = Input::get('select');

        if(is_null($values))
            return Redirect::to ('/msgs/list')->with('flash_message','Pick a selection');

        $idInfo = Input::get('id');
        $msgId = Input::get('msg_id');
        $i=0;
       foreach ($values as $value)
        {
          if($value == '0')
                {
                 $ownerInfo = Book::changeRentForBookID($idInfo[$i]);
 /*                  $successInfoForRenter=Renter::approveRentalForBookId($idInfo[$i]);
                   $successInfoForMsgs=Message::setReadInd($msgId[$i]);*/
            //        var_dump($messages);
         /*            if (!($successInfoForRenter || $successInfoForBook  || $successInfoForMsgs))
                        return Redirect::to ('/msgs/list')->with('flash_message','Something went wrong');*/
                }

          if($value == '1')
                {
                    Renter::delete_rental($idInfo[$i]);
                }
            $i++;
        }

/*
           return View::make('pages.messages_address')->with('flash_message','Your books have been approved / rejected as per option
                                                             Renter has been notified with the approval')
                                                 ->with('ownerInfo',$ownerInfo);
                                                 ->*/
    }

}
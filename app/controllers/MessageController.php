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

        $i=0;
        $msgIds = Input::get('msg_id');

        foreach($msgIds as $msgId)
        {
            $message = Message::getMessage($msgId);
            $book = Book::getBook($message->book_id);
            $renterWithBook= Book::getRenter($book);

            $renter = Renter::getRenter($renterWithBook['renter'][0]->id);

            $returnBook[] = new Book();
            $returnRenter[] = new Renter();
            $owner[] = new Owner();
            $email[] = array();

            /* Check if the ready_to_swap ind is "Y" or "N". if yes, let them know its been already used
             * Update ready_to_swap ind to "N"
             * Update Read_ind in messages
             * Update return_ind to "N" in Renter
             * Create a new message for approval to the renter
             * Get the renter user and address info to the owner
             */

           if($values[$i++]==0)
            {
            $returnMsgforBookUpdate = Book::changeRentForBookID($book->id);
            if($returnMsgforBookUpdate == 'Performed')
            {
                $returnMsgforRentalUpdate = Renter::initiateRent($renter->id);
            }
            else
                return View::make ('pages.messages_approval')->with('flash_message',$returnMsgforBookUpdate)
                                                  ->with('books',$returnBook)
                                                  ->with('owners',$owner)
                                                  ->with('emails',$email);

            if($returnMsgforRentalUpdate != 'Performed')
                return View::make ('pages.messages_approval')->with('flash_message',$returnMsgforRentalUpdate)
                                                        ->with('books',$returnBook)
                                                        ->with('owners',$owner)
                                                        ->with('emails',$email);


                $returnBook[] = $book;
            $owner[] = Owner::findOwnerInfoForUserId($renter->renter_id);
            $email[] = Auth::user()->email;
            $returnRenter[] = $renter;

            if($returnMsgforRentalUpdate == 'Performed' && $returnMsgforBookUpdate == 'Performed')
            {
                Message::setReadInd($message->id);
                Message::createMessageForApproveRental($book->id,$book->title,$renter->renter_id);
            }
            }
            else{
                //Reject processing
                /*
                 * Set message read_ind = 'Y'
                 * Create a message to the requestor of this requestor that you are unable to rent the book as of now
                 * Delete row from Renter table with this book id
                 *
                 */
                Message::setReadInd($message->id);
                Message::createMessageForRejectRental($book->id,$book->title,$renter->renter_id);
                Renter::deleteRenterRowForRejection($renter->id,$book);
            }
        }
            return View::make ('pages.messages_approval')->with('flash_message',$returnMsgforRentalUpdate)
                                                  ->with('books',$returnBook)
                                                 ->with('owners',$owner)
                                                 ->with('emails',$email);
    }

}
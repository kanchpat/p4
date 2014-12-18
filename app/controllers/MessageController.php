<?php

class MessageController extends \BaseController
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


    /** this is called from the messages page to display messages with the requestor user names
     * Identify them by calling appropriate models
     */
    public function getList() {
        #Gets the Message for the concerned user id logged in
        $messages = Message::getInfo(Auth::user()->id);

        if (count($messages) == 0)
            return View::make('pages.messages_list')->with('messages', $messages);

        foreach ($messages as $message) {
            #Gets the Names for the id's the message was originally generated from
            $owner_names[] = Owner::getName($message['msg_from']);
        }

        if (!isset($owner_names))
            return Redirect::to('/')->with('flash_message', 'Error reading Messages');

        return View::make('pages.messages_list')->with('messages', $messages)->with('owner_names', $owner_names);

    }

    /*
     * This is called when a decision has to be made between Approval or Reject Processing of the message
     */
    public function postList() {

        $values = Input::get('select');
        if (is_null($values))
            return Redirect::to('/msgs/list')->with('flash_message', 'Pick a selection');

        $i      = 0;
        $msgIds = Input::get('msg_id');

        foreach ($msgIds as $msgId) {
            # Get message, book and renter for the message id
            $message = Message::getMessage($msgId);
            $book    = Book::getBook($message->book_id);
            $renter  = Renter::getRenterForRenterUserId($message->msg_from, $message->book_id);

            #This array is created to keep track of only the approved information so as to create the list of address
            $returnBook[]   = new Book();
            $returnRenter[] = new Renter();
            $ownerInfo[]    = new Owner();
            $renterEmail[]  = new User();

            /* Check if the ready_to_swap ind is "Y" or "N". if yes, let them know its been already used
             * Update ready_to_swap ind to "N"
             * Update Read_ind in messages
             * Update return_ind to "N" in Renter
             * Create a new message for approval to the renter
             * Get the renter user and address info to the owner
             */

            $returnMsgforRentalUpdate = false;


            if ($values[$i++] == 0)  {
                #Approval processing
                #Change Ready To Swap indicator in Book table to "N"
                $returnMsgforBookUpdate = Book::changeRentForBookID($book->id, "N");

                if ($returnMsgforBookUpdate == 'Performed') {
                    #Change Return Indicator in Renter table to "N"
                    $returnMsgforRentalUpdate = Renter::initiateRent($renter->id);
                }
                else
                    return View::make('pages.messages_approval')->with('flash_message', $returnMsgforBookUpdate)->with('books', $returnBook)->with('owners', $ownerInfo)->with('emails', $renterEmail);

                if ($returnMsgforRentalUpdate != 'Performed')
                    return View::make('pages.messages_approval')->with('flash_message', $returnMsgforRentalUpdate)->with('books', $returnBook)->with('owners', $ownerInfo)->with('emails', $renterEmail);


                #Save the values
                $returnBook[]   = $book;
                $ownerInfo[]    = Owner::findOwnerInfoForUserId($renter->renter_id);
                $renterEmail[]  = User::find($renter->renter_id);
                $returnRenter[] = $renter;

                if ($returnMsgforRentalUpdate == 'Performed' && $returnMsgforBookUpdate == 'Performed') {
                    #Set the message Read Indicator to "Y" and also create a new message to indicate approval is granted
                    Message::setReadInd($message->id);
                    Message::createMessageForApproveRental($book->id, $renter->renter_id);
                }
            }

            else {
                //Reject processing
                /*
                 * Set message read_ind = 'Y'
                 * Create a message to the requestor of this requestor that you are unable to rent the book as of now
                 * Delete row from Renter table with this book id
                 *
                 */
                Message::setReadInd($message->id);
                Message::createMessageForRejectRental($book->id, $renter->renter_id);
                Renter::deleteRenterRowForRejection($renter->id, $book);
            }
        }

        return View::make('pages.messages_approval')->with('flash_message', $returnMsgforRentalUpdate)->with('books', $returnBook)->with('owners', $ownerInfo)->with('emails', $renterEmail);

    }

}
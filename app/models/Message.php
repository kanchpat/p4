<?php

class Message extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at','user_id');

    /**
     * Book belongs to Author
     * Define an inverse one-to-many relationship.
     */
    public function user() {

        return $this->belongsTo('User');

    }

    public function book() {

        return $this->belongsTo('Book');

    }


    public static function getMessage($msgId){
        $message = Message::find($msgId);
        return $message;
    }

    public static function createMessageForInitiateRental($id,$renter_id){
        $book = Book::find($id);
        $writeMessage="Your book".$book->title."is picked for rental. Please approve";
        $msg = new Message();
        $msg->msg_text = $writeMessage;
        $msg->msg_from = $renter_id;
        $msg->msg_to = $book->owner_id;
        $msg->book_id = $book->id;
        $msg->read_ind = 'N';
        $msg->action_ind='Y';
        $msg->save();
            }

    /* Create message after approval is done*
   *
     *
     */

    public static function createMessageForApproveRental($id,$renter_id){
        $book = Book::find($id);
        $writeMessage="Your book".$book->title."is approved for rental. You should receive them soon";
        $msg = new Message();
        $msg->msg_text = $writeMessage;
        $msg->msg_from = $book->owner_id;
        $msg->msg_to = $renter_id;
        $msg->book_id = $id;
        $msg->read_ind = 'N';
        $msg->action_ind='N';
        $msg->save();
    }

    public static function createMessageForRejectRental($id,$renter_id){
        $book = Book::find($id);
        $writeMessage="Your book".$book->title."is rejected for rental. Check back soon";
        $msg = new Message();
        $msg->msg_text = $writeMessage;
        $msg->msg_from = $book->owner_id;
        $msg->msg_to = $renter_id;
        $msg->book_id = $id;
        $msg->read_ind = 'N';
        $msg->action_ind='N';
        $msg->save();
       }

    /* Queries Message and books to get the information for the user messages which are read and has an action
    *  called from /msgs/list get method
     *
     */
    public static function getInfo($user_id){
        if($user_id) {
            try{
                $messages = Message::with('book')
                    ->where('msg_to','=',$user_id)
                    ->where('read_ind','=','N')
                    ->get();
               return $messages;
            }
            catch(Exception $e){
                return null;
            }
        }
        # Otherwise, just fetch all books
        else {
            # Eager load tags and author
            return null;
        }
           }


    public static function setReadInd($msgId){
            try{
                $message = Message::find($msgId);
                 $message->read_ind = 'Y';
                    $message->save();
                    return true;
            }
            catch(Exception $e){
                return false;
            }
    }
}
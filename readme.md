## Book Buddy App - Book Swapping
This app is designed to create our own library with the books we have at home. With this website I am hoping we could swap the books within the community so that friends can see your books and rent them as needed.

## Live URL

Visit [my link](http://p4.kanch.me)

## Description
1. Involved migrations, pivot tables, CRUD processing with tables
2. Accessed Google Books API to add books
3. Blade Templating for Layouts
3. Other operations such as Login/Signup/Email Verification/Forgot Password

## Demo

 [Screen cast](http://screencast.com/t/m7hQqP8qWIlM)

## Details for teaching team
 1. Completely used PHP/Laravel.
 2. Database is designed with the below tables
     1. Users - User Login info
     2. Owners - User name and address
     3. Books - Books
     4. Renters - Book Rental or Swap
     5. Book_Renter(Pivot)
     6. Messages - Messages between Owner and Renter
 3. CRUD Processing
     1. Create - All new books, renters, messages are created
     2. Read - All information could be accessed
     3. Update - User can manually update availability of the book, initiate rental and initiate a return of book
                 During the transaction , programs also update the return indicator, return date , marking the message as read
     4. Delete - User can manually delete a books record which would internally do an oncascade delete to messages.
                 It would also do a detach and destroy with the pivot tables.
                 During the transaction, program would also do a delete with a renter table if rejected for the rental

 4.  Website Speed 2.52s as per [http://tools.pingdom.com]

##What works and what does not?
1. This book currently does not have a community concept , as long as you are registered with the website you could see the books available for rental. Future update would be to create a group admin representing a community and a book could only be swapped inside that community
2. I am hoping to restrict this website only to add Children books to avoid polluting the website.
3. Currently the messaging process for initiation of rental and return is done only when the concerned user is logged in to the system. Would like to change this to a emailing
4. I would like to have a tag for books so that it could be filtered based on the genre
5. I would like to validate the address against USPS Street Address validator.

##Outside code

 [culttt.com](http://culttt.com/2013/09/23/password-reminders-reset-laravel-4/)

 [Scotch.io] (http://scotch.io/tutorials/simple-and-easy-laravel-login-authentication)

 [bensmith.io] (http://bensmith.io/email-verification-with-laravel)

 [susanbuck] (https://github.com/susanBuck/foobooks)

 [Google Books API] (https://developers.google.com/books/docs/v1/using)

<?php

class Helper{

        public static function checkPostalAddress(Owner $owner){
            $url='http://production.shippingapis.com/ShippingAPITest.dll?API=Verify&XML=';
            /* create a dom document with encoding utf8 */
            $domtree = new DOMDocument('1.0', 'UTF-8');

            /* create the root element of the xml tree */
            $xmlRoot = $domtree->createElement("xml");
            /* append it to the document created */
            $xmlRoot = $domtree->appendChild($xmlRoot);

            $currentAddress = $domtree->createElement("Address");
            $currentAddress = $xmlRoot->appendChild($currentAddress);

            /* you should enclose the following two lines in a cicle */
            $currentAddress->appendChild($domtree->createElement("Address1",$owner->address1));
            $currentAddress->appendChild($domtree->createElement("Address2",$owner->address2));

            $currentAddress->appendChild($domtree->createElement("City",$owner->city));
            $currentAddress->appendChild($domtree->createElement("State",$owner->state));

            $currentAddress->appendChild($domtree->createElement("Zip5",$owner->zip_code));
            $currentAddress->appendChild($domtree->createElement("Zip4",""));

            /* get the xml printed */
            echo $domtree->saveXML();

            return 1;

        }

    public static function showGoogleBooks()
    {
        $title_request = Input::get('search_text');
        $client = new Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        $client->setDeveloperKey("AIzaSyBd_hZnDpgwcRvI4YjEab_zI0cV6sJRX4U");

        $service = new Google_Service_Books($client);
        $optParams = array('maxResults' => '15');
        $results = $service->volumes->listVolumes($title_request, $optParams);

        $books=array();
        $count = 0;

        foreach ($results->getItems() as $item) {
            $books[$count] = new Book();
            $books[$count]->title = $item->volumeInfo->getTitle();
            $books[$count]->author = $item->volumeInfo->getAuthors()[0];

            foreach($item->volumeInfo->getIndustryIdentifiers() as $indInfo)
            {
                if($indInfo->getType() == "ISBN_13")
                {
                    $books["$count"]->isbn = $indInfo->getIdentifier();
                }
                if($indInfo->getType() == "ISBN_10" and is_null($books["$count"]->isbn))
                {
                    $books["$count"]->isbn = $indInfo->getIdentifier();
                }
            }
            if($item->volumeInfo->getImageLinks()['smallThumbnail'])
            {
                $books[$count]->cover =$item->volumeInfo->getImageLinks()['smallThumbnail'];
            }
            else
            {
                $books[$count]->cover = "http://covers.openlibrary.org/b/isbn/".$books[$count]->isbn."-S.jpg";
            }
            $count++;
        }
        return $books;

    }

    public static function multiexplode ($delimiters,$string,$limit) {

        $ready = str_replace($delimiters, $delimiters[0], $string,$limit);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

 }
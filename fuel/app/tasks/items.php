<?php
namespace Fuel\Tasks;

class Items
{
    public static function fetch()
    {
        $result = self::call_ebay(100, 1);
        $numPages = $result->findItemsByKeywordsResponse[0]->paginationOutput[0]->totalPages[0];

        \DBUtil::truncate_table('items');
        $p = 1;
        while ($p <= $numPages) {
            $result = array_pop($result->findItemsByKeywordsResponse);
            if($result->ack[0] === "Success") {
                $numItems = count($result->searchResult[0]->item);
                for ($l = 0; $l < $numItems; $l++) {
                    $thisItem = $result->searchResult[0]->item[$l];
                    $item = new \Model_Item();
                    $item->itemId = $thisItem->itemId[0];
                    $item->title = $thisItem->title[0] ?? null;
                    $item->globalId = $thisItem->globalId[0] ?? null;
                    $item->primaryCategory = (isset($thisItem->primaryCategory)) ? json_encode($thisItem->primaryCategory[0]) : null;
                    $item->galleryURL = $thisItem->galleryURL[0] ?? null;
                    $item->viewItemURL = $thisItem->viewItemURL[0] ?? null;
                    $item->paymentMethod = (isset($thisItem->paymentMethod)) ? json_encode($thisItem->paymentMethod[0]) : null;
                    $item->autoPay = $thisItem->autoPay[0] ?? null;
                    $item->postalCode = $thisItem->postalCode[0] ?? null;
                    $item->location = $thisItem->location[0] ?? null;
                    $item->country = $thisItem->country[0] ?? null;
                    $item->shippingInfo = (isset($thisItem->shippingInfo)) ? json_encode($thisItem->shippingInfo[0]) : null;
                    $item->sellingStatus = (isset($thisItem->sellingStatus)) ? json_encode($thisItem->sellingStatus[0]) : null;
                    $item->listingInfo = (isset($thisItem->listingInfo)) ? json_encode($thisItem->listingInfo[0]) : null;
                    $item->condition = (isset($thisItem->condition)) ? json_encode($thisItem->condition[0]) : null;
                    $item->isMultiVariationListing = $thisItem->isMultiVariationListing[0] ?? null;
                    $item->topRatedListing = $thisItem->topRatedListing[0] ?? null;
                    $item->save();
                }
            }
            $result = self::call_ebay(100, $p++);
        }
        // Now for the remaining pages
    }

    private static function call_ebay($entriesPerPage = 1, $pageNumber = 1) {
        // create a Request_Curl object
        $curl = \Request::forge('https://svcs.ebay.com/services/search/FindingService/v1', 'curl');
        $curl->set_method('get');
        // set some parameters
        $curl->set_params(
            array(
                'SECURITY-APPNAME' => 'JohnBurr-FirstGo-PRD-9b7edec1b-e5b4f399',
                'OPERATION-NAME' => 'findItemsByKeywords',
                'SERVICE-VERSION' => '1.0.0',
                'RESPONSE-DATA-FORMAT' => 'JSON',
                'REST-PAYLOAD' => "true",
                'keywords' => 'Honda Superdream CB250N CB400N',
                'paginationInput.entriesPerPage' => $entriesPerPage ,
                'paginationInput.pageNumber' => $pageNumber,
                'GLOBAL-ID' => 'EBAY-GB',
                'siteid' => '3',
                'sortOrder' => 'EndTimeSoonest'
                ));
                $curl->execute();
                // fetch the resulting Response object
                $result = json_decode($curl->response());
                return $result;
    }
}
// https://svcs.ebay.com/services/search/FindingService/v1?SECURITY-APPNAME=JohnBurr-FirstGo-PRD-9b7edec1b-e5b4f399&OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&keywords=iPhone&paginationInput.entriesPerPage=6&GLOBAL-ID=EBAY-US&siteid=0
// https://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&GLOBAL-ID=$GlobalId&SECURITY-APPNAME=$ebayAppKey&RESPONSE-DATA-FORMAT=XML$locationString&REST-PAYLOAD=true&itemFilter(0).name=ListingType&itemFilter(0).value=FixedPrice&paginationInput.entriesPerPage=$entriesPerPage&paginationInput.pageNumber=1&sortOrder=$sortOrder&keywords=$searchTerms

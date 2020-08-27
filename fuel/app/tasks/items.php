<?php
namespace Fuel\Tasks;

class Items
{
    public static function fetch()
    {
        $keywords = 'Honda Superdream CB250N CB400N';
        $result = self::call_ebay(100, 1, $keywords);
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
                    $item->sellerUserName = (isset($thisItem->sellerInfo)) ? $thisItem->sellerInfo[0]->sellerUserName[0] : null;
                    $item->feedbackScore = (isset($thisItem->sellerInfo)) ? $thisItem->sellerInfo[0]->feedbackScore[0] : null;
                    $item->storeName = (isset($thisItem->storeInfo)) ? $thisItem->storeInfo[0]->storeName[0] : null;
                    $item->storeURL = (isset($thisItem->storeInfo)) ? $thisItem->storeInfo[0]->storeURL[0]  : null;
                    $item->save();
                }
            }
            $result = self::call_ebay(100, $p++, $keywords);
        }
        // Now for the remaining pages
    }

    public static function fetchTest()
    {
        $result = self::call_ebay(1, 1, 'Honda Superdream CB250N CB400N');
        var_dump($result->findItemsByKeywordsResponse[0]->searchResult[0]->item[0]);
    }

    private static function call_ebay($entriesPerPage = 1, $pageNumber = 1, $keywords) {
        $config = (\Config::get('ebay'));
    //    var_dump($config['production']['credentials']['appId']);die();
        // create a Request_Curl object
        $curl = \Request::forge('https://svcs.ebay.com/services/search/FindingService/v1', 'curl');
        $curl->set_method('get');
        // set some parameters
        $curl->set_params(
            array(
                'SECURITY-APPNAME' => $config['production']['credentials']['appId'],
                'OPERATION-NAME' => 'findItemsByKeywords',
                'SERVICE-VERSION' => '1.0.0',
                'RESPONSE-DATA-FORMAT' => 'JSON',
                'REST-PAYLOAD' => "true",
                'keywords' => $keywords,
                'paginationInput.entriesPerPage' => $entriesPerPage ,
                'paginationInput.pageNumber' => $pageNumber,
                'GLOBAL-ID' => 'EBAY-GB',
                'siteid' => '3',
                'sortOrder' => 'EndTimeSoonest',
                'outputSelector(0)' => 'SellerInfo',
                'outputSelector(1)' => 'StoreInfo'
                ));
                $curl->execute();
                // fetch the resulting Response object
                $result = json_decode($curl->response());
                return $result;
    }
}
// https://svcs.ebay.com/services/search/FindingService/v1?SECURITY-APPNAME=JohnBurr-FirstGo-PRD-9b7edec1b-e5b4f399&OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&keywords=iPhone&paginationInput.entriesPerPage=6&GLOBAL-ID=EBAY-US&siteid=0
// https://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&GLOBAL-ID=$GlobalId&SECURITY-APPNAME=$ebayAppKey&RESPONSE-DATA-FORMAT=XML$locationString&REST-PAYLOAD=true&itemFilter(0).name=ListingType&itemFilter(0).value=FixedPrice&paginationInput.entriesPerPage=$entriesPerPage&paginationInput.pageNumber=1&sortOrder=$sortOrder&keywords=$searchTerms

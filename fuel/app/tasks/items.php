<?php
namespace Fuel\Tasks;

class Items
{
    const ADVANCED_FIND = "findItemsAdvanced";
    const KEYWORD_FIND = "findItemsByKeywords";

    public static function fetch()
    {
        $config = (\Config::get('search'));
        $searchTerms = $config['searchTerms'];
        $table = $config['table'];

        \DBUtil::truncate_table($table);
        foreach ($searchTerms as $searchTerm) {
            $keywords = $searchTerm['keywords'];
            $result = self::call_ebay(100, 1, $searchTerm);
            $numPages = $result->findItemsAdvancedResponse[0]->paginationOutput[0]->totalPages[0];

            $p = 1;
            while ($p <= $numPages) {
                $result = array_pop($result->findItemsAdvancedResponse);
                if ($result->ack[0] === "Success") {
                    $numItems = count($result->searchResult[0]->item);
                    for ($l = 0; $l < $numItems; $l++) {
                        $thisItem = $result->searchResult[0]->item[$l];
                        $item = new \Model_Item();
                        $item->itemId = $thisItem->itemId[0];
                        $item->title = $thisItem->title[0] ?? null;
                        $item->globalId = $thisItem->globalId[0] ?? null;
                        $item->primaryCategory = (isset($thisItem->primaryCategory)) ? json_encode($thisItem->primaryCategory[0]) : null;
                        if (isset($thisItem->pictureURLSuperSize[0])) {
                            $item->galleryURL = $thisItem->pictureURLSuperSize[0];
                        } else {
                            $item->galleryURL = $thisItem->galleryURL[0] ?? null;
                        }

                        $item->galleryURL = preg_replace("/^http:/i", "https:", $item->galleryURL);
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
                        $item->categoryID = $searchTerm['categoryId'];
                        $item->save();
                    }
                }
                $result = self::call_ebay(100, $p++, $searchTerm);
            }
        }
    }

    public static function fetchTest()
    {
        $config = (\Config::get('search'));
        $searchTerms = $config['searchTerms'];
    //    var_dump($searchTerms[0]['keywords']);die();
        $result = self::call_ebay(1, 1, array('keywords' => $searchTerms[0]['keywords'], "categoryId" => null));
        var_dump($result->findItemsAdvancedResponse[0]->paginationOutput);
    }

    private static function call_ebay($entriesPerPage = 1, $pageNumber = 1, $searchTerm = "")
    {
        $config = (\Config::get('ebay'));

        // create a Request_Curl object
        $curl = \Request::forge('https://svcs.ebay.com/services/search/FindingService/v1', 'curl');
        $curl->set_method('get');
        // set some parameters
        $curl->set_params(
            array(
                'SECURITY-APPNAME' => $config['production']['credentials']['appId'],
                'OPERATION-NAME' => self::ADVANCED_FIND,
                'SERVICE-VERSION' => '1.0.0',
                'RESPONSE-DATA-FORMAT' => 'JSON',
                'REST-PAYLOAD' => "true",
                'keywords' => $searchTerm['keywords'],
                'paginationInput.entriesPerPage' => $entriesPerPage ,
                'paginationInput.pageNumber' => $pageNumber,
                'GLOBAL-ID' => 'EBAY-GB',
                'siteid' => '3',
                'sortOrder' => 'EndTimeSoonest',
                'itemFilter(0).name' => 'Condition',
                'itemFilter(0).value(0)' => 'Used',
                'outputSelector(0)' => 'SellerInfo',
                'outputSelector(1)' => 'StoreInfo',
                'outputSelector(2)' => 'PictureURLSuperSize',
                'categoryId' => $searchTerm['categoryId'])
        );

                $curl->execute();
                // fetch the resulting Response object
                $result = json_decode($curl->response());
                return $result;
    }
}
// https://svcs.ebay.com/services/search/FindingService/v1?SECURITY-APPNAME=JohnBurr-FirstGo-PRD-9b7edec1b-e5b4f399&OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&keywords=iPhone&paginationInput.entriesPerPage=6&GLOBAL-ID=EBAY-US&siteid=0
// https://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&GLOBAL-ID=$GlobalId&SECURITY-APPNAME=$ebayAppKey&RESPONSE-DATA-FORMAT=XML$locationString&REST-PAYLOAD=true&itemFilter(0).name=ListingType&itemFilter(0).value=FixedPrice&paginationInput.entriesPerPage=$entriesPerPage&paginationInput.pageNumber=1&sortOrder=$sortOrder&keywords=$searchTerms

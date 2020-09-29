<?php
    return array(
        'searchTerms' => array (
            array('keywords' => 'Honda Superdream CB250N CB400N', "categoryId" => null),
            array('keywords' => 'superdream', "categoryId" => 422)
        ),
        'table' => 'superdream',
        'template' => array (

            'home' =>array (
                'link' => ['title' => "Bikes", 'url' => "bikes"],
                'title' => 'Honda CB250N / CB400N Superdream spare parts for sale on eBay',
                'description' => 'This page contains a list of Honda CB250n and CB400n spare parts availble for sale on eBay',
                'keywords' => 'Honda, CB250N, CB400N, Superdream, spare parts, eBay',
            ),
            'bikes' =>array (
                'link' => ['title' => "Parts", 'url' => "/"],
                'title' => 'Honda CB250N / CB400N Superdream motorcyles for sale on eBay',
                'description' => 'This page contains a list of Honda CB250n and CB400n motorcycles availble for sale on eBay',
                'keywords' => 'Honda, CB250N, CB400N, Superdream, motorcycles, bikes, eBay',
            )

        )
    );
?>

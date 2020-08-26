<?php
/**
 * Configuration settings used by all of the examples.
 *
 * Specify your eBay application keys in the appropriate places.
 *
 * Be careful not to commit this file into an SCM repository.
 * You risk exposing your eBay application keys to more people than intended.
 */
return array(
    'sandbox' => [
        'credentials' => [
            'devId' => 'YOUR_SANDBOX_DEVID_APPLICATION_KEY',
            'appId' => 'YOUR_SANDBOX_APPID_APPLICATION_KEY',
            'certId' => 'YOUR_SANDBOX_CERTID_APPLICATION_KEY',
        ],
        'authToken' => 'YOUR_SANDBOX_USER_TOKEN_APPLICATION_KEY',
        'oauthUserToken' => 'YOUR_SANDBOX_OAUTH_USER_TOKEN',
        'ruName' => 'YOUR_SANDBOX_RUNAME'
    ],
    'production' => [
        'credentials' => [
            'devId' => '1ed517d1-9d07-4026-894e-bfe07c15c855',
            'appId' => 'JohnBurr-FirstGo-PRD-9b7edec1b-e5b4f399',
            'certId' => 'PRD-b7edec1b10e5-7938-4a8a-a653-3874',
        ],
        'authToken' => 'YOUR_PRODUCTION_USER_TOKEN_APPLICATION_KEY',
        'oauthUserToken' => 'YOUR_PRODUCTION_OAUTH_USER_TOKEN',
        'ruName' => 'YOUR_PRODUCTION_RUNAME'
    ]
);

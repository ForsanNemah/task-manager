<?php

function send_with_wapi($auth, $profileId, $phone, $message) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://ads.2moh.net/wapi2024/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'auth=' . urlencode($auth) .
                              '&profile_id=' . urlencode($profileId) .
                              '&phone=' . urlencode($phone) .
                              '&msg=' . urlencode($message),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: 40703bb7812b727ec01c24f2da518c407342559c'
        ),
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        logger()->error('WAPI Error: ' . curl_error($curl));
    } else {
        logger()->info('WAPI Response: ' . $response);
    }

    curl_close($curl);
}

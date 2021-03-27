<?php
function getResponseByUrlsMulti($urls, $followLocation = false, $maxRedirects = 10)
{
    // Options
    $curlOptions = [
        CURLOPT_HEADER => false,
        CURLOPT_NOBODY => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 10,
    ];

    if ($followLocation) {
        $curlOptions[CURLOPT_FOLLOWLOCATION] = true;
        $curlOptions[CURLOPT_MAXREDIRS] = $maxRedirects;
    }

    // Init multi-curl
    $mh = curl_multi_init();
    $chArray = [];

    $urls = !is_array($urls) ? [$urls] : $urls;
    foreach ($urls as $key => $url) {
        // Init of requests without executing
        $ch = curl_init($url);
        curl_setopt_array($ch, $curlOptions);

        $chArray[$key] = $ch;

        // Add the handle to multi-curl
        curl_multi_add_handle($mh, $ch);
    }

    // Execute all requests simultaneously
    $active = null;
    do {
        $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);

    while ($active && $mrc == CURLM_OK) {
        // Wait for activity on any curl-connection
        if (curl_multi_select($mh) === -1) {
            usleep(100);
        }

        while (curl_multi_exec($mh, $active) == CURLM_CALL_MULTI_PERFORM);
    }

    // Close the resources
    foreach ($chArray as $ch) {
        curl_multi_remove_handle($mh, $ch);
    }
    curl_multi_close($mh);

    // Access the results
    $result = [];
    foreach ($chArray as $key => $ch) {
        // Get response
        $result[$key] = curl_multi_getcontent($ch);
    }

    return $result;
}

print_r(getResponseByUrlsMulti(['https://www.example.com', 'https://www.example.org']));
//console.log((getResponseByUrlsMulti(['https://www.example.com', 'https://www.example.org'])));


<?php   // See about cURL in https://www.php.net/manual/en/book.curl.php //


    error_reporting(E_ALL);
    ini_set('display_errors',1);


    // Basic cURL example-------------------------------------------------/

    // 1. Initialize
        $ch = curl_multi_init();

    // 2. Set options See more options in https://www.php.net/manual/en/function.curl-setopt.php

        // URL to send the request to
        curl_setopt($ch,CURLOPT_URL, 'http://www.example.com');

        // Return instead of outputting directly
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // Whether to include the header in the output. Set to false here
        curl_setopt($ch, CURLOPT_HEADER,0);

    // 3. Execute the request and fetch the response. Check for errors
    $output = curl_exec($ch);

        if ($output === false){
            echo "cURL Error: " .curl_error($ch);
        }

    //4. Close and free up the curl handle
        curl_close($ch);

    //5. Display raw output
        print_r($output);


    //POST data with cURL ------------------------------------------------/
    // 1. Basic setup
        $url = '';
        // <?php print_r($_POST);
        $post_data = array(
            'query' => 'some data',
            'method' => 'post',
            'ya' => 'hoo',
        );
    // 2. Initialize
        $ch = curl_init();

    // 3. Set options
        // URL to submit to
        curl_setopt($ch,CURLOPT_URL, $url);

        // Return instead of outputting it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // We are doing a POST request
        curl_setopt($ch,CURLOPT_POST,1);

        // Adding the post variables to the request
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);

    // 4. Execute the request and fetch the response. Check for errors
        $output = curl_exec($ch);

        if ($output === false){
           echo "cURL Error: " .curl_error($ch);
        }
    // 5. Close and free up the curl handle
    curl_close($ch);

    // 6. Display raw output
    print_r($output);





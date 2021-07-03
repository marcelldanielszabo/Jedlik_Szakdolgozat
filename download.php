<?php
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.pdfshift.io/v2/convert/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(array("source" => "tab.php", "landscape" => true, "use_print" => true)),
        CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        CURLOPT_USERPWD => 'cd2469331d084a93ac4fcce7e68fc2a7:'
    ));

    $response = curl_exec($curl);
    file_put_contents('pdfhsift-documentation.pdf', $response);

    // We also have a package to simplify your work:
    // https://packagist.org/packages/pdfshift/pdfshift-php
?>
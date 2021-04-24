<?php 
// You can generate a private key here (2048 bit recommended):
// https://travistidwell.com/jsencrypt/demo/

return [
    'SIGNATURE_METHOD' => 'RS256',
    'KID' => '', //A random string to identify the key value
    'PRIVATE_KEY' => <<< EOD
    -----BEGIN RSA PRIVATE KEY-----
    Insert private key here
    -----END RSA PRIVATE KEY-----
    EOD
];
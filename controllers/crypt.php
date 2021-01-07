<?php 
define('CRYPTO_SECRET_KEY', 'B@t@SCB#Key');
define('CRYPTO_SECRET_IV', 'VecIn!t4SCB');


function encryptString($string)
{
        $key = hash('sha256', CRYPTO_SECRET_KEY);

        /* iv - encrypt method AES-256-CBC expects 16 bytes, else you will get a warning */
        $iv = substr(hash('sha256', CRYPTO_SECRET_IV), 0, 16);

        $output = openssl_encrypt($string, "AES-256-CBC", $key, 0, $iv);

        return($output);
}


/* decryptString
 * -------------
 * Purpose : Decrypt input string using "AES-256-CBC" method
 * Input   : (1) '$string' = input encrypted string
 * Return  : Decrypted string
 */

function decryptString($string)
{
        $key = hash('sha256', CRYPTO_SECRET_KEY);

        /* iv - encrypt method AES-256-CBC expects 16 bytes, else you will get a warning */
        $iv = substr(hash('sha256', CRYPTO_SECRET_IV), 0, 16);

        return(openssl_decrypt($string, "AES-256-CBC", $key, 0, $iv));
}
?>
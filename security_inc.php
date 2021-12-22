<?php

/* 
 * In this file are all functions to make a webbased application more secure.
 * 
 */

// Function checkpost, checks the input from the user
// @parameters: $p_sFormname    type: string    Description: contains the input name of the form 
function checkpost(string $p_strFormName)
{
  // Fill the unclean string with the content of the formname
  $strUnclean = filter_input(INPUT_POST, $p_strFormName);
  // Convert the input special characters to normal characters
  $strHtmlSpecialCharacters = htmlspecialchars($strUnclean);
  // Convert special characters to html characters
  $strHtmlEntities = htmlentities($strHtmlSpecialCharacters);
  return ($strHtmlEntities);
}

// Function input_check, checks if there is a value in the field
// @parameter: $p_strInputvalue type:string description: contains the fieldname.
// @parameter: $p_strFieldname  type:string description: contains the error fieldname
function input_check(string $p_strInputvalue, string $p_strFieldname)
{
  $strInputValue = '';
  if (!filter_input(INPUT_POST, $p_strInputvalue)) {
    echo ("Uw heeft geen " . $p_strFieldname . " ingevuld.<br/>");
  } else {
    $strInputValue = checkpost($p_strInputvalue);
  } // End if 
  return ($strInputValue);
} // End function

// Function encrypt, to encrypt data before it goes to the database
// @parameter:$strPlaintext     type:string     Description: contains the text to be encrypted.
function encrypt(string $p_strPlaintext)
{
  // Create unique keys for the encryption
  $encKey = random_bytes(SODIUM_CRYPTO_BOX_SECRETKEYBYTES); // 32bits key
  $encNonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
  // Encrypt the plaintext
  $strCypherText = base64_encode(sodium_crypto_secretbox($p_strPlaintext, $encNonce, $encKey));
  // Database friendly keys
  $encReturnKey = base64_encode($encKey);
  $encReturnNonce = base64_encode($encNonce);
  // Build the array
  $arrEncryptedValues = array();
  $arrEncryptedValues['cypertext'] = $strCypherText;
  $arrEncryptedValues['key'] = $encReturnKey;
  $arrEncryptedValues['nonce'] = $encReturnNonce;
  // Return the array with encrypted data.
  return ($arrEncryptedValues);
}

function decrypt(string $p_encArrayValues)
{
  // Devide the values is separated variables
  $encCypherText  = $p_encArrayValues['cypertext'];
  $encReturnKey   = $p_encArrayValues['key'];
  $encReturnNonce = $p_encArrayValues['nonce'];
  // Decode the values
  $encPlaintext   = base64_decode($encCypherText);
  $intNonce       = base64_decode($encReturnNonce);
  $intKey         = base64_decode($encReturnKey);
  // Decrypt the cyphertext
  $strPlaintext   = sodium_crypto_secretbox_open($encPlaintext, $intNonce, $intKey);
  // Return the plaintext
  return ($strPlaintext);
}

function base64test()
{
  $encKey = random_bytes(SODIUM_CRYPTO_BOX_SECRETKEYBYTES); // 32bits key
  $encNonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
  echo ($encKey . "<br>");
  echo ($encNonce . "<hr>");
  $b64Key = base64_encode($encKey);
  $b64Nonce = base64_encode($encNonce);
  // store to db
  $d64Key = base64_decode($b64Key);
  $d64Nonce = base64_decode($b64Nonce);
  echo ($d64Key . "<br>");
  echo ($d64Nonce . "<hr>");
  if ($b64Nonce === $d64Nonce)
    echo ("Bei de waardes zijn exact het zelfde");
}

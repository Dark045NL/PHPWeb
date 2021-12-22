<?php

include_once('security_inc.php');
include_once('database_inc.php');

    /* ================== Handle the input form ==============================*/
if(!empty($_POST)){
    $strFirstname         = input_check('strFirstname', 'voornaam');
    $strInsertion         = checkpost('strInsertion');
    $strSurname           = input_check('strSurname', 'achternaam');
    $intPostalcodeNumbers = input_check('intPostalcodeNumbers', 'postcodecijfers');
    $strPostalcodeLetters = input_check('strPostalcodeLetters', 'postcodeletters');
    $strEmailAddress      = input_check('strEmailAddress', 'email');
    $strPasswordOne       = input_check('strPasswordOne', 'wachtwoord');
    $strPasswordTwo       = input_check('strPasswordTwo', 'herhaal wachtwoord');

    if($strPasswordOne===$strPasswordTwo){
        /* ================ Encrypt personal data ================================ */
        $arrEncryptedFirstname      = encrypt($strFirstname);
        $arrEncryptedInsertion      = encrypt($strInsertion);
        $arrEncryptedSurname        = encrypt($strSurname);
        $arrEncryptedEmailAddress   = encrypt($strEmailAddress);
        // Hash the password
        $hshPassword = password_hash($strPasswordOne, PASSWORD_DEFAULT);

        // ==================== Store the data in the database ====================
        // Prepare the SQL statement
        $strSQL = "INSERT INTO `tbl_users` (`encFirstname`,`encInsertion`,`encSurname`,`intPostalcodeNumbers`,`strPostalcodeLetters`,`encEmailAddress`,`encPassword`) 
                 VALUES ('".$arrEncryptedFirstname['cypertext']."',
                 '".$arrEncryptedInsertion['cypertext']."',
                 '".$arrEncryptedSurname['cypertext']."',
                 '".$intPostalcodeNumbers."',
                 '".$strPostalcodeLetters."',
                 '".$arrEncryptedEmailAddress['cypertext']."',
                 '".$hshPassword."')";
        // Execute the SQL statement
        $booSucces = PdoSqlReturnTrue($strSQL);
        // If success fetch the record ID
        if($booSucces){
            $strSQL = "SELECT * FROM `tbl_users` WHERE `encFirstname` = '".$arrEncryptedFirstname['cypertext']."';";
            $arrUserRecord = PdoSqlReturnArray($strSQL);
            // After the fetch store the key and the nonce for the firstname of this user.
            $strSQL = "INSERT INTO `tbl_encryptiondata` (`intFK_intUserRecordID`,`encFirstnameKey`,`encFirstnameNonce`,`encInsertionKey`,`encInsertionNonce`,`encSurnameKey`,`encSurnameNonce`,`encEmailKey`,`encEmailNonce`) ";
            $strSQL .= "VALUES('".$arrUserRecord[0]['intUser_ID']."',
                    '".$arrEncryptedFirstname['key']."','".$arrEncryptedFirstname['nonce']."',
                    '".$arrEncryptedInsertion['key']."','".$arrEncryptedInsertion['nonce']."',
                    '".$arrEncryptedSurname['key']."','".$arrEncryptedSurname['nonce']."',
                    '".$arrEncryptedEmailAddress['key']."','".$arrEncryptedEmailAddress['nonce']."')";
            $booSucces = PdoSqlReturnTrue($strSQL);
        } // End if Succes
    } // End if double password check
}




// ----------- An add user form --------------

echo("
    <!doctype html>
    <html>
        <head>
            <title>Registeren</title>
        </head>
        <body>
        <hr/>Menu<hr/>
        <ul>
            <li><a href='index.php'>Aanmelden</a></li>
        <ul>
        <hr/>
        <form method='post'>
            Voornaam:           <input type='text'      name='strFirstname'><br/>
            Tussenvoegsel:      <input type='text'      name='strInsertion'><br/>
            Achternaam:         <input type='text'      name='strSurname'><br/>
            Postcode cijfers:   <input type='number'    name='intPostalcodeNumbers'><br/>
            Postcode letters:   <input type='text'      name='strPostalcodeLetters'><br/>
            Email:              <input type='email'     name='strEmailAddress'><br/>
            Wachtwoord:         <input type='password'  name='strPasswordOne'><br/>
            Herhaal wachtwoord: <input type='password'  name='strPasswordTwo'><br/>
            <button type='submit'>Registreer</button>
        </form>
        </body>
    </html>
");



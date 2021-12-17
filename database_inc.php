<?php

//************************************
//Function of the file database_inc.php:
//Author: J. de Klijn
//Date of creation: 20 september 2021
//Last edited by: J. de Klijn @ 
//Version: v0.1
//*************************************

// Methode: Creates a connection to the database
// @parameters: none
function connectToDB(){
    $Hostname   = "127.0.0.1";                          // Database servername
    $DBname     = "database_csvp";                             // Database name
    $Username   = "phpuser";                            // Database username
    $Password   = "7slUnhm3zuWcm86m";                   // Database user password    
    $conn = new PDO("mysql:host=$Hostname; dbname=$DBname", $Username, $Password); // Create the actual connection
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return($conn);
}

// Methode: Execute a SQL query and return the fetched data in an array
// @parameters: $sPdoQue type: string, scope: member
function PdoSqlReturnArray($sPdoQuery){
    $DBconnect = connectToDB();                         // Connect to the MySQL database
    $statement = $DBconnect->prepare($sPdoQuery);       // Make the query with the parameter(s)
    $aResult = $statement->execute();                   // Execute the query and put the results in the $aResult
    $arr_rows = $statement->fetchAll(PDO::FETCH_ASSOC); // Put all fetched data into a nested array
    $DBconnect=NULL;                                    // Close the connection
    return($arr_rows);                                  // Return the array data back to the calling method
}

// Methode: Execute a SQL query and return a TRUE
// @parameters: $sPdoQue type: string, scope: member
function PdoSqlReturnTrue($sPdoQuery){
    $DBconnect = connectToDB();                         // Connect to the MySQL database
    $statement = $DBconnect->prepare($sPdoQuery);       // Make the query with the parameter
    $result = $statement->execute();                    // Put the results in the $result
    $DBconnect=NULL;                                    // Close the connection
    return(TRUE);                                       // Return to the calling method
}


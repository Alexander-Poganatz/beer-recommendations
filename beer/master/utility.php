<?php
  session_start();

  //File auther: Alexander Poganatz

  //File purpose: start a php session and provide utility functions for database connections and checking the
  //existance of people.

  //Function name: userExists
  //Purose: Checks to see if the user and pass key in session exists.
  //Accepts: Nothing
  //Returns boolean
  function userExists()
  {
    return array_key_exists('user', $_SESSION) && array_key_exists('pass', $_SESSION);
  }

  //Function name: getDBConnection
  //Purpose: To get a database connection.
  //Accepts nothing.
  //Returns: A database connection object
  function getDBConnection()
  {
    //These fields may have to be changed when going online
    $dBHost = 'localhost';
    $dBUser = $_SESSION['user'];
    $dBPass = $_SESSION['pass'];
    $dBName = 'Beer';

    //The exception is silinced so users don't see if any errors happen while
    //connecting to the database.
    return @new mysqli($dBHost, $dBUser, $dBPass, $dBName);
  }

  //Function name: isLoggedIn
  //Purpose: Test to see if we are logged in
  //Accepts: Nothing
  //Returns: boolean
  function isLoggedIn()
  {
    if(userExists())
    {
      $db = getDBConnection();
      if(!$db->connect_error)
      {
        $db->close();
        return true;
      }
    }

    return false;
  }

/*
  Function name: sanitizeInput()
  Purpose: Accept a string of data and return a string to prevent cross site exploits.
  Accepts: a string.
  Returns: a string.
*/
  function sanitizeInput($input)
  {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
 ?>

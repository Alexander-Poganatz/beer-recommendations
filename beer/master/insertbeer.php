<?php

  //File auther: Alexander Poganatz

  //Function name: insertDrop
  //Purpose: To insert information into the beer database
  //Accepts: some strings that contain the drop info.
  //Returns: A boolean to test if it was a success.

  function insertBeer($beerName, $beerType, $rating)
  {

    if(!isLoggedIn())
      return false;

    //Sanitize input:
    $beerName = sanitizeInput($beerName);
    //I shouldn't worry about sanitizing the other two since it should fail the prepared statements
    //if they are not a straight up number.

    $db = getDBConnection();

    $statement = $db->prepare("INSERT INTO Beer(beer_brand_name, beer_type_id, recommendation_id) VALUES(?,?,?)");

    $statement->bind_param("sii", $beerName, $beerType, $rating);

    $worked = $statement->execute();

    //Close connections:
    $statement->close();
    $db->close();

    return $worked;
  }
 ?>

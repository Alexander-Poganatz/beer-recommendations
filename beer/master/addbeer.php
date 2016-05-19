<?php
  require_once "utility.php";

  //File auther: Alexander Poganatz

  /*
    Function name: addBeer
    Purpose: add a beer to the database,
    Accepts: a name and two ids
    Returns: a boolean.
  */
  function addBeer($name, $typeId, $recommendationId)
  {
    if(!isLoggedIn())
      return false;

    $db = getDBConnection();

    $stmt = $db->prepare("INSERT INTO Beer(beer_brand_name, beer_type_id, recommendation_id) VALUES(?, ?, ?);");

    $cleanName = sanitizeInput($name);
    $stmt->bind_param("sii", $cleanName, $typeId, $recommendationId);

    $worked = $stmt->execute();

    $stmt->close();
    $db->close();
    return $worked;
  }

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(addBeer($_POST['beerName'],$_POST['typeId'],$_POST['recommendationId']))
    {
      echo "Added " . $_POST['beerName'] . ".";
    }
    else {
      echo "Failed to add " . $_POST['beerName'] . ".";
    }
  }
 ?>

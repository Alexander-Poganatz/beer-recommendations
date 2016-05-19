<?php
  require_once "utility.php";

  //File auther: Alexander Poganatz

  /*
    Function name: addBeer
    Purpose: add a beer to the database,
    Accepts: a name and two ids
    Returns: a boolean.
  */
  function addBeer($name, $typeId, $recommendationId, $beerId)
  {
    if(!isLoggedIn())
      return false;

    $db = getDBConnection();

    $stmt = $db->prepare("UPDATE Beer SET beer_brand_name = ?, beer_type_id = ?, recommendation_id = ? WHERE beer_id = ?");

    $cleanName = sanitizeInput($name);
    $stmt->bind_param("siii", $cleanName, $typeId, $recommendationId, $beerId);

    $worked = $stmt->execute();

    $stmt->close();
    $db->close();
    return $worked;
  }

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(addBeer($_POST['beerName'],$_POST['typeId'],$_POST['recommendationId'], $_POST['beerId']))
    {
      echo "Updated " . $_POST['beerName'] . ".";
    }
    else {
      echo "Failed to update " . $_POST['beerName'] . ".";
    }
  }
 ?>

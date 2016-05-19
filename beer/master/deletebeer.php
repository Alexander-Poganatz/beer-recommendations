<?php
  require_once "utility.php";

  //File auther: Alexander Poganatz

  /*
    Function name: deleteBeer
    Purpose: delete a beer to the database,
    Accepts: a id
    Returns: a boolean.
  */
  function deleteBeer($beerId)
  {
    if(!isLoggedIn())
      return false;

    $db = getDBConnection();

    $stmt = $db->prepare("DELETE FROM Beer WHERE beer_id = ?");
    $stmt->bind_param("i", $beerId);

    $worked = $stmt->execute();

    $stmt->close();
    $db->close();
    return $worked;
  }

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(deleteBeer($_POST['beerId']))
    {
      echo "Deleted " . $_POST['beerName'] . ".";
    }
    else {
      echo "Failed to delete " . $_POST['beerName'] . ".";
    }
  }
 ?>

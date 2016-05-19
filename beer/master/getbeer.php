<?php
  require_once "utility.php";

  //File auther: Alexander Poganatz

/*
  Function name: getBeer()
  Purpose: get a specific beer data from the database.
  Accepts: an id(string)
  Return: a string in json format.

*/
  function getBeer($id)
  {

    if(!ctype_digit($id))
      return '{"beer" : {}}';

    if(!isLoggedIn())
      return '{"beer" : {}}';

    $db = getDBConnection();

    //If it passes ctype is a digit I shouldn't worry about injection.
    $sql = 'SELECT * FROM Beer WHERE beer_id = ' . $id .";";

    $result = $db->query($sql);

    $json = '{"beer" : {';

    if($result->num_rows > 0)
    {
      $row = $result->fetch_assoc();

      $json .= '"id" :"'. $row['beer_id'] . '", "beerName" : "' . $row["beer_brand_name"] . '", "beerTypeId" : "'
        . $row["beer_type_id"] . '", "recommendationId" : "' . $row["recommendation_id"] . '"';
    }
    $json .= '}}';

    $db->close();

    return $json;
  }

  if($_SERVER["REQUEST_METHOD"] == 'POST')
  {
    echo getBeer($_POST['id']);
  }
?>

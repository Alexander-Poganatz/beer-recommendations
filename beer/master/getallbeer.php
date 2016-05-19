<?php
  include_once "utility.php";

  //File auther: Alexander Poganatz

  //Function name: getAllBeer
  //Purpose: get all the data in the beer table.
  //Accepts: nothing.
  //returns: a string in json format.

  function getAllBeers()
  {

    if(!isLoggedIn())
      return $json = '{"beers": []}';

    $db = getDBConnection();

    $sql = 'SELECT beer_id, beer_brand_name, beer_type, recommendation '
    . 'FROM Beer INNER JOIN Beer_Type on Beer.beer_type_id = Beer_Type.beer_type_id '
    .'INNER JOIN Recommendation on Beer.recommendation_id = Recommendation.recommendation_id;';

    $result = $db->query($sql);

    $json = '{"beers": [';

    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        $json .= '{"id" :"'. $row['beer_id'] . '", "beerName" : "' . $row["beer_brand_name"] . '", "beerType" : "'
          . $row["beer_type"] . '", "recommendation" : "' . $row["recommendation"] . '"},';
      }
      $json = substr($json, 0, strlen($json) - 1);
    }
    $json .= "]}";

    $db->close();

    return $json;
  }

  if($_SERVER['REQUEST_METHOD'] == 'GET')
    echo getAllBeers();

 ?>

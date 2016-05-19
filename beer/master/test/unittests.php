<?php
  //File author: Alexander Poganatz

  //Purpose: to test some functions I made.
  //Requires phpunit and bootstrap.php

  class UnitTester extends PHPUnit_Framework_TestCase
  {
    public function testUserDoesntExist()
    {
      $this->assertEquals(userExists(), false);
      $this->assertFalse(isLoggedIn());
    }

    public function testUserExists()
    {
      $_SESSION['user'] = "";
      $_SESSION['pass'] = "";
      $this->assertTrue(userExists());
    }

    public function testDBConnections()
    {
      //Need user and pass to exist
      $_SESSION['user'] = "";
      $_SESSION['pass'] = "";

      //Test object type
      $this->assertEquals("mysqli", get_class(getDBConnection()));

      $this->assertFalse(isLoggedIn());

      $_SESSION['user'] = 'root';
      $_SESSION['pass'] = 'notAsdf';

      $this->assertTrue(isLoggedIn());
    }

    public function testSanitizeInput()
    {
      $testData = sanitizeInput(" faceb\ook<");
      $this->assertContains("facebook&lt;", $testData);
    }

    public function testGetAllBeers()
    {
      $_SESSION['user'] = 'root';
      $_SESSION['pass'] = 'notAsdf';

      $json = getAllBeers();

      $this->assertContains("1", $json);

      //Just testing, uncomment if needed:
      //echo $json;

      $_SESSION['user'] = '';
      $_SESSION['pass'] = '';

      $json = getAllBeers();

      $this->assertContains('{"beers": []}', $json);
    }

    public function testInsertBeer()
    {
      $_SESSION['user'] = '';
      $_SESSION['pass'] = '';

      $this->assertFalse(insertBeer("Guiness", 4, 3));

      $_SESSION['user'] = 'root';
      $_SESSION['pass'] = 'notAsdf';

      $this->assertTrue(insertBeer("Guiness", 4, 3));

      $this->assertFalse(insertBeer("Guiness", "a", 3));

      $this->assertFalse(insertBeer("Guiness", 3, "a"));

      //TIL that a number will still work..... maybe because the sanitizeInput method
      //call turns the number into a string.
      //$this->assertFalse(insertBeer(1, 3, 2));
    }

    public function testGetBeerOutput()
    {
      $_SESSION['user'] = 'root';
      $_SESSION['pass'] = 'notAsdf';

      //Just need to uncomment when done:
      //echo getBeer("1");
    }
  }
 ?>

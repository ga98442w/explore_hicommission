<?php
//this file is call-ajax-controller.php.  It is called by view.php

 // prints currency in the international format for the en_US locale
 setlocale(LC_MONETARY, 'en_US');

$var = $_GET['name'];
$age = stripslashes($var);

$pieces = explode("=", $age);
//echo $pieces[0]; // piece1
//echo $pieces[1]; // piece2
//echo "<br>";
$name = $pieces[1];
echo $name;
exit;

 
//after echoing back from here
//try calling the model and try to get the model to echo back information


class ControllerClass {

    // initialize the variables/properties
    private $response;
    private $url = "http://localhost/earnings_code_challenge/view.php";
    private $totalrows = 0;

    //the constructor    
    public function __construct() {}

    public function getAverageSalary()
    {
        // I am using javascript to validate on the client side, but I am validating on the server side too just in case		   
	    //if (empty($_GET["name"])) 
	    if (empty($name)) 
	    {
		  echo "Search string is required";
		  return false;
	    }else{
	      //$name = test_input($_GET["name"]);
	      $name = test_input($name);
	      if (preg_match("/^[a-zA-Z ]*$/",$name)) {
		      echo "The search string is O.K. Look here for the results <br>";
		      //exit;
		  }else{
		    echo "Call-Ajax-Model: Only letters and white space allowed";
		    exit;
		  }
	    }
	
echo "model ". $name;
	
exit;		 
		// again, I could have used curl to get the JSON data, but just keeping it simple
        $this->response = file_get_contents('https://data.cityofboston.gov/resource/4swk-wcg8.json');
  		$this->response = json_decode($this->response);
  		
  		// now, this just loops through the returned object 
		foreach($this->response as $num => &$values) 
		{	
		   // gets the object properties
		   $thevals = get_object_vars($values);   	   
		   
		   // assign property values to variables
		   //$searchstring = $_GET['name'];
		   $var = $_GET['name'];
/*$age = stripslashes($var);

$pieces = explode("=", $age);
//echo $pieces[0]; // piece1
//echo $pieces[1]; // piece2
//echo "<br>";
$name = $pieces[1];
echo $name;
exit;
*/
		   $searchstring = $name; 	   
		   $mystring1 = $thevals['title']; 
		   $mystring2 = $thevals['title']; 

		   $pos1 = stripos($mystring2, $searchstring);
   
			// Note our use of ===.  Simply == would not work as expected
			// because the positional issues of the 0th (first) character per api documentation. 
			if ($pos1 !== false) 
			{
			  echo "Found '$searchstring' in '$mystring2' ==> $". $thevals['total_earnings'] . "<br>";
			  $totalrows++;
			  $sum += $thevals['total_earnings'];
			} 
		}	
          
	    //calculate the average salary
	    if($totalrows > 0)
	    {
		  $average = $sum / $totalrows;

		  // report back earnings information as required
		  echo "<br>The Grand Total Salary for the " . $searchstring . " positions-> is : " . money_format('%i', $sum) . "<br>";
		  echo "The total rows is : " . $totalrows . "<br>";

		  echo "The Average salary for the " . $searchstring . " position based on Total Earnings is Grand Total Salary: ". money_format('%i', $sum) . " divided by total number of records " . $totalrows . " = " . money_format('%i', $average) . "<br>";	  
		  return 1;
	    }else{
		  // no data found, the program will return to the start page, but inform the user. The message may be visible on a slower system.
		  echo "Sorry no data found for: " . $searchstring . "<br>";		  
		  return 0;		  
	 }	
   }

} //end of controller

// cleans and tests input for correctness   
function test_input($data) 
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

//ensure the required inputs have been received before proceeding
//if (isset($_GET['name'])) 
if(isset($name)) 
{
  //instantiate the CalculateEarnings controller class
  $workhorse=new ControllerClass();
  //then call the method
  $ret = $workhorse->getAverageSalary();
  if($ret === 0){
    echo data found, the program;
  }

}
?>
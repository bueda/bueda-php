<?php

include 'BuedaRequest.php';    

class TestBuedaRequest {

    const VALID_API_KEY = "";
    const INVALID_API_KEY = "";

    //http://api.bueda.com/enriched?apikey={api_key}&tags={tags}

    function __construct(){
    }

    function testConstructor1(){

        // Check with valid api_key and null tag
        $obj = new BuedaRequest(self::VALID_API_KEY);
        $expected = "";
        $actual = ""; 
    } 

    function testConstructor2(){

        $obj = new BuedaRequest(self::VALID_API_KEY);
        $expected = "";
        $actual = "";
    }

    private function testResults($method_name,$expected,$actual){

        if(!$expected == $actual)
            return "${method_name}() Failed!\nExpected ${expected}\nActual ${actual}\n\n";
    }
}


$test = new TestBuedaRequest();

$methods = $test.get_class_methods();

foreach($method as $methods){
    echo "${method}";
}
    
$obj = new BuedaRequest('vEmEfeiUADwfTP67Cjftq1w91hIJ8hrlY6L8eQ');
echo "${obj}\n";
?>

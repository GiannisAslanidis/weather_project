<?php

# variable for the temperature value.
$temperature_in_celcius;

class send_message {

// function mode
function conn_weather_api()
{

global $temperature_in_celcius;

#The city Name.
$city_name = 'Thessaloníki';
# The weather site api_key.
$api_key = 'b385aa7d4e568152288b3c9f5c2458a5';
# The weather url.
$api_url = 'http://api.openweathermap.org/data/2.5/weather?q='.$city_name.'&appid='.$api_key;

# Take the json array from weather application.
$weather_data = json_decode( file_get_contents($api_url), true);

# The print_r show the json Arrays. 
#echo "<pre>";
#print_r($weather_data);

# Choose from json the array with the name main '[main] => array' and the variable [temp].
$temperature = $weather_data['main']['temp'];

# Convert the fahrenheit value to Celsius.
$temperature_in_celcius = round($temperature - 273.15);

}

// function mode
function conn_msg($msg){
 
   $curl = curl_init();
 
   curl_setopt_array($curl, array(
     CURLOPT_URL => "https://connect.routee.net/sms",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS => $msg ,
     CURLOPT_HTTPHEADER => array(
       "authorization: Basic NWM1ZDVlMjhlNGIwYmFlNWY0YWNjZmVjOk1Ha05mcUd1ZDAK",
       "content-type:  application/json"
     ),
   ));
   
   $response = curl_exec($curl);
   $err = curl_error($curl);
   
   curl_close($curl);
   
   if ($err) {
     echo "cURL Error #:" . $err;
   } else {
     echo $response;
   }
 
 }

}


$send = new send_message();

#call function
$send-> conn_weather_api();



# Check if the value of the temperature is greather or less than 20 and send the corresponding message
if ($temperature_in_celcius > 20){
  
  
  $msg = $send->conn_msg("{ \'body\': \'John Temperature more than 20 °C\ < $temperature_in_celcius °C> ',\'to\' : \'+306911111111\',\'from\': \'John Aslanidis\'}");
  
  # print the function
  echo $send->conn_msg($msg);

} else if ($temperature_in_celcius < 20){

  $msg = "{ \'body\': \'John Temperature less than 20 °C\ < $temperature_in_celcius °C> ',\'to\' : \'+306911111111\',\'from\': \'John Aslanidis\'}";
    
  # print the function
  echo $send->conn_msg($msg);

}

?>

 




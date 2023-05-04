<?php
$requestBody = file_get_contents('php://input');

// Convert the JSON string to a PHP object
$data = json_decode($requestBody);
$input = $data->input;
$threshold = $data->threshold;
$splitBy = 150;
$words = str_word_count($input, 1);
if (count($words) <= $splitBy) {
    $segments = [$input];
} else {
    $segments = array_chunk($words, $splitBy);
    $segments = array_map(function($segment) {
        return implode(" ", $segment);
    }, $segments);
}
$paraphrased = array();
$avg = array();
$all = array();
for ($i = 0; $i < count($segments); $i++) {
    $complete = False;
    
       

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://enterprise-api.writer.com/content/organization/514225/detect",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"input\":\"".$segments[$i]."\"}",
        CURLOPT_HTTPHEADER => [
            "Authorization: ScblpD-gTjsMiYo-fHD57Gfhlbv1Yhjp7SmGwXx5x3OHclqMMunu2Etj8E7zxCxbzFEDk3bAv6G9DiU3e2gZaWAcvyzBnGAcUc5cudosBDvcdefcdsbK4T-yJw_Bl6cL",
            "accept: application/json",
            "content-type: application/json"
        ],
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
      
        if ($err) {
            echo "cURL Error #:" . $err;
            
        } else {
            
            $response = json_decode($response);
            $real_score = isset($response[0]->score) ? $response[0]->score : null;
            if ($real_score && $real_score * 100 >= $threshold) {
                $paraphrased[] = $segments[$i];
                $avg[] = $real_score * 100;
                $all[] = array([
                    "input" => $segments[$i],
                    "real" => $real_score * 100,
                    "valid" => true,
                ]);
                
            }else{
                $avg[] = $real_score * 100;
                $all[] = array([
                    "input" => $segments[$i],
                    "real" => $real_score * 100,
                    "valid" => false,
                ]);
            }
        }
    
}

echo json_encode(array([
    "all" => $all,
    "avg" => array_sum($avg)/count($avg),
]));

?>
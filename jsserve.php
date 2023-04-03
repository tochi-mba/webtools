<?php
                        
                       // Define a regular expression pattern to match values between "((" and "))"
                       $pattern = '/\(\((.*?)\)\)/';

                       // Search for all matches of the pattern in the input code and store them in $matches
                       preg_match_all($pattern, $code, $matches);

                       // Extract the second group of each match (i.e., the value between ">>" and "<<") and store them in $result
                       $result = $matches[1];

                       // Initialize an empty string $params
                       $params = "";

                       // Loop through each value in $result and construct a string $params that sets a variable with the value extracted from a URL parameter using the key as the variable name
                       for($i=0; $i < sizeof($result); $i++) {
                           $params = $params.$result[$i]."=queryURL.searchParams.get('".$result[$i]."');\n";
                       } 

                       // Remove all HTML tags from the code using a regular expression
                       $code = preg_replace('/\(\((.*?)\)\)/', '$1', $code);


                       if(!empty($result)) {
                           // If $result is not empty, write JavaScript code that extracts values from the URL parameters and runs the user's code
                           $code= "const scripts = document.getElementsByTagName('script');\nconst currentScript = scripts[scripts.length - 1];\nlet queryURL = new URL(currentScript.src);\n".$params." ".$code;
                          
                       }                 ?>
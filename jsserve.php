<?php $code = $data['js_code'];

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
                       $code = preg_replace('/\(\(|\)\)/', '', $code);

                       // Create a new file in the user's directory with the name $scriptId.js and write JavaScript code to it
                       $file = fopen("../../scripts/" . $uid . "/" . $script_id ."/".$new_version."/". $script_id . ".js", "w") or die("Unable to create the .js file!");
                       if(!empty($result)) {
                           // If $result is not empty, write JavaScript code that extracts values from the URL parameters and runs the user's code
                           fwrite($file, "const scripts = document.getElementsByTagName('script');\nconst currentScript = scripts[scripts.length - 1];\nlet queryURL = new URL(currentScript.src);\n".$params." ".$code);
                           fclose($file); // close the file
                       } elseif(empty($result)) {
                           // If $result is empty, write JavaScript code that simply runs the user's code
                           fwrite($file, $code);
                           fclose($file); // close the file
                       }                    ?>
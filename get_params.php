<?php
                        
                       // Define a regular expression pattern to match values between "((" and "))"
                       $pattern = '/\(\((.*?)\)\)/';

                       // Search for all matches of the pattern in the input code and store them in $matches
                       preg_match_all($pattern, $code, $matches);

                       // Extract the second group of each match (i.e., the value between ">>" and "<<") and store them in $result
                       $resultParams = $matches[1];
?>
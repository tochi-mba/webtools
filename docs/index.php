<?php require "../head.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Documentation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.js"></script>
    <link rel="stylesheet" href="../codemirror/lib/codemirror.css">
    <script src="../codemirror/lib/codemirror.js"></script>
    <script src="../codemirror/mode/javascript/javascript.js"></script>
    <script src="../codemirror/mode/css/css.js"></script>
    
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .menu {
            position: fixed;
            top: 60px;
            left: 0;
            width: 250px;
            padding: 20px;
            background-color: #eee;
        }
        .menu a {
            display: block;
            padding: 10px 0;
        }
        .menu a.active {
            font-weight: bold;
        }
        .endpoint {
            margin-left: 250px;
            padding: 20px;
        }
        .endpoint h1 {
            margin-bottom: 10px;
        }
        .endpoint h2 {
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .endpoint pre {
            background-color: #eee;
            padding: 10px;
            border-radius: 5px;
        }
        pre{
        white-space: pre-wrap;
        overflow-wrap: break-word;
        }
    </style>
</head>
<body>
    <?php 
    
    require "navbar.php";
    if(isset($_SESSION['uid'])){
        require '../connect.php';
        $uid = $_SESSION['uid'];
        $sql = "SELECT api_token FROM users WHERE uid = '$uid'";
        $query = mysqli_query($conn, $sql);
        if($query){
            $row = mysqli_fetch_assoc($query);
            $api_token = $row['api_token'];
        }
    } else {
        $api_token = "[api_token]";
    }
    ?>

    <div class="container">
        <div class="menu">
            <a href="#create" class="active">Create</a>
            <a href="#get_projects" class="active">Get Projects</a>
            <a href="#edit_projects" class="active">Edit Projects</a>

        </div>
        <div class="endpoint" id="create">
            <h1>Create</h1>
            <p>This API allows users to create a new project.</p>
            <h2>URL</h2>
            <pre>/api/create/</pre>
            <h2>Method</h2>
            <pre>POST</pre>
            <h2>Auth required</h2>
            <pre>Yes</pre>
            <h2>Data constraints</h2>
            <pre>
            {
              "api_token": "<?php echo $api_token;?>",
              "title": "[title of the project]",
              "tags": "[comma separated list of tags]",
              "description": "[description of the project]",
              "js_code": "[JavaScript code]",
              "css_code": "[CSS code]",
              "readme": "[README file]",
              "libraries": "[comma separated list of libraries by their id]"
            }
            </pre>
            <h2>Rules</h2>
            <pre>
                <table>
                    <tr>
                    <th>Field</th>
                    <th>Required</th>
                    </tr>
                    <tr>
                    <td>api_token</td>
                    <td>Yes</td>
                    </tr>
                    <tr>
                    <td>title</td>
                    <td>Yes</td>
                    </tr>
                    <tr>
                    <td>tags</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>description</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>js_code</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>css_code</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>readme</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>libraries</td>
                    <td>No</td>
                    </tr>
                </table>
            </pre>
            <h2>Data example</h2>
            <pre>
            {
              "api_token": "<?php echo $api_token;?>",
              "title": "My New Project",
              "tags": "animation,art",
              "description": "This project sets the background to animals playing",
              "js_code": "raw js code",
              "css_code": "raw css code",
              "readme": "readme text",
              "libraries": "threejs,jquery"
            }
            </pre>
            <h2>Success Response</h2>
            <h3>Code</h3>
            <pre>200 OK</pre>
            <h3>Content example</h3>
            <pre>
            {
              "success": true,
              "message": "New Script Created!",
              "data": {
                "title": "[title]",
                "tags": "[tags]",
                "description": "[description]",
                "script_id": "unique_id",
                "js_code": "[JS code]",
                "css_code": "[CSS code]",
                "readme": "[README]",
                "libraries": "[libraries]",
                "timestamp": "2020-08-20 12:00:00",
                "version": "v1"
              }
            }
            </pre>
            <h2>Error Response</h2>
            <h3>Condition</h3>
            <pre>If the API token is invalid.</pre>
            <h3>Code</h3>
            <pre>400 BAD REQUEST</pre>
            <h3>Content</h3>
            <pre>
            {
              "success": false,
              "message": "Invalid API token"
            }
            </pre>
            <h2>Example Code in Different Languages</h2>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3"><a class="active" href="#js">JavaScript</a></li>
                        <li class="tab col s3"><a href="#php">PHP</a></li>
                        <li class="tab col s3"><a href="#python">Python</a></li>
                        <li class="tab col s3"><a href="#java">Java</a></li>
                    </ul>
                </div>
                
                <div id="js" class="col s12">
                    <textarea id="js-example" >
fetch('/api/create/', {
  method: 'POST',
  body: JSON.stringify({
    api_token: '<?php echo $api_token;?>',
    title: '[title of the project]',
    tags: '[comma separated list of tags]',
    description: '[description of the project]',
    js_code: '[JavaScript code]',
    css_code: '[CSS code]',
    readme: '[README file]'
  }),
  headers: {
    'Content-Type': 'application/json'
  }
})
.then(res => res.json())
.then(data => {
  if (data.success) {
    console.log('New Script Created!');
    console.log(data.data);
  } else {
    console.log('Error creating project');
    console.log(data.message);
  }
});
                    </textarea>
                </div>
                <div id="php" class="col s12">
                    <textarea id="php-example" >
 $data = array(
     'api_token' => '<?php echo $api_token;?>',
     'title' => '[title of the project]',
     'tags' => '[comma separated list of tags]',
     'description' => '[description of the project]',
     'js_code' => '[JavaScript code]',
     'css_code' => '[CSS code]',
     'readme' => '[README file]'
 );
  
 $payload = json_encode($data);
  
 $ch = curl_init('/api/create/');
 curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
 $result = curl_exec($ch);
 curl_close($ch);
  
 $data = json_decode($result, true);
  
 if ($data['success']) {
     echo 'New Script Created!';
     print_r($data['data']);
 } else {
     echo 'Error creating project';
     echo $data['message'];
 }
                    </textarea>
                </div>
                
                <div id="python" class="col s12">
                    <textarea id="python-example" >
import requests
import json

url = '/api/create/'


data = {
    'api_token': '<?php echo $api_token;?>',
    'title': 'My first project',
    'tags': 'example, project, first',
    'description': 'This is an example project',
    'js_code': 'console.log("Hello World!");',
    'css_code': 'body { background-color: red; }',
    'readme': 'My first project using the API'
}

response = requests.post(url,  data=json.dumps(data))

if response.status_code == 200:
   print(response.text)
else:
    print('Error calling API')
                    </textarea>
                </div>
                <div id="java" class="col s12">
                    <textarea id="java-example" >
import java.net.URL;
import java.net.HttpURLConnection;
import org.json.*;
 
String apiToken = "<?php echo $api_token;?>";
String title = "[title of the project]";
String tags = "[comma separated list of tags]";
String description = "[description of the project]";
String jsCode = "[JavaScript code]";
String cssCode = "[CSS code]";
String readme = "[README file]";
 
try {
    URL url = new URL("/api/create/");
    HttpURLConnection con = (HttpURLConnection) url.openConnection();
    con.setRequestMethod("POST");
 
    JSONObject body = new JSONObject();
    body.put("api_token", apiToken);
    body.put("title", title);
    body.put("tags", tags);
    body.put("description", description);
    body.put("js_code", jsCode);
    body.put("css_code", cssCode);
    body.put("readme", readme);
 
    con.setDoOutput(true);
    con.getOutputStream().write(body.toString().getBytes("UTF-8"));
 
    int responseCode = con.getResponseCode();
    if (responseCode == HttpURLConnection.HTTP_OK) {
        BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
        String inputLine;
        StringBuffer response = new StringBuffer();
        while ((inputLine = in.readLine()) != null) {
            response.append(inputLine);
        }
        in.close();
 
        JSONObject jsonObject = new JSONObject(response.toString());
        if (jsonObject.getBoolean("success")) {
            System.out.println("New Script Created!");
            System.out.println(jsonObject.getJSONObject("data"));
        } else {
            System.out.println("Error creating project");
            System.out.println(jsonObject.getString("message"));
        }
    } else {
        System.out.println("POST request not worked");
    }
} catch (Exception e) {
    System.out.println(e);
}
                    </textarea>
                </div>
            </div>
            
        </div>
        <div class="endpoint" id="get_projects">
            <h1>Get</h1>
            <p>This API allows users to get scripts.</p>
            <h2>URL</h2>
            <pre>/api/get_projects/</pre>
            <h2>Method</h2>
            <pre>GET</pre>
            <h2>Auth required</h2>
            <pre>Yes</pre>
            <h2>Data constraints</h2>
            <pre>
            {
              "api_token": "<?php echo $api_token;?>",
              "mode": "[0, 1, 2, 3]",
              "amount": "[amount of scripts]",
              "script_id": "[unique project id]"
            }
            </pre>
            <h2>Rules</h2>
            <pre>
            <table>
            <tr>
                <th>Rule</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>API Token</td>
                <td>The API token must be set in the request body.</td>
            </tr>
            <tr>
                <td>Mode</td>
                <td>The mode must be set in the request body. The mode can be 0, 1, 2, or 3.</td>
            </tr>
            <tr>
                <td>Amount</td>
                <td>The amount must be set in the request body when the mode is 0 or 1.</td>
            </tr>
            <tr>
                <td>Script ID</td>
                <td>The project ID must be set in the request body when the mode is 2.</td>
            </tr>
            </table>
            </pre>
            <h2>Mode Rules</h2>
            <pre style="text-align: center;">
            <table>
            <tr>
                <th>Mode</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>0</td>
                <td>Retrieves the specified number of scripts from the database.</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Retrieves the specified number of scripts from the database in descending order.</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Retrieves the specified project from the database.</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Retrieves all scripts from the database.</td>
            </tr>
            </table>
            </pre>
            <h2>Data example</h2>
            <pre>
            {
              "api_token": "<?php echo $api_token;?>",
              "mode": "[0, 1, 2, 3]",
              "amount": "[amount of scripts]",
              "script_id": "[unique project id]"
            }
            </pre>
            <h2>Success Response</h2>
            <h3>Code</h3>
            <pre>200 OK</pre>
            <h3>Content example</h3>
            <pre>
            {
              "success": true,
              "message": "Scripts Retrieved!",
              "data": [
                {
                  "title": "[title]",
                  "tags": "[tags]",
                  "description": "[description]",
                  "script_id": "unique_id",
                  "js_code": "[JS code]",
                  "css_code": "[CSS code]",
                  "readme": "[README]",
                  "timestamp": "2020-08-20 12:00:00",
                  "version": "v1"
                }
              ]
            }
            </pre>
            <h2>Error Response</h2>
            <h3>Condition</h3>
            <pre>If the API token is invalid.</pre>
            <h3>Code</h3>
            <pre>400 BAD REQUEST</pre>
            <h3>Content</h3>
            <pre>
            {
              "success": false,
              "message": "Invalid API token"
            }
            </pre>
            <h2>Example Code in Different Languages</h2>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs_get_projects">
                        <li class="tab col s3"><a class="active" href="#js_get_projects">JavaScript</a></li>
                        <li class="tab col s3"><a href="#php_get_projects">PHP</a></li>
                        <li class="tab col s3"><a href="#python_get_projects">Python</a></li>
                        <li class="tab col s3"><a href="#java_get_projects">Java</a></li>
                    </ul>
                </div>
                <div id="js_get_projects" class="col s12">
                    <textarea id="js-example_get_projects" >
// API token 
const token = '<?php echo $api_token;?>';

// API URL 
const url = '/api/get_projects/';

// Mode 0: Get the first 5 scripts 
const params0 = { api_token: token, mode: 0, amount: 5 };
fetch(url, {
  method: 'GET',
  params: params0
})
  .then(response => response.json())
  .then(data => {
    console.log('Mode 0:');
    console.log(data);
  });

// Mode 1: Get the last 5 scripts 
const params1 = { api_token: token, mode: 1, amount: 5 };
fetch(url, {
  method: 'GET',
  params: params1
})
  .then(response => response.json())
  .then(data => {
    console.log('Mode 1:');
    console.log(data);
  });

// Mode 2: Get a specific project 
const script_id = '12345';
const params2 = { api_token: token, mode: 2, script_id: script_id };
fetch(url, {
  method: 'GET',
  params: params2
})
  .then(response => response.json())
  .then(data => {
    console.log('Mode 2:');
    console.log(data);
  });

// Mode 3: Get all scripts 
const params3 = { api_token: token, mode: 3 };
fetch(url, {
  method: 'GET',
  params: params3
})
  .then(response => response.json())
  .then(data => {
    console.log('Mode 3:');
    console.log(data);
  });
                    </textarea>
                </div>
                <div id="php_get_projects" class="col s12">
                    <textarea id="php-example_get_projects" >
// API token 
$token = '<?php echo $api_token;?>';

// API URL 
$url = '/api/get_projects/';

// Mode 0: Get the first 5 scripts 
$params = array('api_token' => $token, 'mode' => 0, 'amount' => 5); 
$response = file_get_contents($url, false, stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($params)
    )
)));
echo 'Mode 0:'; 
echo $response;

// Mode 1: Get the last 5 scripts 
$params = array('api_token' => $token, 'mode' => 1, 'amount' => 5); 
$response = file_get_contents($url, false, stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($params)
    )
)));
echo 'Mode 1:'; 
echo $response;

// Mode 2: Get a specific project 
$script_id = '12345'; 
$params = array('api_token' => $token, 'mode' => 2, 'script_id' => $script_id); 
$response = file_get_contents($url, false, stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($params)
    )
)));
echo 'Mode 2:'; 
echo $response;

// Mode 3: Get all scripts 
$params = array('api_token' => $token, 'mode' => 3); 
$response = file_get_contents($url, false, stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($params)
    )
)));
echo 'Mode 3:'; 
echo $response;
                    </textarea>
                </div>
                
                <div id="python_get_projects" class="col s12">
                    <textarea id="python-example_get_projects" >
import requests 

# API token 
token = '<?php echo $api_token;?>'

# API URL 
url = '/api/get_projects/'

# Mode 0: Get the first 5 scripts 
params = {'api_token': token, 'mode': 0, 'amount': 5} 
response = requests.get(url, params=params) 
print('Mode 0:') 
print(response.json()) 

# Mode 1: Get the last 5 scripts 
params = {'api_token': token, 'mode': 1, 'amount': 5} 
response = requests.get(url, params=params) 
print('Mode 1:') 
print(response.json()) 

# Mode 2: Get a specific project 
script_id = '12345' 
params = {'api_token': token, 'mode': 2, 'script_id': script_id} 
response = requests.get(url, params=params) 
print('Mode 2:') 
print(response.json()) 

# Mode 3: Get all scripts 
params = {'api_token': token, 'mode': 3} 
response = requests.get(url, params=params) 
print('Mode 3:') 
print(response.json())
                    </textarea>
                </div>
                <div id="java_get_projects" class="col s12">
                    <textarea id="java-example_get_projects" >
import java.net.HttpURLConnection;
import java.net.URL;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.URLEncoder;

public class ApiRequest {

    public static void main(String[] args) {
        try {
            // API token
            String token = "<?php echo $api_token;?>";

            // API URL
            String url = "/api/get_projects/";

            // Mode 0: Get the first 5 scripts
            String params = "api_token=" + URLEncoder.encode(token, "UTF-8") + "&mode=0&amount=5";
            URL obj = new URL(url);
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("POST");
            con.setDoOutput(true);
            OutputStreamWriter outputStreamWriter = new OutputStreamWriter(con.getOutputStream());
            outputStreamWriter.write(params);
            outputStreamWriter.flush();
            BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
            String inputLine;
            StringBuffer response = new StringBuffer();
            while ((inputLine = in.readLine()) != null) {
                response.append(inputLine);
            }
            in.close();
            System.out.println("Mode 0:");
            System.out.println(response.toString());

            // Mode 1: Get the last 5 scripts
            params = "api_token=" + URLEncoder.encode(token, "UTF-8") + "&mode=1&amount=5";
            obj = new URL(url);
            con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("POST");
            con.setDoOutput(true);
            outputStreamWriter = new OutputStreamWriter(con.getOutputStream());
            outputStreamWriter.write(params);
            outputStreamWriter.flush();
            in = new BufferedReader(new InputStreamReader(con.getInputStream()));
            response = new StringBuffer();
            while ((inputLine = in.readLine()) != null) {
                response.append(inputLine);
            }
            in.close();
            System.out.println("Mode 1:");
            System.out.println(response.toString());

            // Mode 2: Get a specific project
            String script_id = "12345";
            params = "api_token=" + URLEncoder.encode(token, "UTF-8") + "&mode=2&script_id=" + URLEncoder.encode(script_id, "UTF-8");
            obj = new URL(url);
            con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("POST");
            con.setDoOutput(true);
            outputStreamWriter = new OutputStreamWriter(con.getOutputStream());
            outputStreamWriter.write(params);
            outputStreamWriter.flush();
            in = new BufferedReader(new InputStreamReader(con.getInputStream()));
            response = new StringBuffer();
            while ((inputLine = in.readLine()) != null) {
                response.append(inputLine);
            }
            in.close();
            System.out.println("Mode 2:");
            System.out.println(response.toString());

            // Mode 3: Get all scripts
            params = "api_token=" + URLEncoder.encode(token, "UTF-8") + "&mode=3";
            obj = new URL(url);
            con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("POST");
            con.setDoOutput(true);
            outputStreamWriter = new OutputStreamWriter(con.getOutputStream());
            outputStreamWriter.write(params);
            outputStreamWriter.flush();
            in = new BufferedReader(new InputStreamReader(con.getInputStream()));
            response = new StringBuffer();
            while ((inputLine = in.readLine()) != null) {
                response.append(inputLine);
            }
            in.close();
            System.out.println("Mode 3:");
            System.out.println(response.toString());
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
                    </textarea>
                </div>
            </div>
    </div>
    <div class="endpoint" id="edit_projects">
    <h1>Edit</h1>
    <p>This API endpoint allows users to edit their scripts.</p>
    <h2>URL</h2>
    <pre>/api/edit/</pre>
    <h2>HTTP Method</h2>
    <pre>POST</pre>
    <h2>Rules</h2>
            <pre>
                <table>
                    <tr>
                    <th>Field</th>
                    <th>Required</th>
                    </tr>
                    <tr>
                    <td>api_token</td>
                    <td>Yes</td>
                    </tr>
                    <tr>
                    <td>script_id</td>
                    <td>Yes</td>
                    </tr>
                    <tr>
                    <td>js_code</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>css_code</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>readme</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>title</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>description</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>tags</td>
                    <td>No</td>
                    </tr>
                    <tr>
                    <td>libraries</td>
                    <td>No</td>
                    </tr>
                </table>
            </pre>
    <h2>Data Examples</h2>
    <pre>
        {
            "api_token": "<?php echo $api_token;?>",
            "script_id": "58vd47",
            "js_code": "console.log('Hello World!');",
            "css_code": "body { background-color: #000; }",
            "readme": "This is a sample project.",
            "title": "Sample Script",
            "description": "This is a sample project.",
            "tags": "sample,project",
            "libraries": "jquery,bootstrap"
        }
    </pre>
    <h2>Success Response</h2>
    <h3>Code</h3>
    <pre>200 OK</pre>
    <h3>Content example</h3>
    <pre>
        {
            "success": true,
            "script_id": "58vd47",
            "version": "v1.01",
            "edited": true
        }
    </pre>
    <h2>Error Response</h2>
    <h3>Code</h3>
    <pre>400 BAD REQUEST</pre>
    <h3>Content</h3>
    <pre>
        {
            "success": false,
            "message": "Script ID is required"
        }
    </pre>
    <h2>Example Code in Different Languages</h2>
    <div class="row">
        <div class="col s12">
            <ul class="tabs_edit_projects">
                <li class="tab col s3"><a class="active" href="#js_edit_projects">JavaScript</a></li>
                <li class="tab col s3"><a href="#php_edit_projects">PHP</a></li>
                <li class="tab col s3"><a href="#python_edit_projects">Python</a></li>
                <li class="tab col s3"><a href="#java_edit_projects">Java</a></li>
            </ul>
        </div>
        <div id="js_edit_projects" class="col s12">
            <textarea id="js-example_edit_projects" > </textarea>
        </div>
        <div id="php_edit_projects" class="col s12">
            <textarea id="php-example_edit_projects" > </textarea>
        </div>
        <div id="python_edit_projects" class="col s12">
            <textarea id="python-example_edit_projects" > </textarea>
        </div>
        <div id="java_edit_projects" class="col s12">
            <textarea id="java-example_edit_projects" > </textarea>
        </div>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var jsExample = document.getElementById('js-example');
            var phpExample = document.getElementById('php-example');
            var pythonExample = document.getElementById('python-example');
            var javaExample = document.getElementById('java-example');
            var menuLinks = document.querySelectorAll('.menu a');
            var tabs = document.querySelectorAll('.tabs');

            var jsEditor = CodeMirror.fromTextArea(jsExample, {
                mode: 'javascript',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var phpEditor = CodeMirror.fromTextArea(phpExample, {
                mode: 'php',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var pythonEditor = CodeMirror.fromTextArea(pythonExample, {
                mode: 'python',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var javaEditor = CodeMirror.fromTextArea(javaExample, {
                mode: 'java',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });

            M.Tabs.init(tabs);

            for (var i = 0; i < menuLinks.length; i++) {
                menuLinks[i].addEventListener('click', function(e) {
                    e.preventDefault();
                    var href = this.getAttribute('href');
                    var top = document.querySelector(href).offsetTop;
                    window.scrollTo(0, top);
                });
            }

            //get_script
            var jsExample = document.getElementById('js-example_get_projects');
            var phpExample = document.getElementById('php-example_get_projects');
            var pythonExample = document.getElementById('python-example_get_projects');
            var javaExample = document.getElementById('java-example_get_projects');
            var menuLinks = document.querySelectorAll('.menu a');
            var tabs = document.querySelectorAll('.tabs_get_projects');

            var jsEditor = CodeMirror.fromTextArea(jsExample, {
                mode: 'javascript',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var phpEditor = CodeMirror.fromTextArea(phpExample, {
                mode: 'php',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var pythonEditor = CodeMirror.fromTextArea(pythonExample, {
                mode: 'python',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var javaEditor = CodeMirror.fromTextArea(javaExample, {
                mode: 'java',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });

            M.Tabs.init(tabs);

            for (var i = 0; i < menuLinks.length; i++) {
                menuLinks[i].addEventListener('click', function(e) {
                    e.preventDefault();
                    var href = this.getAttribute('href');
                    var top = document.querySelector(href).offsetTop;
                    window.scrollTo(0, top);
                });
            }
            
            //edit_projects
            var jsExample = document.getElementById('js-example_edit_projects');
            var phpExample = document.getElementById('php-example_edit_projects');
            var pythonExample = document.getElementById('python-example_edit_projects');
            var javaExample = document.getElementById('java-example_edit_projects');
            var menuLinks = document.querySelectorAll('.menu a');
            var tabs = document.querySelectorAll('.tabs_edit_projects');

            var jsEditor = CodeMirror.fromTextArea(jsExample, {
                mode: 'javascript',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var phpEditor = CodeMirror.fromTextArea(phpExample, {
                mode: 'php',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var pythonEditor = CodeMirror.fromTextArea(pythonExample, {
                mode: 'python',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });
            var javaEditor = CodeMirror.fromTextArea(javaExample, {
                mode: 'java',
                readOnly: true,
                tabSize: 4,
                lineNumbers: true
            });

            M.Tabs.init(tabs);

            for (var i = 0; i < menuLinks.length; i++) {
                menuLinks[i].addEventListener('click', function(e) {
                    e.preventDefault();
                    var href = this.getAttribute('href');
                    var top = document.querySelector(href).offsetTop;
                    window.scrollTo(0, top);
                });
            }
        });
    </script>
     </div>




</body>
</html>
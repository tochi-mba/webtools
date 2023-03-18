
<HTML>
	<head>
		<title>Personalised Script Head Code</title>
		
		<style>
			.container { 
				width: 100%; 
				height: 100%; 
				background-color: rgba(0, 0, 0, 0.8); 
				position: relative;
			}
			.content-wrapper { 
				position: absolute; 
				top: 50%; 
				left: 50%;
				transform: translate(-50%, -50%); 
				background-color: white; 
				padding: 5%;
				max-width: 500px;
				text-align: center;
		
				-webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
				-moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
				box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
			}
			.code {
				margin-top: 3%; 
				margin-left: 6%;
				margin-right: 6%;
				font-family: monospace;
				background-color: transparent;
				border: none;
				color: gray;
				padding: 10px;
			}
			.code:hover {
				background-color: rgba(0, 0, 0, 0.2);
				cursor: copy;
			}
			.code:focus {
				background-color: rgba(0, 0, 0, 0.2);
				outline: none;
			}
			@media only screen and (max-width: 890px) {
    			.code {
      				margin: 0 auto;
    			}
  			}
			.instructions {
				margin-top: 3%;
				margin-bottom: 3%;
				font-family: sans-serif;
				text-align: center;
				color: #333333;
			}
			.copy-btn {
				border: none;
				background-color: transparent;
				cursor: pointer;
				margin-top: 3%;
				color: gray;
				transition: all ease 0.3s;
			}
			.copy-btn:hover {
				color: black;
				background-color: rgba(0, 0, 0, 0.2);
			}
			.copy-message {
				margin-top: 3%;
				font-family: sans-serif;
				color: gray;
				transition: all ease 0.3s;
			}
			.copy-message.show {
				opacity: 1;
			}
			.copy-message.hide {
				opacity: 0;
			}
			.souce-wrapper {
				position: relative;
				margin-top: 3%;
				transition: all ease 0.3s;
				opacity: 0;
			}
			.souce-wrapper.show {
				opacity: 1;
			}
			.souce-wrapper.hide {
				opacity: 0;
			}
			.souce {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				border-radius: 6px;
				background-color: rgba(0, 0, 0, 0.2);
				padding: 4%;
				color: #333333;
				text-align: center;
				cursor: move;
				overflow: hidden;
			}
		</style>	
	</head>
	<body>
		<div class="container">
			<div class="content-wrapper">
				<div class="instructions">
					Copy the script below and insert it into the <b>&lt;head&gt;</b> section of your code.
				</div>
				<textarea class="code" readonly>
				<?php 
		
				function extractSearchParams($script) {
					preg_match_all("/queryURL\.searchParams\.get\('(.+?)'\)/", $script, $matches);
					$params = $matches[1];
					return $params;
				}
				
				
				$script=file_get_contents("./scripts/".$_POST["user"]."/".$_POST["script_id"].".js");
				$params=extractSearchParams($script) ;	
				$parStr="";
				for ($i=0; $i < sizeof($params); $i++) { 
					$parStr=$parStr."&".$params[$i]."=<".$params[$i].">";
				}

				?>
				<script src="./webtools?id=<?php echo $_POST["script_id"]?>&u=<?php echo $_POST["user"]; echo $parStr;?>"></script>
				</textarea>
				<button class="copy-btn" onclick="copyScript()">Copy Script</button>
				<div class="copy-message hide">Code copied!</div>
				<div class="souce-wrapper hide">
					<div class="souce">Template Filler Script Code</div>
				</div>
			</div>
		</div>
		
	</body>
	<script>
		function copyScript() {
			let _code = document.querySelector('.code');
			_code.select();
			document.execCommand('copy');
			
			document.querySelector('.copy-message').classList.remove('hide');
			document.querySelector('.copy-message').classList.add('show');
			
			document.querySelector('.souce-wrapper').classList.remove('hide');
			document.querySelector('.souce-wrapper').classList.add('show');
		}
		
		let _souce = document.querySelector('.souce');
		let initX = 0;
		let initY = 0;
		let x = 0;
		let y = 0;
	
		_souce.addEventListener('mousedown', (e) => {
			initX = e.clientX;
			initY = e.clientY;
		});
	
		_souce.addEventListener('mouseup', (e) => {
			initX = 0;
			initY = 0;
			x = 0;
			y = 0;
		});
		
		_souce.addEventListener('mouseenter', (e) => {
			document.body.style.cursor = 'move';
		});
		
		_souce.addEventListener('mouseout', (e) => {
			document.body.style.cursor = 'auto';
		});
		
		_souce.addEventListener('mousemove', (e) => {
			if(initX === 0){
			  x = 0;
			  y = 0;
			}
			else {
			  x = e.clientX - initX;
			  y = e.clientY - initY;
			}
			
			_souce.style.left = `calc(50% + ${x}px)`;
			_souce.style.top = `calc(50% + ${y}px)`;
		});
	</script>
</html>
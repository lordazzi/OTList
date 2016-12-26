<html>
	<head>
		<title>OT List CMD</title>
		
		<style type="text/css">
			body {
				margin: 0px;
				padding: 30px;
				background-color: #000;
				font-family: arial;
				color: #009900;
			}
			
			p {
				margin: 5px 0px;
				color: #00FF00;
			}
			
			p.online {
				color: #00FF00;
			}
			
			p.timeout {
				color: #CCFF00;
			}
			
			p.offline {
				color: #FF3300;
			}
			
			p.limit {
				color: #EAEAEA;
			}
			
			p.weoff {
				color: #FF0000;
			}
			
			p.msg {
				padding: 5px;
				background-color: #333333;
				font-size: 8px;
			}
			
			button {
				background-color: #FFF;
				font-family: arial black;
			}
			
			#pingall {
				position: absolute;
				right: 5px;
				bottom: 5px;
				height: 30px;
				width: 100px;
				background-color: #FFF;
				font-family: arial black;
				cursor: pointer;
			}
			
			#reload {
				position: absolute;
				right: 5px;
				top: 5px;
				height: 30px;
				width: 100px;
				background-color: #FFF;
				font-family: arial black;
				cursor: pointer;
			}
		</style>
		
		<script type="text/javascript" src="../plugins/js/jquery-1.7.2.js"></script>
		<script type="text/javascript">
			$(function(){
				$("#pingall").on("click", function(){
					$.ajax({
						url: "post/do-listservers.php",
						success: function(retorno) {
							eval("retorno = "+retorno);
							ping(retorno.servers, 0, 0);
						}
					});
				});
				
				$("#reload").on("click", function(){
					$.ajax({
						url: "post/do-reload.php"
					});
				});
			});
			
			var codeClass = (function(code){
				switch(code) {
					case 200:
						return "online"
						break;
						
					case 404:
						return "offline";
						break;
						
					case 408:
						return "timeout";
						break;
					
					case 403:
						return "limit";
						break;
						
					case 304:
						return "weoff"
						break;
				}
			});
			
			var current = (function(){
				var data = new Date();
				return data.getDate()+"/"+data.getMonth()+"/"+data.getFullYear()+" "+data.getHours()+":"+data.getMinutes()+":"+data.getSeconds();
			});
			
			var ping = (function(servers, i, time) {
				setTimeout(function(){
					$("<p>Connecting to "+servers[i].txtip+"...</p>").appendTo("body");
					$.ajax({
						type: "POST",
						url: "post/do-pingserver.php",
						data: {
							idserver: servers[i].idserver,
							port: servers[i].nrport,
							ip: servers[i].txtip,
							motd: servers[i].txtmotd
						},
						success: function(retorno){
							eval("json = "+retorno);
							$("<p class='"+codeClass(json.code)+"'> [ "+json.code+" ] "+json.msg+"...</p><br />").appendTo("body");
							window.scrollTo(0, document.height);
							if (i != servers.length) {
								i++;
								ping(servers, i, 10000);
							}
						}
					});
				}, time);
			});
			
			
		</script>
	</head>
	<body>
		<button id="reload">RELOAD</button>
		<button id="pingall">PING ALL</button>
	</body>
</html>
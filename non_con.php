<!DOCTYPE html>
<html>
<head>
	<title>For Design Purpose</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style type="text/css">
		html{
			height: 100%;
			background: radial-gradient(rgb(255,255,255),rgb(0,0,0));
		}
		.tree-space{
			height: 500px;
			left: 30%;
			transform: scaleY(1.5);
			position:absolute;
			border-bottom: 1px solid black;
		}
		.header{
			position: absolute;
			font-family: inherit;
			font-size: larger;
			color: white;
			font-size: 5rem;
			top:70%;
			right: 20%;
			transform: rotate3d(60deg,0,0);
			text-shadow: 40px 40px 8px black;

		}
		
		<?php 
		$out='';
			for ($i=1; $i <20 ; $i++) { 
				$x=rand(400,800);
				$y=rand(200,400);
				$ground=600;
				$out.='
				#leaf'.$i.'{
				filter: blur('.rand(0,1).'px);
				width: '.rand(20,50).'px;
				height: '.rand(20,50).'px;
				position: absolute;
				animation: leaf'.$i.' '.rand(5,20).'s ease-in infinite;
			}
			@keyframes leaf'.$i.'{
				from{transform: translate('.$x.'px,'.$y.'px) rotate(0deg);}
				to{transform: translate('.($x+rand(-250,250)).'px,'.$ground.'px) rotate('.rand(-360,360).'deg);}
			} ';
			}
		echo $out;
		?>

	</style>
</head>
<body>
	<div id="container">
		<h2 class="header">Save Trees</h2>
		<img class="tree-space" id="tree" src="img/tree-png-6408.png">
		<?php $out='';
			for ($i=1; $i <20 ; $i++) { 
				$out.='<img class="leaves" id="leaf'.$i.'" src="img/yellowleaf.png">';
			}
			echo $out;
		?>
		<img class="tree-space" id="tree" src="img/tree-png-6408.png">
		<input type="text" id="key"/>
	</div>
	<script>
		$(document).ready(function(){
			$('#key').keyup(function(){
				var txt = $(this).val();
				if(txt!=''){
				$('.header').css("color","rgb(255,0,255)");
				document.getElementById("container").style.backgroundColor = "red";
			}
			});
		});
		
	</script>
</body>
</html>
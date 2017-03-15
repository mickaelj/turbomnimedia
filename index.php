<?php
	error_reporting (E_ALL & ~E_NOTICE);
	// config file	
	include('config.php');
	// array list
	$list=[];	
	
	// make array
	$i=0;
	$file=$_REQUEST["id"];
	if ( file_exists($file)){

		$lines=file($file);
		foreach ($lines as $line_num => $line) {
			$list[]=$line ;
			$i++;
			
		}

		$maxpage=$i;
		$arraypages=$list;
	}else{
		echo"<b><center>Error : no comic file given</center></b>";
		echo"<center>List :<center>";
		$dh  = opendir($pages_dir);
		while (false !== ($filename = readdir($dh))) {
			if( $filename != '.' && $filename != '..') {
           			echo "[ <a href=?id=". $filename.">".$filename."</a> ]";
           		}
		}
		die();
	}
	$dir=$pages_dir."/".$file;
?>

<!DOCTYPE html>

<html>	
	<head>
		


		<?php
			$mycss=$dir."/".$file.".css";
			if ( file_exists($mycss)){
				echo '
				<link rel="stylesheet" media="screen" type="text/css" title="'.$file.'" href="'.$mycss.'"/>
				';				
			}else{
				echo '
				<link rel="stylesheet" media="screen" type="text/css" title="default" href="css/default.css"/>
				';
}
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		
		<script>

			function clear(){
				$(".page").each(function(){
					var i=(this).id;
					//document.write(i);
					$("#"+i).hide();					
				});
			}

			function start(){
				clear();
				$("#page1").show();
				 page=1;
			}

			


			function nav(type){

				switch (type) {
					case "prev":
						if(page>1){
							page=page -1;
							clear();					
							$("#page"+page).show();
						}
					break;

					case "next":
						if(page<<?php echo $maxpage; ?>){
							page=page +1;
							clear();					
							$("#page"+page).show();
						}else{
							start();						
						}
					break;

					case "end":
						clear();
						page=<?php echo $maxpage; ?>;
						$("#page"+page).show();
					break;


				}					
			}			
			
			var page = 0;
			var pages_dir="<?php echo $pages_dir; ?>";


			
			$(document).ready(function(){


				$("body").on("keydown", function(e){
				    if(e.keyCode === 37) {
					nav("prev");
				    }
				    if(e.keyCode === 38) {
					start();
				    }
				    if(e.keyCode === 39) {
					nav("next");
				    }
				    if(e.keyCode === 40) {
					nav("end");
				    }
				    if(e.keyCode === 72) {				    
					$("#help").toggle();		
				    }
				 });

				start();
				
				$("#start").click(function(){
					start();
				});

				$("#prev").click(function(){
					nav("prev");
				});
				
				$("#next").click(function(){
					nav("next");
				});

				$("#end").click(function(){
					nav("end");
				});
			});


		</script>

		
		
	</head>


	<div id="nav" style="align:center">
		<b>Title : <?php echo $file; ?>. Total pages : <?php echo $maxpage; ?><b><br/>
		<span class="navbutton" id="start"><img src="<?php echo $first_ico; ?>" /></span>  
		<span class="navbutton" id="prev"> <img src="<?php echo $prev_ico;  ?>"/></span>
		<span class="navbutton" id="next"> <img src="<?php echo $next_ico; ?>"/></span>
		<span class="navbutton" id="end">  <img src="<?php echo $end_ico;   ?>"/></span>
	</div>

	<div id="help">
	<h2> Help !</h2>
	<h3> Keys :</h3>
	h : this help <br/>
	key up : start page</br>
	key left : previous page </br>	
	key right : next page </br>
	key down : last page</br>
	<h3>Custom CSS</h3>
	Create your own CSS file in your comic folder and name it with the same name with .CSS extension. If exist, this CSS will be prioritary
 
	</div>


	<div class="comic">
	
	<?php


		$page=0;
		foreach ($arraypages as $inc){
		$page++;
		$f=explode("|",$inc);
		$name = trim($f[1]);
		$type = trim($f[0]);

		switch ($type) {

			case "img":
				$src="<img class='img embed' src='".$dir."/".$name."' id='cont".$page."' />";
				break;

			case "url":
				$src="<embed class='url embed' src='".$name."' id='cont".$page."' />";
				break;
		}
			
		echo "<div class='page' id='page".$page."'>";	
		echo $src;

		echo "</div>";

		}
		
							
	?>
	</div>
	<div>

	</div>
	</body>

</html>

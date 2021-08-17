<?php
// Current sheet ID: https://docs.google.com/spreadsheets/d/1xt7IxIKmfIqaFuZ9Yez9-wkZYekRETwCXHTti6xup9U/edit#gid=0
function gs_form_shortcode() {
	ob_start();
	$google_sheet_id = '1xt7IxIKmfIqaFuZ9Yez9-wkZYekRETwCXHTti6xup9U';   // Google sheet ID, where we want to save our form entries.
	
	$api_apispreadsheet_id = "16507";    // API spreadsheet ID, we can upload our googleshhet here(https://www.apispreadsheets.com/) to get spreadsheet ID.
	?> 
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"> </script>
	<script>
	function SubForm (){
		var apiId = $('#api_id').html();
		var elem = document.getElementById("first_name");
		var pattern = elem.getAttribute("pattern");
		var re = new RegExp(pattern);
		var eleml = document.getElementById("last_name");
		var patternl = eleml.getAttribute("pattern");
		var rel = new RegExp(patternl);
		var email = document.getElementById("email");
		var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
		if (!re.test(elem.value)) {
		}
		else if (!rel.test(eleml.value)) {
		}
		else if (!email.value.match(validRegex)) {
		} 
		else{
		  var signcounter = document.getElementById("sign_counter").value;	
		  var signincremnt = Number(signcounter) + 1;
		  $("#sign_counter").val(signincremnt);	
		  var lacation = document.getElementById("lacation").value; 
		  if(lacation == ""){
				$("#lacation").val('NIL');
		  }
		  setTimeout(function(){
			$('#submit').html('SIGNING...');
		  }, 600);
		  setTimeout(function(){
			$('#submit').html('THANK YOU!');
		  }, 900);
		   $.ajax({
			url:'https://api.apispreadsheets.com/data/'+apiId,
			type:'post',
			data:$("#myForm").serializeArray(),
			success: function(){
			}
			,
			error: function(){
			  alert("There was an error :(")
			}
		  });   
		}
	}
	</script>
	<style>
		.gs_form{
			background: #ccc;
			padding: 29px;
		}
		.gs_form input[type="text"], .gs_form input[type="email"] {
			width: 100%;
			height: 30px;
			padding-left: 15px;
			border: unset;
			border-radius: 10px;
		}
		.gs_form h1 {
			font-size: 25px;
			margin: 0;
		}
		.gs_form input[type="checkbox"] {
			margin: 20px 0;
			height: ;
		}
		.gs_form  button {
			width: 100%;
			padding: 13px;
			font-size: 25px;
			cursor: pointer;
			background: #fff;
		}
		p.name_include {
			text-transform: capitalize;
			font-size: 16px;
		}
		span.timestamp {
			font-size: 14px;
			float: right;
			padding-right: 80px;
		}
		.guard{
			text-align:center;
		}
		button#submit:hover {
			opacity: 0.8;
		}
		.gs_form label {
			cursor: pointer;
		}
		.gs_main_wrap {
			margin: 25px 15px;
		}
		.gs_form label {
			line-height: 14px !important;
			font-size: 14px;
		}
		.gs_form input[type="checkbox"] {
			margin: 20px 0 22px;
			margin-right: 5px;
			position: relative;
			top: 1px;
		}
		input#first_name {
			width: 49%;
			float: left;
			margin-right: 1%;
		}
		input#last_name {
			width: 49%;
			float: right;
			margin-left: 1%;
		}
	</style>
	<?php $date = date("m/d/Y"); ?>
	<div class="gs_main_wrap">
		<div class="gs_form">
			<form id="myForm" method ="post">
			   <p id="api_id" style="display:none"><?php echo $api_apispreadsheet_id; ?> </p>
			   <input name="counter" id = "sign_counter" value="" type="hidden">
			   <h1>Add Your Name</h1>    
			   <br/>
			   <input id="first_name" type="text" name="first_name" placeholder="Your First Name*" required pattern="^\S+$"/>
			   <input type="text" id="last_name" name="last_name" placeholder="Your Last Name*" required pattern="^\S+$"/>
			   <br/>
			   <br/>
			   <br/>
			   <input type="email" id="email" name="email" placeholder="Your Email Address*" required />
			   <br/>
			   <br/>
			   <input type="text" id = "lacation" name="location" placeholder="Your state, province or country" />
			   <br/>
			   <input name="timestamp" value="<?php echo $date; ?>" type="hidden">
			   <label><input type="checkbox" id= "include_name" name="acknowledgement" value="true" checked>
			   Display my first name and first initial of last name below 
			   </label> 
			   <br/>
			   <button id="submit" onclick="SubForm()">SIGN THE PLEDGE!</button>
			</form>
		</div>  
		<p class="guard"> We Will guard your privacy like  our own.</p>
		<div class="gs_form">

			<?php
			$file =
				 "https://spreadsheets.google.com/feeds/list/" .
				 $google_sheet_id .
				 "/od6/public/basic?alt=json";
			$result = file_get_contents($file);
			$arr = json_decode($result, true);
			$data = $arr["feed"]["entry"];
			$counterdata = $arr["feed"]["entry"];
			foreach ($counterdata as $count) {	
				$countersign = $count["title"]['$t'];	
			}
			echo '<script> $("#sign_counter").val('.$countersign.'); </script>' ;
			echo '<h1>'.number_format($countersign).' signatures so far </h1>';
			krsort($data);
			$i = 1;
			
			foreach ($data as $list) {
				$str = $list["content"]['$t'];
				$array = explode(",", $str);
				$fnamearr = explode(":", $array[0]);
				$lnamearr = explode(":", $array[1]);
				$emailarr = explode(":", $array[2]);
				$locationarr = explode(":", $array[3]);
				$timearr = explode(":", $array[4]);
				$includearr = explode(":", $array[5]);
				if (!empty($includearr[1])) {
					echo '<p class="name_include"> ';
					echo '<span class="fname">' . $fnamearr[1] . "</span>";
					$lname = $lnamearr[1];
					$lnamei = substr($lname, 0, 2);
					$location =trim($locationarr[1]);
					echo '<span class="lname">' . $lnamei . "</span>";
					if($location == "NIL"){
						echo '<span class="locname"></span>';
					}else{
						echo '<span class="locname">,' . $locationarr[1] . "</span>";
					}						 
					$date = date("m/d/Y");
					$yesterday = date(
						"m/d/Y",
						mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"))
					);
					if (trim($timearr[1]) == $date) {
						echo '<span class="timestamp">Today</span>';
					} elseif (trim($timearr[1]) == $yesterday) {
						echo '<span class="timestamp">Yesterday</span>';
					} else {
						echo '<span class="timestamp">' . $timearr[1] . "</span>";
					}
					echo "</p>";
					if ($i++ == 10) {
						break;
					}
				}
			}
			?>   
		</div>
	</div>	
	<?php 
	return ob_get_clean();
}
add_shortcode('pledge_form', 'gs_form_shortcode'); 

include('wp-load.php');
echo do_shortcode('[pledge_form]'); 
?>
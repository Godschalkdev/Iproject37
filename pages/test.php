
<?php
$valid_file = true;
$max_file_size = 2024000;
$valid_formats = array("jpg","jpeg","JPG", "png", "gif", "bmp");



for($i=0; $i < 4; $i++){

if(isset($_FILES['photo']['name'][$i]))
{
	

	if(!$_FILES['photo']['error'][$i])
	{
		
		$new_file_name = strtolower($_FILES['photo']['name'][$i]);
		$ext = pathinfo($_FILES['photo']['name'][$i], PATHINFO_EXTENSION); 

		if($_FILES['photo']['size'][$i] > $max_file_size )
		{
			$valid_file = false;
			$msg = 'Oops!  Je bestand is te groot';
		}

		elseif(!in_array($ext, $valid_formats)){
			$valid_file = false; 
			$msg = 'Oops! geen geldige bestand';
		}
		
		//if the file has passed the test
		elseif($valid_file)
		{	
			
			
			
			$uniq_file_name = getGeneratedFilename($_FILES['photo']['name'][$i]);
			//move it to where we want it to be
			move_uploaded_file($_FILES['photo']['tmp_name'][$i], "..\uploads\ ".$uniq_file_name);
			
			$msg = 'WAT MOOI!  HET IS GELUKT.';

			
		}
	
	//if there is an error...
	}
		else
	{
		//set that to be the returned msg
		$msg = 'Ooops!  DAT GING FOUT:  '.$_FILES['photo']['error'][$i];
	}

}
}



function getGeneratedFilename($name){
$uniq = base_convert(uniqid(), 16, 10);
$newName = $uniq."_".$name;
return $newName;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>TESTPAGE</title>

</head>
<body>

	<?php
//Show message
if(isset($msg)){
	echo "<h3 style=\"color:red\">{".$msg."}</h3>\n";
}
?>

<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" enctype="multipart/form-data" >
	Your Photo: <input type="file" name="photo[]" size="25" multiple="multiple"  />
	<input type="submit" name="submit" value="Submit" />
</form>



</body>

</html>
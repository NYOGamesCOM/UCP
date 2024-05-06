<?php
include_once(muie.php);
 
if(isset($_POST['submit'])) 
{
	$nume = $_POST['nume'];
	$desc = $_POST['desc'];
	$numeins = ("INSERT INTO 'narcis' (nume_locatie, descriere) VALUES ('$nume, $desc')");
	mysql_query($numeins);
}
?>
<form method='post'>
<input placeholder="numele locatiei" id="nume" name="nume" type="text">
<input placeholder="descrierea" id="desc" name="desc" type="text">

<input type="submit" value="Register" />
</form>
<?php  
		session_start();
		
		$dept=$_GET['dept'];
	$_SESSION['dept']=$dept;


		$dbc=mysql_connect("localhost","root","");
	
		if(!$dbc)	die('could not connect');		
	
		mysql_select_db("feedback",$dbc);


?>

<form action="archive/createArchive.php" method="post" target="content">
<?php if(isset($_POST['par_id']))	$par_id=$_POST['par_id'];
?>
<?php 
	$query="SELECT * FROM parent_fb";

	$result=mysql_query($query,$dbc);

$par_id="----";




if(isset($_REQUEST['par_id']))	
{
	$par_id=$_REQUEST['par_id'];
}?>
<style>	body { background-color: #404040 } </style>

	<h2 style="text-align:center; color:#DDFF0D ">
		
		<label for=''>SELECT FEEDBACK :</label>

<select name="par_id" style="color:black; border:1px solid yellow; font-family:Impact; font-size:15; background-color:white" onchange="this.form.submit();" >
		
		<option value="----">----</option>		
 
	<?php while($temp=mysql_fetch_array($result))
		{?>
			<option value="<?php  echo $_SESSION['par_id']=$temp['par_id'];?>"><?php  echo $temp['par_id'];?></option>
			<?php $_POST['par_id']=$_SESSION['par_id'];?>
			
		<?php }
			

	?>	
		  
		</select>
	</h2>



<html>

<head>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical1.css" rel="stylesheet" type="text/css">
</head>





<!--------------------------COLLEGE------------------------------------------------------------>

<br/><br/><br/>





<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var MenuBar3 = new Spry.Widget.MenuBar("MenuBar3", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var MenuBar4 = new Spry.Widget.MenuBar("MenuBar4", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>


</html>


</form>

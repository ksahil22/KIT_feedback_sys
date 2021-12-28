<?php 
error_reporting("E_ERROR");
session_start();
$dept=$_SESSION['dept'];
$prevelage=$_SESSION['prev'];
$dbc=mysqli_connect("localhost","inhouse_user","user_kit");
if(!$dbc)
{	
die('could not connect');		
}
mysqli_select_db($dbc,"feedback");
if($prevelage=='verifiedteacher'||$prevelage=='verifiedhod')
{
	$query="SELECT * FROM department where dept_id='$dept'";
}
else
{
	$query="SELECT * FROM department ";
}
$result=mysqli_query($dbc,$query);
//----------------------------------------------
if(isset($_POST['dept_id']))     { $dept_id = $_POST['dept_id']; }
if(isset($_POST['creat']))
{
		$dept_id=$_POST['dept_id'];

		$f_name=$_POST['f_name'];

		$m_name=$_POST['m_name'];

		$l_name=$_POST['l_name'];

		

		if($dept_id=="----" || $f_name=="" || $m_name =="" ||$l_name =="" || $_POST['fac_id'] =="")  
		{
			?><font color="red" size="5" family="Times New Roman" > error msg : somthing missing</font><?php 
		}
		else
		{

		$ws="_";
/*		echo "<script>
			alert('$dept_id');
			</script>";*/
		$fac_id=$dept_id.$ws.$_POST['fac_id'];
		
		//echo "f ".$f_name."  m  ".$m_name." l ".$l_name."  id ".$fac_id;

		//echo "FACULTY : ".$fac_id;
		
		?><font color="white" size="5" family="Times New Roman" ><?php 



		$query="INSERT INTO faculty VALUES('$fac_id','$f_name','$m_name','$l_name','$dept_id','valid','$f_name','$l_name','','','')";  
	
		if(!mysqli_query($dbc, $query)){ echo "Fac id alredy present with same initials";}
		else
		{

		$fac_name=explode('_',$fac_id);
		$f_id=$fac_name[1]."_".$fac_name[2];
		$f_id=mb_strtolower($f_id);
		$pass=md5('temporary');

		$result=mysqli_query($dbc, "INSERT INTO user(fname,mname,lname,dept,designation,user_name,password,previlage,status) VALUES('$f_name','$m_name','$l_name','$dept_id','Asist Prof','$f_id','$pass','verifiedfaculty','verified')");

		//$query="INSERT INTO user ('user_name','fname','mname','lname','dept','designation','previlage','password')VALUES('$f_id','$f_name','$m_name','$l_name','$dept_id','Assit prof','verifiedfaculty',md5('temporary'))";  
		mysqli_query($dbc, $query);
			?></font><?php 

		?>
		<br/><br/><br/>

		<p style="word-spacing:0.4em; color:black; text-align:center; font-family:Times New Roman; font-size:20; ">

		FACULTY    <font color="black"> <?php echo $fac_id;?></font>     ADDED SUCSESSFULLY
		</p>
			 
		<?php 	
		
		}	
		}
	}//if
	else
	{
	
	//----------------------------------------------
?>



		<form action="" method="post" name="add_faculty" onsubmit="return validateForm()">

<p style="word-spacing:0.4em; color:navy; text-align:center; font-family:Times New Roman; font-size:22; ">
		
		SELECT DEPARTMENT

		<select style="color:black;  border:3px solid black; font-family:Times New Roman; font-size:18; background-color:#B28647" name="dept_id" onchange="this.form.submit();">
		<!--select style="color:black;  border:3px solid black; font-family:Times New Roman; font-size:18; background-color:#B28647" name="dept_id" -->

		<option value=" ">----</option>

	<?php 
		while($temp=mysqli_fetch_array($result))
		{

			if($temp['dept_id']==$dept_id)
			{
			?>
		
			<option style="color:lime;  font-family:Times New Roman; font-size:20; background-color:black" value="<?php  echo $temp['dept_id'];?>" selected='selected'><?php  echo $temp['dept_id'];?></option>
			<?php 
			}
			else
			{
			?>
			 <option value="<?php  echo $temp['dept_id'];?>"><?php  echo $temp['dept_id'];?></option>
			<?php 
			}
		}
	?>
		  
		</select>
    
  </p><br>





<?php 
	if(isset($_POST['dept_id']))
	{
	$dept_id=$_POST['dept_id'];
	?>
<!--
echo "<input name='dept_id' style='color:black; border:3px solid black; font-family:Times New Roman; font-size:18; background-color:white' type='text' value='$dept_id'/>";

-->

<p style="word-spacing:0.4em; color:navy; text-align:center; font-family:Times New Roman; font-size:22; ">

	FIRST NAME

<input name="f_name" style="color:black;  border:3px solid black; font-family:Times New Roman; font-size:18; background-color:#B28647" type="text" value=" "/>
  
</p>

<!--------------------------------------------------------------------------------------------------------------->


<p style="word-spacing:0.4em; color:navy; text-align:center; font-family:Times New Roman; font-size:22; ">
 
	MIDDLE NAME 

 <input type="text" style="color:black;  border:3px solid black; font-family:Times New Roman; font-size:18; background-color:#B28647" name="m_name" value=" "/>
  
</p>

<!--------------------------------------------------------------------------------------------------------------->


<p style="word-spacing:0.4em; color:navy; text-align:center; font-family:Times New Roman; font-size:22; ">

	LAST NAME 

 <input type="text" style="color:black;  border:3px solid black; font-family:Times New Roman; font-size:18; background-color:#B28647" name="l_name" value=" "/>
 
</p>


<!--------------------------------------------------------------------------------------------------------------->


<p style="word-spacing:0.4em; color:navy; text-align:center; font-family:Times New Roman; font-size:22; ">

	FACULTY ID

  		<input type="text" style="color:black;  border:3px solid black; font-family:Times New Roman; font-size:18; background-color:#B28647" type="text" name="fac_id" /><br>
	<label s tyle="color:red">(E.g.:Faculty:- Abhijit Dyanoba Jagtap, Faculty ID:ADJ )</label><br>
	<label s tyle="color:red">( Do not use <i>single quote, double quote </i>or<i> space</i> in names )</label>
	
 
</p>


<!------------------------------------------------------------------------------------------------------------------>




<br/>

<p style="word-spacing:4.0em; color:lime; text-align:center; font-family:Times New Roman; font-size:30;">

<input type="submit" style="color:red;  border:3px solid brown; font-family:Times New Roman; font-size:30; background-color: black" name="creat" value="Add">

</p>


<?php 
	}
?>


</form>


<?php 
	}							//end of else
?>
<style>	body { background-color: #B0B0B0 } </style>
<script type="text/javascript">
function validateForm() {
    var x = document.forms["add_faculty"]["fac_id"].value;
    if (x == null || x == "") {
        alert(x);
        return true;
    }
    if(x.indexOf(" ")>=0 || x.indexOf("_")>=0)	{
    	alert("Please remove any spaces(' ') and underscores('_') in the field FACULTY_ID");
	    return false;
    }
}
</script>

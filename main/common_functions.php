<?php  
//fetches the user"s row from the teachnonteach table
//session_start();
//require("config.php");
/*$usn=$_SESSION["username"];



$sql="SELECT * FROM teachnonteach WHERE username="$usn"";
/*
$sql = "SELECT privileges,status,firstname,father_name,lastname,mother_name,aicte_id,DTE_id,SU_id,permanent_addr,correspondence_addr,dateofbirth,religion,caste,PAN_no,Aadhar_no,landline_no,mobile,fax,email
FROM teaching WHERE username="$usn"";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
i//echo "connected successfully";*/
function dept_longform($dept_abbr)
{
if ($dept_abbr=="BIO") return "BIOTECHNOLOGY ENGG";
elseif ($dept_abbr=="CIVIL") return "CIVIL ENGG";
elseif ($dept_abbr=="CSE(AIML-DS)") return "COMP SCI & ENGG(AIML-DS)";
elseif ($dept_abbr=="CSE") return "COMPUTER SCIENCE & ENGG";
elseif ($dept_abbr=="ELE") return "ELECTRICAL ENGG";
elseif ($dept_abbr=="ELN") return "ELECTRONICS ENGG";
elseif ($dept_abbr=="ENV") return "ENVIRONMENTAL ENGG";
elseif ($dept_abbr=="ENTC") return "ELECTRONICS & TELECOMM ENGG";
elseif ($dept_abbr=="BSH") return "BASIC SCIENCES & HUMANITIES";
elseif ($dept_abbr=="IT") return "INFORMATION TECHNOLOGY";
elseif ($dept_abbr=="MECH") return "MECHANICAL ENGG";
elseif ($dept_abbr=="PROD") return "PRODUCTION ENGG";
elseif ($dept_abbr=="LIBRARY") return "LIBRARY";
elseif ($dept_abbr=="PHY_EDU") return "PHYSICAL EDUCATION";
elseif ($dept_abbr=="TPO") return "TRAINING & PLACEMENT";
return "KIT";
}

function to_ddmmyyyy($yyyymmdd)		{
			if($yyyymmdd=='Y') return $yyyymmdd; 
			if(strtotime($yyyymmdd))	{
			if($yyyymmdd!='0000-00-00')	{
				$exploded=explode('-',$yyyymmdd);
			$s_day=$exploded[2];
			$s_mon=$exploded[1];
			$s_year=$exploded[0];

			//$today=date('yyyy-mm-dd');

			$ddmmyyyy=date(" d-m-Y ", mktime(0,0,0,$s_mon, $s_day, $s_year));
			return $ddmmyyyy;
			} else return '';
			} else return $yyyymmdd;
}
function to_yyyymmdd($ddmmyyyy)		{
		
			if($ddmmyyyy!='00-00-0000')	{
				$exploded=explode('-',$ddmmyyyy);
			$s_day=$exploded[2];
			$s_mon=$exploded[1];
			$s_year=$exploded[0];

			//$today=date('yyyy-mm-dd');
			
			$yyyymmdd=date("Y-m-d", mktime(0,0,0,$s_mon, $s_day, $s_year));
			$yyyymmdd=date('Y-m-d',strtotime($ddmmyyyy));
			return $yyyymmdd;
			} else return '';
}

function leave_type($leave_from_db)	{

			switch ($leave_from_db)	{
				case 'cl':return 'Casual';break;
				case 'compensation_l':return "CO";break;
				case 'dl':return 'Duty';break;
				case 'ml':return 'Medical';break;
				case 'el':return 'Earned';break;
				case 'sl':return 'Sumr Vac';break;
				case 'wl':return 'Wint Vac';break;
				case 'matl':return 'Maternity';break;
				case 'lwp':return 'LWP';break;
				default : return $leave_from_db;
			}
}

function get_pending_leaves($conn,$uname,$year,$type)	{
$sql1="select sum(no_of_days) as days from leavemanager where username='$uname' and year='$year' and final_status='pending' and type='$type'";
	if($result=mysqli_query($conn,$sql1)){
		$result1=$result->fetch_array();
		$no_of_pending_leaves=$result1[0];//->fetch_array();
		return $no_of_pending_leaves;
	}
}
// remove .'s from username and Keep only forst capital letter
function first_letter_capital($username)
{
	
}
//function to check holidays before/after summer/winter leave
function check_conditions($from,$to)
{
$unixTimeStamp_from=strtotime($from);
$unixTimeStamp_to=strtotime($to);
$from_day=date('l',$unixTimeStamp_from);
$to_day=date('l',$unixTimeStamp_to);

if($from_day=="Tuesday" && $to_day=="Saturday")	{
	echo "You can avail vacation attached to holidays at one end only.";
	exit(-1);

	}

}
function diff_btwn_dates($upper,$lower)//date in yyyy-mm-dd format
{
	$upp_date=strtotime($upper);
	$low_date=strtotime($lower);
	return ($upp_date-$low_date)/60/60/24;
}
function calculate_no_of_days($type,$to_date,$from_date,$half_begin,$half_end)
{
	$d=diff_btwn_dates($to_date,$from_date);
	$no_of_days=$d+1;
//allwed lwp in half day format 21/11/2020	
	if($type=='casual_leave'or $type=='compensatory_leave_add' or $type=='compensatory_leave_sub' or $type=='earned_leave'or $type=='duty_leave' or $type=='leave_without_pay') 	{
		if ($half_begin=='yes' and $half_end=='no'){//
		$no_of_days-=0.5;
		}elseif ($half_begin=='no' and $half_end=='yes'){//
		$no_of_days-=0.5;
		}elseif ($half_begin=='yes' and $half_end=='yes'){//
		$no_of_days-=1;
		}
	}
	if($type=='compensatory_leave_add')	{
		if($half_begin=='no' and $half_end=='late_evening')	$no_of_days+=0.5;
		if($half_begin=='no' and $half_end=='night')	$no_of_days+=1;
		if($half_begin=='yes' and $half_end=='late_evening')	$no_of_days+=0; 
		if($half_begin=='yes' and $half_end=='night')	$no_of_days+=0.5;
		if($half_begin=='evening' and $half_end=='late_evening')	$no_of_days-=0.5; 
		if($half_begin=='evening' and $half_end=='night')	$no_of_days+=0;

	}
	
	return $no_of_days;


}











?>

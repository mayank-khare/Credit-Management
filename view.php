<?php
include("header.php");
include("dbconfig.php");
include("footer.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
?>

<div class="container-fluid">
    	<div class="jumbotron">
        	<div class="container">
        		<form  class='' method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<?php
                $sql="SELECT * FROM users";
                $result=mysqli_query($conn,$sql);
                if($result->num_rows >0)
                {
                    echo "
                	<h4>Select sender</h4>
					<select  name='sender' class='form-control'>";
					$result=mysqli_query($conn,$sql);		
					while($row=$result->fetch_assoc())
					{
						echo "<option value='".$row['name']."'>".$row['name']."</option>";
					}
					 echo "</select><br><h4>Select recipient</h4>
					 <select name='recipient' class='form-control'>";
					 $result=mysqli_query($conn,$sql);		
					 while($row=$result->fetch_assoc())
					 {
						echo "<option value='".$row['name']."'>".$row['name']."</option>";
					 }
					 echo "</select>";
           			
                }
                ?>
                <br>
                <h4>Enter number of credits, you want to transfer</h4> 
                	
                	<input type="tel" name="credit" class="form-control" placeholder="Enter Credit point" required><br>
                    <div class="text-center">
                    	<input type="submit" name="transfer" class="btn btn-default" value="Transfer Credit">
                     </div>   
        	</div>
        </div>
    </div>    
    <?php 
		if(isset($_POST['transfer']))
		{
			if($_POST['sender']==$_POST['recipient'])
			{
				echo "<script>alert('Both sender and recipient is same')</script>";
								return;
			}
			if($_POST['credit']<=0)
			{
				echo "<script>alert('Please Choose value of credit greater than zero')</script>";
								return;
			}
            //$conn=mysqli_connect("localhost","id4871014_tsftasks","12345","id4871014_dummy_database");			
			$sender_credit=$recipient_credit=0;
		    $sql2="SELECT credit FROM users WHERE name LIKE '".$_POST['sender']."%';";
			$sql3="SELECT credit FROM users WHERE name LIKE '".$_POST['recipient']."%';";
			$sender_result=mysqli_query($conn,$sql2);
			$recipient_result=mysqli_query($conn,$sql3);
			while($row=$sender_result->fetch_assoc())
			{
				$sender_credit=$row['credit'];
			}
			while($row=$recipient_result->fetch_assoc())
			{
				$recipient_credit=$row['credit'];
			}
			if($sender_credit<$_POST['credit'])
			echo "<script>alert('Sender does not have enough credits')</script>";
			else
			{
			    $recipient_credit=$recipient_credit+$_POST['credit'];
			    $sender_credit=$sender_credit-$_POST['credit'];
				$sql4="UPDATE users SET credit=".$recipient_credit." WHERE name LIKE '".$_POST['recipient']."%';";
				$sql5="UPDATE users SET credit=".$sender_credit." WHERE name LIKE '".$_POST['sender']."%';";
				mysqli_query($conn,$sql4);
				mysqli_query($conn,$sql5);
			    echo "<script>alert('".$_POST['credit']." credit is transferred from ".$_POST['sender']." to ".$_POST['recipient']."')</script>";
			    date_default_timezone_set('Asia/kolkata');
			    $dt=time();
			    $date=date("d-m-Y H:i:s",$dt);
			    $sql6="INSERT INTO transfer (user_from,user_to,amount) VALUES ('".$_POST['sender']."','".$_POST['recipient']."',".$_POST['credit'].")";
			    $conn = new mysqli($servername, $username, $password, $dbname);
			    mysqli_query($conn,$sql6);
			    
			}
			
		}
	?>
</body>
</html>
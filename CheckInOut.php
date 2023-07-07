<?php
    session_start();
    $server = "localhost";
    $username="root";
    $password="";
    $dbname="bdcontrol_asistencia";

    $conn = new mysqli($server,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed" .$conn->connect_error);
    }

    if(isset($_POST['studentID'])){
		date_default_timezone_set("America/Lima");
              
        $studentID =$_POST['studentID'];
		$date = date('Y-m-d');
		$time = date('H:i:s A');

		$sql = "SELECT * FROM personal WHERE dni_personal = '$studentID'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'No se puede encontrar el número de Código QR: '.$studentID;
		}else{
				$row = $query->fetch_assoc();
				$id = $row['dni_personal'];
				$sql ="SELECT * FROM asistencialp WHERE dni_personal='$id' AND fecha='$date' AND estado='0'";
				$query=$conn->query($sql);
				if($query->num_rows>0){
				$sql = "UPDATE asistencialp SET salida='$time', estado='1' WHERE dni_personal='$studentID' AND fecha='$date'";
				$query=$conn->query($sql);
				$_SESSION['success'] = 'Salida: '.$row['nombres'].' '.$row['apellido_paterno'].' '.$row['apellido_materno'];
			}else{
					$sql = "INSERT INTO asistencialp(dni_personal,entrada,fecha,estado) VALUES('$studentID','$time','$date','0')";
					if($conn->query($sql) ===TRUE){
					 $_SESSION['success'] = 'Entrada: '.$row['nombres'].' '.$row['apellido_paterno'].' '.$row['apellido_materno'];
			 }else{
			  $_SESSION['error'] = $conn->error;
		   }	
		}
	}

	}else{
		$_SESSION['error'] = 'Please scan your QR Code number';
}
header("location: index.php");
	   
$conn->close();
?>
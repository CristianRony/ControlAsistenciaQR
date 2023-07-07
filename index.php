<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Asistencia</title>
    <script type="text/javascript" src="js/instascan.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- DataTables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="css/responsive.bootstrap4.min.css">
    
</head>
<body>
  <header>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background:#002A8D">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="img/logo_casita.png" width="41" height="auto" class="d-inline-block align-top" alt="">
        Leoncio Prado
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#"><i class="fa-solid fa-house"></i> Inicio<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-gear"></i> Mantenimiento
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i> Estudiante</a>
              <a class="dropdown-item" href="personal_index.php"><i class="fa-solid fa-user-plus"></i> Añadir estudiante</a>
              <a class="dropdown-item" href="attendance.php"><i class="fa-solid fa-calendar"></i> Asistencia</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-file"></i> Reporte</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-clock"></i> Verificar Asistencia</a>
          </li>
          
        </ul>
      </div>
    </div>    
  </nav>
  </header>
  <section class="fecha_hora">  
    <div class="container">
      <div class="">
        <h2 id="reloj" class="display-4 text-center"></h2>
        <p id="fecha" class="lead text-center"></p>
               
      </div>
    </div>
    
  </section>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
            <center><p class="login-box-msg"><i class="fa-solid fa-qrcode"></i> QR</p></center>
              <video id="preview" width=100%></video>
              <?php
                if(isset($_SESSION['error'])){
                echo "
                  <div class='alert alert-danger alert-dismissible' style='background:red;color:#fff'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h6><i class='icon fa fa-warning'></i> Error!</h6>
                  ".$_SESSION['error']."
                  </div>
                ";
                unset($_SESSION['error']);
                }
                if(isset($_SESSION['success'])){
                echo "
                  <div class='alert alert-success alert-dismissible' style='background:green;color:#fff'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h6><i class='icon fa fa-check'></i> Resgistro de asistencia exitoso!</h6>
                  ".$_SESSION['success']."
                  </div>
                ";
                unset($_SESSION['success']);
                }
              ?>
              </div>
            <div class="col-md-8"> 
              <form action="CheckInOut.php" method="post" class="form-horizontal">
                <label><i class="fa-solid fa-id-card"></i> Nro de Identificación</label>
                <input type="text" name="studentID" id="text" placeholder="Nro DNI" class="form-control"   autofocus>   
                </form>
              <hr class="my-3">                      
              <div style="border-radius: 5px;padding:10px;background:#fff;" id="divvideo">
                  <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                          <td>Apellidos y Nombres</td>
                          <td>Nro DNI</td>
                          <td>Entrada</td>
                          <td>Salida</td>
                          <td>Fecha</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                      $server = "localhost";
                                      $username="root";
                                      $password="";
                                      $dbname="bdcontrol_asistencia";
                                  
                                      $conn = new mysqli($server,$username,$password,$dbname);
                                      date_default_timezone_set("America/Lima");
                          $date = date('Y-m-d');
                                      if($conn->connect_error){
                                          die("Connection failed" .$conn->connect_error);
                                      }
                                        $sql ="SELECT * FROM asistencialp LEFT JOIN personal USING(dni_personal) WHERE fecha='$date'";
                                        $query = $conn->query($sql);
                                        while ($row = $query->fetch_assoc()){
                                      ?>
                                          <tr>
                                              <td><?php echo $row['apellido_paterno'].' '.$row['apellido_materno'].', '.$row['nombres'];?></td>
                                              <td><?php echo $row['dni_personal'];?></td>
                                              <td><?php echo $row['entrada'];?></td>
                                              <td><?php echo $row['salida'];?></td>
                                              <td><?php echo $row['fecha'];?></td>
                                          </tr>
                                      <?php
                                      }
                                      ?>
                                  </tbody>
                                </table>
                        
                              </div>            
            </div>
        </div>
    </div>
    

  <footer class="new_footer_area bg_color">
      <div class="new_footer_top">
          <div class="container">
              <div class="row">
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget company_widget wow fadeInLeft" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">
                          <h3 class="f-title f_600 t_color f_size_18">Control de Asistencia QR</h3>
                          <p>Leoncio Prado</p>
                          <!--<form action="#" class="f_subscribe_two mailchimp" method="post" novalidate="true" _lpchecked="1">
                              <input type="text" name="EMAIL" class="form-control memail" placeholder="Email">
                              <button class="btn btn_get btn_get_two" type="submit">Subscribe</button>
                              <p class="mchimp-errmessage" style="display: none;"></p>
                              <p class="mchimp-sucmessage" style="display: none;"></p>
                          </form>-->
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget about-widget pl_70 wow fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                          <h3 class="f-title f_600 t_color f_size_18">Download</h3>
                          <ul class="list-unstyled f_list">
                              <li><a href="#">Company</a></li>
                              <li><a href="#">Android App</a></li>
                              <li><a href="#">ios App</a></li>
                              <li><a href="#">Desktop</a></li>
                              <li><a href="#">Projects</a></li>
                              <li><a href="#">My tasks</a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget about-widget pl_70 wow fadeInLeft" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInLeft;">
                          <h3 class="f-title f_600 t_color f_size_18">Help</h3>
                          <ul class="list-unstyled f_list">
                              <li><a href="#">Documentation</a></li>
                              <!--<li><a href="#">FAQ</a></li>
                              <li><a href="#">Term &amp; conditions</a></li>
                              <li><a href="#">Reporting</a></li>
                              
                              <li><a href="#">Support Policy</a></li>
                              <li><a href="#">Privacy</a></li>-->
                          </ul>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget social-widget pl_70 wow fadeInLeft" data-wow-delay="0.8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInLeft;">
                          <h3 class="f-title f_600 t_color f_size_18">Team Solutions</h3>
                          <div class="f_social_icon">
                              <a href="#" class="fab fa-facebook"></a>
                              <a href="#" class="fab fa-twitter"></a>
                              <a href="#" class="fab fa-linkedin"></a>
                              <a href="#" class="fab fa-pinterest"></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="footer_bg">
              <div class="footer_bg_one"></div>
              <div class="footer_bg_two"></div>
          </div>
      </div>
      <div class="footer_bottom">
          <div class="container">
              <div class="row align-items-center">
                  <div class="col-lg-6 col-sm-7">
                      <p class="mb-0 f_400">© Leoncio Prado, 2022 - todo los derechos reservados.</p>
                  </div>
                  <div class="col-lg-6 col-sm-5 text-right">
                      <p>Developer <i class="icon_heart"></i>: <a href="https://github.com/CristianRony">CristianRony</a></p>
                  </div>
              </div>
          </div>
      </div>
  </footer>
    <script src="plugins/jquery/jquery.min.js"></script>
		<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
		<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script type="text/javascript" src="js/adapter.min.js"></script>
    <script type="text/javascript" src="js/vue.min.js"></script>

  
    <script>
        let scanner =new Instascan.Scanner({ video: document.getElementById('preview')});
        Instascan.Camera.getCameras().then(function(cameras){
            if(cameras.length > 0){
                scanner.start(cameras[0]);
            }else{
                alert('No cameras found')
            }
        }).catch(function(e) {
            console.error(e);
            
        });
        scanner.addListener('scan',function(c) {
            document.getElementById('text').value=c;
            document.forms[0].submit();            
        });
    </script>
    <script>
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    document.getElementById('fecha').innerHTML=diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
    </script>
    
    <script type="text/javascript">
      function startTime(){
      today=new Date();
      h=today.getHours();
      m=today.getMinutes();
      s=today.getSeconds();
      m=checkTime(m);
      s=checkTime(s);
      document.getElementById('reloj').innerHTML=h+":"+m+":"+s;
      t=setTimeout('startTime()',500);}
      function checkTime(i)
      {if (i<10) {i="0" + i;}return i;}
      window.onload=function(){startTime();}
    </script>
    <script>
		  $(function () {
			$("#example1").DataTable({
			  "responsive": true,
			  "autoWidth": false,
			});
			$('#example2').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": false,
			  "ordering": true,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
		  });
		</script>
      
    
</body>
</html>
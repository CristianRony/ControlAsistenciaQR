<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiante/Docentes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- DataTables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="css/responsive.bootstrap4.min.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="col-lg-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools">
                            <a class="btn btn-outline-primary new_people" href="javascript:void(0)"><i class="fa fa-plus"></i> Añadir nuevo</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table tabe-hover table-bordered" id="list">
                           
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>DNI</th>
                                    <th>Apellidos y Nombres</th>                                   
                                    <th>Sexo</th>
                                    <th>Tipo</th>
                                    <th>Grado</th>                                    
                                    <th>Sección</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                      $server = "localhost";
                                      $username="root";
                                      $password="";
                                      $dbname="bdcontrol_asistencia";
                                  
                                      $conn = new mysqli($server,$username,$password,$dbname);
                                      if($conn->connect_error){
                                          die("Connection failed" .$conn->connect_error);
                                      }
                                      
                                        $i = 1;
                                        $sql ="SELECT * FROM personal";
                                        $query = $conn->query($sql);
                                        while ($row = $query->fetch_assoc()):
                                      ?>
                                          <tr>
                                            <th class="text-center"><?php echo $i++ ?></th>
                                            <td><?php echo $row['dni_personal'];?></td>
                                            <td><?php echo $row['apellido_paterno'].' '.$row['apellido_materno'].', '.$row['nombres'];?></td>
                                            <td><?php echo $row['sexo'];?></td>
                                              <td><?php echo $row['tipo_cargo'];?></td>
                                              <td><?php echo $row['grado'];?></td>
                                              <td><?php echo $row['seccion'];?></td>
                                              <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-id='<?php echo $row['dni_personal'] ?>' class="btn btn-success btn-track track_people">
                                                    <i class="fas fa-list"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" data-id='<?php echo $row['dni_personal'] ?>' class="btn btn-info btn-flat view_people">
                                                    <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" data-id='<?php echo $row['dni_personal'] ?>' class="btn btn-primary btn-flat manage_people">
                                                    <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-flat delete_people" data-id="<?php echo $row['dni_personal'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                          </tr>
                                        <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>

        $(document).ready(function(){
            $('#list').dataTable()
            $('.new_people').click(function(){
                uni_modal("Nuevo","./people/manage.php",'mid-large')
            })
            $('.manage_people').click(function(){
                uni_modal("Manage Individual","./people/manage.php?dni_personal="+$(this).attr('data-id'),'mid-large')
            })
            $('.track_people').click(function(){
                uni_modal("Tracks",".personal_tracks.php?id="+$(this).attr('data-id'),'mid-large')
            })
            $('.view_people').click(function(){
                uni_modal("Person's CTS Card","./personal_tarjeta.php?id="+$(this).attr('data-id'))
            })
            $('.delete_people').click(function(){
            _conf("Are you sure to delete this Individual?","delete_people",[$(this).attr('data-id')])
            })
            $('#list').dataTable()
        })
        function delete_people($id){
            start_loader()
            $.ajax({
                url:_base_url_+'classes/People.php?f=delete',
                method:'POST',
                data:{id:$id},
                success:function(resp){
                    if(resp==1){
                        location.reload()
                    }
                }
            })
        }
    </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    
    
</body>
</html>

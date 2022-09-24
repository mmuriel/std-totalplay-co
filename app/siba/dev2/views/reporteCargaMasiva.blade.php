<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STD - ReporteCargaMasiva</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('libs/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this datatables-->
    <link href="{{ asset('libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">STD</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="reportecargamasiva"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Reporte Carga Masiva</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$name}}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('libs/images/usuario.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                            
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>

                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">ReporteCargaMasiva</h1>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header container-fluid">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h5 class="card-title"> Criterios de Busqueda</h5>
                                        </div>
                                        <div class="col-md-2 float-right">

                                            <button type="button" class="btn" data-toggle="collapse" data-target="#minimizar" aria-expanded="false" aria-controls="minimizar">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn" id="btnLimpiarBusqueda">

                                                <i class="fas fa-times"></i>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body collapse" id="minimizar">
                                    <div class="row">
                                        <div class="col-lg-12 d-lg-flex">
                                            <div class="form-group ">
                                                <form id="formQuery">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="iptCanal">Canal</label>
                                                            <input type="text" id="iptCanal" name="iptCanal" class="form-control">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="iptStatus">Estado</label>
                                                            <select class="form-control" name="iptStatus" id="iptStatus">
                                                                <option value="" selected>Todos</option>
                                                                <option value="done">done</option>
                                                                <option value="error">error</option>
                                                                <option value="inprocess">inprocess</option>
                                                                <option value="ready">ready</option>
                                                                <option value="uploading">uploading</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="iptFecha">Fecha de Inicio</label>
                                                            <input type="datetime-local" id="iptFechaIni" name="iptFechaIni"class="form-control">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="iptFecha2">Fecha Final</label>
                                                            <input type="datetime-local" id="iptFechaFin" name="iptFechaFin" class="form-control">
                                                        </div>

                                                        
                                                        <div class="form-group col-md-6">
                                                            &nbsp
                                                            <button type="submit" id="enviar" class="btn btn-primary btn-user btn-block">
                                                                Consultar
                                                            </button>
                                                        </div>
                                                    
                                                    </div>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>IdCanal</th>
                                            <th>Fecha de carga</th>
                                            <th>Hora de carga</th>
                                            <th>Estado</th>
                                            <th>Notas</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>IdCanal</th>
                                            <th>Fecha de carga</th>
                                            <th>Hora de carga</th>
                                            <th>Status</th>
                                            <th>Notas</th>   
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="salir">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('libs/sbadmin/js/sb-admin-2.min.js') }}"></script>

    <!-- DataTables custom scripts -->
    <script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    


    <script>

        $(document).ready(function () {
            
            
            iptCanal = $.trim($('#iptCanal').val());
            iptStatus = $.trim($('#iptStatus').val());
            iptFechaIni = $.trim($('#iptFechaIni').val());
            iptFechaFin = $.trim($('#iptFechaFin').val());
            iptFechaFin = iptFechaFin.replace("T"," ");

            table = $('#dataTable').DataTable({
                "ajax": {
                    "url":"/reportecargamasiva/ajax",
                    "type":"GET",
                    "dataSrc":{iptCanal:iptCanal,iptStatus:iptStatus,iptFechaIni:iptFechaIni,iptFechaFin:iptFechaFin},
                    "data":function(d){
                        d.iptCanal= iptCanal;
                        d.iptStatus =iptStatus
                        d.iptFechaIni= iptFechaIni
                        d.iptFechaFin= iptFechaFin
                    }
                },
                "columns":[
                    {"data":"id"},
                    {"data":"name"},
                    {"data":"idcanal"},
                    {"data":"created_at"},
                    {"data":"created_at"},
                    {"data":"status"},
                    {"data":"notes"}
                ],
                "rowCallback":function(row, data){

                    //cambio de color por los estados
                    if(data['status']=='done'){
                        $(row).addClass("table-success");
                    }else if(data['status']=='error'){
                        $(row).addClass("table-danger");
                    }else if(data['status']=='ready'){
                        $(row).addClass("table-info");
                    }else if(data['status']=='ready'){
                        $(row).addClass("table-info");
                    }else if(data['status']=='inprocess'){
                        $(row).addClass("table-warning");
                    }

                    //columna name
                    var myRe = new RegExp('[A-Z 0-9]+', 'g');
                    var myArray = myRe.exec(data['name']);
                    $(row).find('td:eq(1)').html(myArray[0]);

                    //columna notas
                    var myRe2 = new RegExp('\n-{10}\n[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}\n', 'g');
                    var myArray2 = myRe2.exec(data['notes']);
                    try{
                        var notes = data['notes'].replace(myArray2[0],"");
                        $(row).find('td:eq(6)').html(notes);
                    }catch(error){
                        //pass
                    }
                    
                   
                    
                    

                    //columna fecha
                    var myRe3 = new RegExp('[0-9]{4}-[0-9]{2}-[0-9]{2}', 'g');
                    var myArray3 = myRe3.exec(data['created_at']);
                    $(row).find('td:eq(3)').html(myArray3[0]);
                    
                    //columna hora
                    var myRe4 = new RegExp('[0-9]{2}:[0-9]{2}:[0-9]{2}', 'g');
                    var myArray4 = myRe4.exec(data['created_at']);
                    $(row).find('td:eq(4)').html(myArray4[0]);
                    


                    

                },
                responsive: true,
                "language": {
                    
                    "lengthMenu": "Mostrar " +
                                `<select class="custom-select custom-select-sm form-control form-control-sm">
                                    <option value='10'>10</option>
                                    <option value='25'>25</option>
                                    <option value='50'>50</option>
                                    <option value='100'>100</option>
                                </select>` +
                                " registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search":'Buscar:',
                    'paginate': {
                        'next': "Siguinete",
                        'previous': "Anterior"
                    }
                },
                order: [[3, 'desc']],
            });
            $("#formQuery").submit(function(e){
                e.preventDefault();
                iptCanal = $.trim($('#iptCanal').val());
                iptStatus = $.trim($('#iptStatus').val());
                iptFechaIni = $.trim($('#iptFechaIni').val());
                iptFechaIni = iptFechaIni.replace("T"," ");
                iptFechaFin = $.trim($('#iptFechaFin').val());
                iptFechaFin = iptFechaFin.replace("T"," ");
                table.ajax.reload( null, false,function (json){
                            $('#iptCanal').val(json.lastInput);
                            $('#iptStatus').val(json.lastInput);
                            $('#iptFechaIni').val(json.lastInput);
                            $('#iptFechaFin').val(json.lastInput);
                        });

            });
        });
    
        
    </script>

    <script>
        
        $.fn.setNow = function (onlyBlank) {
            var now = new Date($.now());
            
            var year = now.getFullYear();
            
            var month = (now.getMonth() + 1).toString().length === 1 ? '0' + (now.getMonth() + 1).toString() : now.getMonth() + 1;
            var date = now.getDate().toString().length === 1 ? '0'         + (now.getDate()).toString()      : now.getDate();
            var hours = (now.getHours() - 2 ).toString().length === 1 ? '0'       + (now.getHours() - 2).toString()       : now.getHours() - 2;
            var minutes = now.getMinutes().toString().length === 1 ? '0'   + now.getMinutes().toString()     : now.getMinutes();

            
            var formattedDateTime = year + '-' + month + '-' + date + 'T' + hours + ':' + minutes + ':00';

            if ( onlyBlank === true && $(this).val() ) {
                return this;
            }
            
            $(this).val(formattedDateTime);
            
            return this;
            }

            $.fn.setNow2 = function (onlyBlank) {
            var now = new Date($.now());
            
            var year = now.getFullYear();
            
            var month = (now.getMonth() + 1).toString().length === 1 ? '0' + (now.getMonth() + 1).toString() : now.getMonth() + 1;
            var date = now.getDate().toString().length === 1 ? '0'         + (now.getDate()).toString()      : now.getDate();
            var hours = (now.getHours() + 1 ).toString().length === 1 ? '0'       + (now.getHours() + 1).toString()       : now.getHours() + 1;
            var minutes = now.getMinutes().toString().length === 1 ? '0'   + now.getMinutes().toString()     : now.getMinutes();

            
            var formattedDateTime = year + '-' + month + '-' + date + 'T' + hours + ':' + minutes + ':00';

            if ( onlyBlank === true && $(this).val() ) {
                return this;
            }
            
            $(this).val(formattedDateTime);
            
            return this;
            }


            $(function () {
                $('#iptFechaIni').setNow();
                $('#iptFechaFin').setNow2();
            });

            $("#btnLimpiarBusqueda").on('click',function(){
            $("#iptCanal").val('')
            $("#iptStatus").val('')
            $('#iptFechaIni').setNow();
            $('#iptFechaFin').setNow2();
            table.search('').columns().search('').draw();
        })


    </script>


</body>

</html>
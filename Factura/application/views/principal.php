

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Facturaci&oacute;n | V1.0</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/css/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<link href="<?php echo base_url();?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <!--<link href="<?php echo base_url();?>assets/dataTables.responsive.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/demo_page.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/demo_table_jui.css" rel="stylesheet" />-->
    <!-- ================== END BASE CSS STYLE ================== -->
    

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />   
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />  
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />    
    <link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>file-input/css/fileinput.css" />
    <link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />   
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <script type="text/javascript">var base_url="<?php echo base_url();?>";</script>
</head>
<body>
    <!-- begin #page-loader -->
    <div id="page-loader">
        <div class="material-loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
            <div class="message">Loading...</div>
        </div>
    </div>
    <!-- end #page-loader -->
    
    <!-- begin #page-container -->
    <div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-click="top-menu-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo base_url();?>" class="navbar-brand">
                        FACTURACI&Oacute;N V1.0
                    </a>
                </div>
                <!-- end mobile sidebar expand / collapse button -->
                
                <!-- begin header navigation right -->
                <ul class="nav navbar-nav navbar-right" style="display:none">
                    <li>
                        <a href="#" class="icon notification waves-effect waves-light" data-toggle="navbar-search"><i class="material-icons">search</i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="icon notification waves-effect waves-light" data-toggle="dropdown">
                            <i class="material-icons">inbox</i> <span class="label label-notification">5</span>
                        </a>
                        <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                            <li class="dropdown-header bg-indigo text-white">Notifications (5)</li>
                            <li class="media">
                                <a href="javascript:;">
                                    <div class="media-left"><img src="assets/img/user-1.jpg" class="media-object" alt="" /></div>
                                    <div class="media-body">
                                        <h6 class="media-heading">John Smith</h6>
                                        <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                        <div class="text-muted f-s-11">25 minutes ago</div>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="javascript:;">
                                    <div class="media-left"><img src="assets/img/user-2.jpg" class="media-object" alt="" /></div>
                                    <div class="media-body">
                                        <h6 class="media-heading">Olivia</h6>
                                        <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                        <div class="text-muted f-s-11">35 minutes ago</div>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="javascript:;">
                                    <div class="media-left"><i class="material-icons media-object bg-deep-purple">people</i></div>
                                    <div class="media-body">
                                        <h6 class="media-heading"> New User Registered</h6>
                                        <div class="text-muted f-s-11">1 hour ago</div>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="javascript:;">
                                    <div class="media-left"><i class="material-icons media-object bg-blue">email</i></div>
                                    <div class="media-body">
                                        <h6 class="media-heading"> New Email From John</h6>
                                        <div class="text-muted f-s-11">2 hours ago</div>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="javascript:;">
                                    <div class="media-left"><i class="material-icons media-object bg-teal">shopping_basket</i></div>
                                    <div class="media-body">
                                        <h6 class="media-heading">You sold an item!</h6>
                                        <div class="text-muted f-s-11">3 hours ago</div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-footer text-center">
                                <a href="javascript:;">View more</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown navbar-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="assets/img/user.jpg" alt="" /> 
                            <span class="hidden-xs">Hi, John Smith</span>
                        </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li class="arrow"></li>
                            <li><a href="javascript:;">Edit Profile</a></li>
                            <li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
                            <li><a href="javascript:;">Calendar</a></li>
                            <li><a href="javascript:;">Setting</a></li>
                            <li class="divider"></li>
                            <li><a href="javascript:;">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- end header navigation right -->
                
                <div class="search-form">
                    <button class="search-btn" type="submit"><i class="material-icons">search</i></button>
                    <input type="text" class="form-control" placeholder="Search Something...">
                    <a href="#" class="close" data-dismiss="navbar-search"><i class="material-icons">close</i></a>
                </div>
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->
        
        <!-- begin #top-menu -->
        <div id="top-menu" class="top-menu" style="display:none">
            <!-- begin top-menu nav -->
            <ul class="nav">
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="material-icons">home</i>
                        <span>Dashboard</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="index.html">Dashboard v1</a></li>
                        <li><a href="index_v2.html">Dashboard v2</a></li>
                    </ul>
                </li>
				<li class="has-sub">
                    <a href="<?php echo base_url();?>cliente">
                        <b class="caret pull-right"></b>
                        <i class="material-icons">C</i>
                        <span>Clientes</span>
                    </a>                    
                     
                </li>

				<li class="has-sub">
					<a href="<?php echo base_url();?>cotizacion">
						<b class="caret pull-right"></b>
						<i class="material-icons">C</i>
						<span>Cotizaci&oacute;n</span>
					</a>
					<ul class="sub-menu">
						<li><a href="<?php echo base_url();?>lista_cotizacion">Lista Cotizaci&oacute;n</a></li>						
					</ul>
				</li>
            </ul>
            <!-- end top-menu nav -->
        </div>
        <!-- end #top-menu -->
        
        <!-- begin #content -->
        <div id="content" class="content">
			<?php echo $contenido;?>
           
        </div>
        <!-- end #content -->       
          <!-- begin theme-panel -->
        <div class="theme-panel">
            <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
            <div class="theme-panel-content">
                <h5 class="m-t-0">Color Theme</h5>
                <ul class="theme-list clearfix">
                    <li class="active"><a href="javascript:;" class="bg-cyan" data-theme="default" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Default/Cyan">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-blue" data-theme="blue" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Blue">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-purple" data-theme="purple" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-orange" data-theme="orange" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-red" data-theme="red" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
                    <li><a href="javascript:;" class="bg-black" data-theme="black" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Black">&nbsp;</a></li>
                </ul>
                <div class="divider"></div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Header Styling</div>
                    <div class="col-md-7">
                        <select name="header-styling" class="form-control input-sm">
                            <option value="1">default</option>
                            <option value="2">inverse</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label">Header</div>
                    <div class="col-md-7">
                        <select name="header-fixed" class="form-control input-sm">
                            <option value="1">fixed</option>
                            <option value="2">default</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Sidebar Styling</div>
                    <div class="col-md-7">
                        <select name="sidebar-styling" class="form-control input-sm">
                            <option value="1">default</option>
                            <option value="2">grid</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label">Sidebar</div>
                    <div class="col-md-7">
                        <select name="sidebar-fixed" class="form-control input-sm">
                            <option value="1">fixed</option>
                            <option value="2">default</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-5 control-label double-line">Sidebar Gradient</div>
                    <div class="col-md-7">
                        <select name="content-gradient" class="form-control input-sm">
                            <option value="1">disabled</option>
                            <option value="2">enabled</option>
                        </select>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-inverse btn-block btn-sm" data-click="reset-local-storage"><i class="fa fa-refresh m-r-3"></i> Reset Local Storage</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end theme-panel -->
        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
	
   
    <!-- end page container -->
  <!--Alertify-->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/alertify/alertify.core.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/alertify/alertify.default.css" id="toggleCSS" />
     <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/alertify/dist/sweetalert.css">
    <script src="<?php echo base_url()?>assets/alertify/alertify.min.js"></script>  
    <script src="<?php echo base_url()?>assets/alertify/dist/sweetalert.min.js"></script>
   
 <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="assets/crossbrowserjs/html5shiv.js"></script>
        <script src="assets/crossbrowserjs/respond.min.js"></script>
        <script src="assets/crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url();?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	
	
    <!-- ================== END BASE JS ================== -->
    
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php echo base_url();?>assets/js/consultadocumentos.js"></script>
    <script src="<?php echo base_url();?>assets/js/funciones.js"></script>
    <script src="<?php echo base_url();?>file-input/js/fileinput.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/masked-input/masked-input.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/password-indicator/js/password-indicator.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>   
    <script src="<?php echo base_url();?>assets/js/form-plugins.demo.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
	<script src="assets/plugins/ckeditor/ckeditor.js"></script>
    <script src="assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="assets/js/form-wysiwyg.demo.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    
    <script>
        var table, tableCliente,TableListaCotiza,procedeCli=0;
         var Operacion=0; //1 Nuevo 2 Modifica
        $(document).ready(function() {
            App.init();
            FormPlugins.init();
            //FormWysihtml5.init();
			TableManageResponsive.init();
        });
        $(function(){
			tableCliente = $('#cliente').DataTable( {
                responsive: true,
                "bProcessing" : true,     
                "bScrollInfinite": true,
                "bScrollCollapse": true,
                //"sScrollY"    : "550px",          
                "BAutoWidth"  : true,
                "bJQueryUI"   : true,     
                "paging": true,
                "bDestroy": true,
                "bDeferRender": true,
                "sAjaxSource"   : "<?php echo base_url();?>cliente/listar_cliente/"+'AC',
                "aaSorting": [[ 0, 'asc' ]]
            } );
			
            table = $('#example').DataTable( {
                responsive: true,
                "bProcessing" : true,     
                "bScrollInfinite": true,
                "bScrollCollapse": true,
                //"sScrollY"    : "550px",          
                "BAutoWidth"  : true,
                "bJQueryUI"   : true,     
                "paging": true,
                "bDestroy": true,
                "bDeferRender": true,
                //"sAjaxSource"   : "<?php echo base_url();?>personal/listar_personal/"+'AC',
                "aaSorting": [[ 0, 'asc' ]],
				
            } );
            TableListaCotiza = $('#ListaCotizaciones').DataTable( {
                responsive: true,
                "bProcessing" : true,     
                "bScrollInfinite": true,
                "bScrollCollapse": true,
                //"sScrollY"    : "550px",          
                "BAutoWidth"  : true,
                "bJQueryUI"   : true,     
                "paging": true,
                "bDestroy": true,
                "bDeferRender": true,
                //"sAjaxSource"   : "<?php echo base_url();?>personal/listar_personal/"+'AC',
                "aaSorting": [[ 0, 'asc' ]],
                "aoColumns": [
                  
                  { "sTitle": "ID","sWidth": "20px"},
                  { "sTitle": "RUC/DNI","sWidth": "110px"},
                  { "sTitle": "Cliente" },
                  { "sTitle": "Sub Total","sWidth": "75px" },
                  { "sTitle": "IGV" ,"sWidth": "75px"},
                  { "sTitle": "Total","sWidth": "75px"},
                  { "sTitle": "Estado","sWidth": "75px"},
                  { "sTitle": "Opción","sWidth": "75px" , "sClass": "center"}
                  ]
            } );
            //Calcula ISC
            $("#CalculaISC").on("click",function(e){
                e.preventDefault();                
                var sumISC,CalculoISC,ImpuestoSelectivo;
                sumISC=parseFloat($("#preuniprod").val() * $("#cantidadprod").val());
                CalculoISC=parseFloat($("#calc_isc").val());   
                ImpuestoSelectivo=parseFloat(sumISC * CalculoISC);  
                $("#totiscprod").val(ImpuestoSelectivo.toFixed(2));
               
                   
            })
            /*Calcula detracción*/
            $("#CalcularDetrac").on("click",function(a){
                a.preventDefault();
                var CalDetra;
                CalDetra=parseFloat($("#TotVenta").val() * $("#cal_detraccion").val());  
                $("#MontoDetraccion").val(CalDetra.toFixed(2));  
            })
			//Boton Agregar producto
            $("#modal_detalle").on("click",function(e){
                e.preventDefault();
                $("#codprod").focus();				
                $("#modal-dialog").modal("show");
            })
            $("#modal_adicional").on("click",function(e){
                e.preventDefault();
                $("#modal_adicionales").modal("show");
            })
           
			 $("#add_prod").on("click",function(e){
                e.preventDefault(); 
                Operacion=1;               
                $("#wysihtml5").val("");
                $("#wysihtml5").focus();
                $("#modal_productos_cotiza").modal("show");
            })
            $(document).on("click","#resetDormCotiza",function(e){
                e.preventDefault();
                $('#form_cotizacion')[0].reset();
                $('#table_detalle_cotiza tbody').html("");
                CalculaTotaCotiza();
            }) 
			//Relacionados
            $("#modal_relacionados").on("click",function(e){
                e.preventDefault();
                $("#modal_docrelacionado").modal("show");
            })
            $("#modal_discrepancia").on("click",function(e){
                e.preventDefault();
                $("#modal_discrepancias").modal("show");
                var CodDoc;
                CodDoc=$("#tipo_documento").val();

                $.ajax({
                    url:base_url+"principal/CargaDiscrepancia/"+CodDoc,
                    type:'get',                                         
                    success:function(data){                        
                      $("#carga_discrepancia").html(data);                                   
                        
                    },
                    error:function(rpta){ 
                     swal("Error!","Ocurió un Error al Realizar Petición..!", "error");  
                     console.log(rpta);
                       
                        
                    }

                });    

            })
			$("#btn_modal_cliente").on("click",function(e){
				$('#formcliente')[0].reset();
				procedeCli=1;
				$("#muestra_estado").hide();
				$("#modal_cliente").modal('show');	
			})
            	
            $("#url_xml").fileinput({            
                maxFileCount: 1,
                allowedFileExtensions: ["xml"]
            });	

          
          //$("#documento").on('submit', function(e){   
            $("body").on("submit","#documento",function(e){
                e.preventDefault();
                 var TipoDocumento,DocEmisor,DocReceptor;

                tipo_docu=$("#tipo_documento").val();
                DocEmisor=$("#TipoDocEmisor").val();
                DocumentoReceptor=$("#DocReceptor").val();
                
                if(tipo_docu=="01"){
                    if(DocEmisor!="6"){
                        alertify.error("Selecione Tipo de Documento RUC");
                        $("#TipoDocEmisor").focus()
                         return;
                    }
                    if(DocEmisor=="6" && DocumentoReceptor.length<11){
                         alertify.error("Ingrese un RUC Correcto");
                         $("#DocReceptor").focus();
                         return;
                    }                   
                }
                
                var form2 = $(this);                
                form2.parsley().validate();


                if (form2.parsley().isValid()){

                    //Recorre Detalle de Productos
                    var DATA=RecorreDetalle();  
                    //Recorre Datos Adicionales
                    var DatoAdicional=RecorreDatosAdicional();
                    //Recorre Documento Relacionado
                    var DatoRelacionado=RecorreDocRelacionado();
                    //Decorre Discrepancias
                    var DatoDiscrepancias=RecorreDiscrepancias();
                    //console.log(DatoDiscrepancias);                  
                 
                    //eventualmente se lo vamos a enviar por PHP por ajax de una forma bastante simple y además convertiremos el array en json para evitar cualquier incidente con compativilidades.   

                    var project = {};

                      $("#documento").serializeArray().map(function(x) {
                        project[x.name] = x.value;
                      });
                      var dato = {'formulario': project,'tabla':DATA,<?=$this->security->get_csrf_token_name();?> : "<?=$this->security->get_csrf_hash();?>",'discrepancia':DatoDiscrepancias,'relacionado':DatoRelacionado};
                   

                    $.ajax({
                        url:$("#documento").attr('action'),
                        type:'post',
                        data:dato,
                        //dataType:'json',
                        beforeSend:function(){
                           $("#Env").attr('disabled','disabled');
                            $("#lienvia2").removeClass();
                            $("#lienvia2").addClass('fa fa-spinner fa-spin');
                        $("#GuardarVenta").attr('disabled','disabled');
                        },  
                        success:function(data){
                            
                           data = eval("("+data+")");  
                           
                            if(typeof data.success != "undefined"){                     
                                if(data.errors==0){                             
                                    
                                    //swal({title: data.success['Description'][0] + "==="+ data.success['ReferenceID'][0],type: "success"});

                                    swal({
                                      title: "Enviado...!",
                                      text: data.success['Description'][0],
                                      type: "success",
                                      //showCancelButton: true,
                                      closeOnConfirm: false,
                                      showLoaderOnConfirm: true,
                                      html: true
                                    },
                                    function(){
                                      setTimeout(function(){
                                        swal("Transacción Finalizada!");

                                        window.open(base_url+'pdf/'+data.success['nombre_archivo']);
                                        window.location.reload();
                                      }, 100);
                                    });
                                                                       
                                    $("#lienvia2").removeClass();
                                    $("#lienvia2").addClass('fa fa-file-code-o');
                                    $('#documento').find('button[type=submit]').removeAttr('disabled');    
                                          
                                                
                                }else{
                                    if(typeof data.errors != "undefined"){
                                        if(data.success==0){
                                            swal("Error!",data.errors['getCode']+' '+data.errors['getMessage'], "error");
                                            $("#lienvia2").removeClass();
                                            $("#lienvia2").addClass('fa fa-file-code-o');
                                            $('#documento').find('button[type=submit]').removeAttr('disabled');    
                                            
                                        }else{
                                             if(data.success==2){

                                                swal("Error!",data.errors, "error");
                                                $("#lienvia2").removeClass();
                                                $("#lienvia2").addClass('fa fa-file-code-o');
                                                $('#documento').find('button[type=submit]').removeAttr('disabled');    
                                                
                                            }
                                        }
                                       
                                    }
                                }
                            }
                                           
                            
                        },
                        error:function(rpta){ 
                         swal("Error!","Ocurió un Error al Realizar Petición..!", "error");                  
                         $("#lienvia2").removeClass();
                         $("#lienvia2").addClass('fa fa-file-code-o');
                         $('#documento').find('button[type=submit]').removeAttr('disabled');    
                         console.log(rpta);
                           
                            
                        }

                    });
                }
           })
			
			//CAPTURA DATOS A MODIFICAR
			$('#cliente tbody ').on('click','#modifi_cli',function(e){	
				e.preventDefault();
				var cod=$(this).attr('data-id-cliente');
				procedeCli=2;
				$("#muestra_estado").show();
				CaturaCliente(cod);
				
			});//FIN CAPTURA DATOS
        })

    </script>
</body>


</html>

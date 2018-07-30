<link href='http://fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Metrophobic:400,700' rel='stylesheet' type='text/css' />

<style>
	/*Menu Empresa*/
	#buttonempresa {
		width: 100%;
		border-right: 0px solid #585858;
		padding: 0 0 1em 0;
		margin-bottom: 1em;
		font-family: 'Metrophobic', Verdana, Arial, sans-serif;
		background-color: #515151;
		color: #333333;
		font-size:13px;
		font-weight:500;
	}
	
	#buttonempresa ul {
		list-style: none;
		margin: 0;
		padding: 0;
		border: none;
	}
		
	#buttonempresa li {
		border-bottom: 1px solid #585858;
		border-bottom-style:solid;
		margin: 0;
		list-style: none;
		list-style-image: none;
	}
		
	#buttonempresa li a {
		display: block;
		padding: 15px 15px 15px 20px;
		
		background-color: #515151;
		color: #C4C4C4;
		text-decoration: none;
		width: 100%;
	}
	
	html>body #buttonempresa li a {
		width: auto;
	}
	
	#buttonempresa li a:hover {
		
		background-color: #E1583E;
		color: #fff;
	}
</style>

<ul id="buttonempresa">

    <li><a  href="index.php"><i class="fa fa-home"></i>  &nbsp;&nbsp;&nbsp; Inicio </a></li>
	
    <?php if($_SESSION['estadomenu'] != 0){?>    
    <li><a  href="control-habitaciones.php"><i class="fa fa-cog"></i> &nbsp;&nbsp;&nbsp; Control </a></li>
    <li><a  href="venta.php"><i class="fa fa-shopping-basket"></i> &nbsp;&nbsp;&nbsp;  Venta Productos</a></li>
    <li><a href="huespedes.php"><i class="fa fa-users"></i>  &nbsp;&nbsp;&nbsp; Huéspedes </a></li>
    
    <li><a  href="habitaciones.php"><i class="fa fa-hotel"></i> &nbsp;&nbsp;&nbsp;   Habitaciones </a></li>
    
    <li><a  href="productos.php"><i class="fa fa-qrcode"></i> &nbsp;&nbsp;&nbsp;  Productos </a></li>
    <li><a  href="servicios.php"><i class="fa fa-qrcode"></i> &nbsp;&nbsp;&nbsp;  Servicios </a></li>
    <li><a  href="compra-gastos.php"><i class="fa fa-qrcode"></i> &nbsp;&nbsp;&nbsp;  Compras/Gastos</a></li>
    <li><a  href="reporte.php"><i class="fa fa-line-chart"></i> &nbsp;&nbsp;&nbsp;  Reporte </a></li>
    <li><a  href="usuarios.php"><i class="fa fa-user"></i>  &nbsp;&nbsp;&nbsp; Usuarios </a></li>
    <li><a  href="sunat.php"><i class="fa fa-user"></i>  &nbsp;&nbsp;&nbsp; Documentos SUNAT </a></li>
    <li><a  href="listadosunat.php"><i class="fa fa-user"></i>  &nbsp;&nbsp;&nbsp;Listado de documentos </a></li>
    <li><a  href="resumendiario.php"><i class="fa fa-user"></i>  &nbsp;&nbsp;&nbsp;Resumen diario </a></li>
    <li><a  href="listadoresumendiario.php"><i class="fa fa-user"></i>  &nbsp;&nbsp;&nbsp;Listado resumen diario </a></li>
     <li onClick="abrir()"><a  href="#"><i class="fa fa-user"></i>  &nbsp;&nbsp;&nbsp;Modulo Facturaci&oacute;n </a></li>

    <?php } ?>
    
    
    <li><a href="salir.php"><i class="fa fa-lock"></i>  &nbsp;&nbsp;&nbsp; Salir </a></li>
</ul>
<script type="text/javascript">
	function abrir(){
		window.open("../Factura", "_blank");
	}
</script>
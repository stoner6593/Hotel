<div class="row">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-blue-grey btn-xs m-r-5" data-toggle="modal" id="btn_modal_cliente"><span class="glyphicon glyphicon-plus"></span> Nuevo Cliente</button>
			</div>
			<h7><i class="glyphicon glyphicon-search"></i> Buscar Clientes</h7>
		</div>
		<div class="panel-body">
			<table id="cliente" class="table table-hover table-striped" width="100%">  
				<thead>
					<tr class="info">
						<th>ID</th>
						<th>RUC/DNI</th>
						<th>RAZ&Oacute;N SOCIAL</th> 						
						<!--<th>TEL&Eacute;FONO</th>
						<th>CORREO</th>-->
						<th>DIRECCI&Oacute;N</th>
						<th>ESTADO</th>
						<th></th>
						<!--<th></th>-->
					</tr>
				</thead>										  
		   </table>		
					
		</div>
	</div>				
</div>


<div class="modal fade hmodal-success" id="modal_cliente" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header">
				<h2 class="modal-title">Agregar Cliente</h2>
				
			</div>
			<div class="modal-body" id="data_modi">
				<div class="row">			
					<form class="form-horizontal"  data-parsley-validate="true" enctype="multipart/form-data"   id="formcliente" method="post" role="form">
						<fieldset>
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-3">
									<label  for="medidas">RUC / DNI:</label>
								</div>
								<div class="col-md-4">
									<input align="right" autocomplete="off" required data-parsley-type="digits"  tabindex="1"  name="rucdni" type="text" class="form-control input-sm" id="rucdni" 
									placeholder="XXXXXXXXXXX" maxlength="11" > <!--data-parsley-range="[8,11]"-->
									<input align="right"  autocomplete="off" type="hidden"  name="idcli" id="idcli">									
								</div>
								<div class="col-md-5">
									<a id="BuscaCliente" class="btn btn-primary btn-icon btn-circle btn-sm"><i class="fa fa-search"></i></a>									
									<i id="res"></i>									
								</div>
							</div>
							<div class="row ">
								<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>      
								<div class="col-sm-3">
									<label  for="razon_social">Raz&oacute;n Social:</label>
								</div>
								<div class="col-md-9">
									<input type="text" tabindex="2" required data-type="alphanum"  required autocomplete="off" class="form-control input-sm" id="razon_social"
								   placeholder="Razón Social" style="width:100%" name="razon_social" maxlength="150">
								</div>									
							</div>							
							<div class="row ">
								<div class="col-sm-3">
									<label   for="dir">Direcci&oacute;n:</label>
								</div>
								<div class="col-md-9">
									<input type="text" style="width:100%" autocomplete="off" data-type="alphanum"    tabindex="3"  name="direccion" class="form-control input-sm" id="direccion" 
									placeholder="Dirección" maxlength="200">
								</div>
							</div>
							<div class="row ">
								<div class="col-sm-3">
									<label for="dir">E-mail:</label>
								</div>
								<div class="col-md-9">
									<input type="text" style="width:100%" autocomplete="off" required  tabindex="4" data-parsley-type="email"  name="mail" class="form-control input-sm" id="mail" 
									placeholder="E-mail" maxlength="30">
								</div>
							</div>
							<div class="row ">
								<div class="col-sm-3">
									<label for="valor">Tel&eacute;fono:</label>
								</div>
								<div class="col-md-4">
									<input type="telefono" autocomplete="off" tabindex="5"  name="telefono" style="width:100%" 
									class="form-control input-sm" id="telefono"	placeholder="Telefono" maxlength="11">
								</div> 
							</div>
							<div class="row" id="muestra_estado">
								<div class="col-sm-3">
									<input type="checkbox" id="estado" name="estado" value="AC"><label for="estado"> Estado</label>
								</div>
							</div>							
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-3">
									<label for="contacto">Contanto:</label>
								</div>
								<div class="col-md-8">
									<input type="text" autocomplete="off" tabindex="6" data-type="alphanum"  name="contacto"  class="form-control input-sm" id="contacto" 
										placeholder="Contacto" maxlength="150">									
								</div>
							</div>
							<div class="row">	
								<div class="col-sm-3">
									<label for="telefono_contacto">Telf: Contacto:</label>
								</div>
								<div class="col-md-8">
									<input type="text" autocomplete="off" tabindex="7"  name="telefono_contacto"  class="form-control input-sm" id="telefono_contacto" 
										placeholder="Telefono" maxlength="11">
								</div>
							</div>
							<div class="row">	
								<div class="col-sm-3">
									<label for="correo_contacto">Correo Contacto:</label>
								</div>
								<div class="col-md-8">
									<input type="text" style="width:100%" autocomplete="off" data-parsley-type="email"  tabindex="8"  name="correo_contacto" class="form-control input-sm" id="correo_contacto" 
										placeholder="E-mail" maxlength="30">
								</div>									
							</div>								
						</div>						
						</fieldset>
						
						<center>
							<br>
							<button type="submit" id="enviapersonal" class="btn btn-primary" >
							<i id="lienvia" class="fa fa-save"></i> Guardar</button>
							<button type="reset" data-dismiss="modal" class="btn btn-danger" >
							<i class="fa  fa-times"></i> Cerrar</button><br>	
										 
						</center>	
					</form>

				</div>
			</div>
		</div>
	</div>
</div>


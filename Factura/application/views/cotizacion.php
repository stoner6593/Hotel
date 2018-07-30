<div class="row">
	<form action="<?php echo base_url()?>cotizacion/addCotiza" class="form-horizontal"  enctype="multipart/form-data" id='form_cotizacion' method="POST" data-parsley-validate="true" >
		<div class="form-group row">
			<fieldset> <legend><a href="#"><i class="glyphicon glyphicon-edit"></i></a>  Cotizaci&oacute;n</legend>
				<div class="col-md-6">
					<div class="row">
						<div class="col-sm-3">
							<label  for="medidas">RUC / DNI:</label>
						</div>
						<div class="col-md-4">
							<input align="right" autocomplete="off" required data-parsley-type="digits"  tabindex="1"  name="rucdni" type="text" class="form-control input-sm" id="rucdni" 
							placeholder="XXXXXXXXXXX" maxlength="11"  data-parsley-minlength="[8]" > <!--data-parsley-range="[8,11]"-->
							<input align="right"  autocomplete="off" type="hidden"  name="idcli" id="idcli">									
						</div>
						<div class="col-md-5">
							<a id="BuscaClienteCoti" class="btn btn-primary btn-icon btn-circle btn-sm"><i class="fa fa-search"></i></a>									
							<i id="res"></i>									
						</div>
					</div>
					<div class="row ">
						<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>      
						<div class="col-sm-3">
							<label  for="razon_social">Raz&oacute;n Social:</label>
						</div>
						<div class="col-md-9">
							<input type="text" tabindex="2" readonly required data-type="alphanum"  required autocomplete="off" class="form-control input-sm" id="razon_social"
						   placeholder="Razón Social" style="width:100%" name="razon_social" maxlength="150">
						</div>									
					</div>							
					<div class="row ">
						<div class="col-sm-3">
							<label   for="dir">Direcci&oacute;n:</label>
						</div>
						<div class="col-md-9">
							<input type="text" style="width:100%" autocomplete="off" data-type="alphanum"  readonly   tabindex="3"  name="direccion" class="form-control input-sm" id="direccion" 
							placeholder="Dirección" maxlength="200">
						</div>
					</div>
					<div class="row ">
						<div class="col-sm-3">
							<label for="valor">Nota:</label>
						</div>
						<div class="col-md-9">
							<textarea cols="5" class=" form form-control" autocomplete="off" tabindex="6"  name="nota" id="nota" style="resize: none;" 	placeholder="Nota" maxlength="250"></textarea>
						</div> 
					</div>														
				</div>
				<div class="col-md-6">
					<div class="row ">
						<div class="col-sm-1">
							<label for="dir">E-mail:</label>
						</div>
						<div class="col-md-3">
							<input type="text" style="width:100%" autocomplete="off" readonly  tabindex="4" data-parsley-type="email"  name="mail" class="form-control input-sm" id="mail" 
							placeholder="E-mail" maxlength="30">
						</div>
					</div>
					<div class="row ">
						<div class="col-sm-1">
							<label for="valor">Tel&eacute;fono:</label>
						</div>
						<div class="col-md-3">
							<input type="telefono" autocomplete="off" readonly tabindex="5"  name="telefono" style="width:100%" 
							class="form-control input-sm" id="telefono"	placeholder="Telefono" maxlength="11">
						</div> 
					</div>														
				</div>						
			</fieldset>
		</div>

		<div class="row">			
			<div class="row">
				<div class="col-md-12">
						<div class="pull-right">
							<button type="button" class="btn btn-primary btn-xs m-r-5" data-toggle="modal" id="add_prod">
							 <span class="glyphicon glyphicon-plus"></span> Agregar productos
							</button>											
						</div>	
				</div>
			</div>			
		</div>
		<div class="table-responsive ">
			<table class="table table-striped table-hover" id="table_detalle_cotiza">
				<thead >
					<tr class='success'>				
						<th>Descripci&oacute;n</th>
						<th width="6%">Cantidad</th>				
						<th width="6%">Pre. Unit.</th>	
						<th width="6%">IGV</th>				
						<th width="6%">Sub Total</th>
						<th width="6%">Total</th>
						<th width="6%">#</th>
					</tr>
				</thead>
				<tbody>                                                                
				</tbody>
			</table>
			<div class="invoice-price">
		        <div class="invoice-price-left">
		            <div class="invoice-price-row">
		                <div class="sub-price">
		                    <small>SUBTOTAL</small>
		                    <p id="stot"></p>
		                </div>
		                <div class="sub-price">
		                    <i class="fa fa-plus"></i>
		                </div>
		                <div class="sub-price">
		                    <small>IGV (18%)</small>
		                    <p id="sigv"></p>
		                </div>
		            </div>
		        </div>
		        <div class="invoice-price-right">
		            <small>TOTAL</small> <i id="stt"></i> 
		        </div>
		    </div>
		</div>      
		<hr>
		<div class="row">			
			<div class="row">
				<div class="col-md-12">
						<div class="pull-right">
							<button type="submit" id="GuardaCotiza" class="btn btn-primary" >
							<i id="lienvia" class="fa fa-save"></i> Guardar</button>
							<button type="button" id="resetDormCotiza"  class="btn btn-default" >
							<i class="fa  fa-times"></i> Cancelar</button><br>										
						</div>	
				</div>
			</div>			
		</div>
	</form>
</div>

<!--<table id="ListaCotizaciones" class="table table-hover table-striped" width="100%">  </table>-->



<!--Modal-->

<div class="modal fade bs-example-modal-lg in" id="modal_productos_cotiza" data-backdrop="static" ><!--data-keyboard="false"-->
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><a href="#"><i class="fa fa-file-text"></i></a>  Item</h4>
            </div>
             <form data-parsley-validate="true" class="form-horizontal"   id="form_prod_cotiza" method="post" role="form">
                <div class="modal-body"> 
                    
                    <div class="row">
                         <div class="col-sm-2">
                            <label  for="medidas">Contenido:</label>
                        </div>
                        <div class="col-md-10">
                           <!--<textarea class="form-control" name="DesAdicional" id="DesAdicional"  rows="5" data-parsley-required="true" ></textarea>-->
                           <textarea class="textarea form-control" id="wysihtml5" name="descripcion" required  tabindex="1" placeholder="DESCRIPCIÓN DEL PRODUCTO O SERVICIO" rows="12"></textarea>
                        </div>                   
                    </div>
                    <div class="row ">
						<div class="col-sm-2">
							<label for="cantidad">Cantidad:</label>
						</div>
						<div class="col-md-3">
							<input type="numeric" autocomplete="off"   name="cantidad" style="width:100%" 
							class="form-control input-sm" id="cantidad" tabindex="2" 	placeholder="Cantidad" required maxlength="11">
						</div> 
					</div>
                    <div class="row ">
						<div class="col-sm-2">
							<label for="precio">Precio:</label>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" tabindex="3" autocomplete="false" name="precio_item" id="precio_item" required >							
						</div>
					</div>					
                </div>
                <div class="modal-footer">                    
                    <button class="btn btn-sm btn-primary" id="AgregarProdCotiza" type="submit"><i class="fa fa-times-circle"></i> <strong>Agregar</strong></button>
                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal" id="CerrarProdCotiza" ><i class="fa fa-times-circle"></i> Cerrar</a>
                </div>
            </form>    
        </div>
    </div>
</div>  

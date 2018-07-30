<div class="row">
	<div class="panel">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#default-tab-1" data-toggle="tab">Generar Documentos <i class="fa fa-file"></i></a> </li>
			<li class="" style="display:none"><a href="#default-tab-2" data-toggle="tab">Listado de Documentos <i class="fa fa-list"></i></a></li>
			<li class="" style="display:none"><a href="#default-tab-3" data-toggle="tab">Plan de Contingencia <i class="fa fa-arrows-v"></i><i class="fa fa-database"></i></a></li>
			<li class="" style="display:none"><a href="#default-tab-4" data-toggle="tab">Comunicaci&oacute;n de Baja <i class="fa fa-refresh"></i> <i class="fa fa-database"></i></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="default-tab-1">
				 <div class="hpanel hblue">
					<div class="panel-heading bg-info">               
						FACTURACI&Oacute;N ELECTR&Oacute;NICA V1.0
					</div>
					<div class="panel-body" style="display: block;">
						<form class="form-horizontal" action="<?php echo base_url()?>generaxml/generar_xml" data-parsley-validate="true"  id="documento" method="post" role="form"> 
							 <?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>               
							<div class="">                                            
									<div class="row ">                            
										<div class="row">
											<div class="col-md-3">
												<div class="row">
													<div class="col-sm-4">
														<label  for="medidas">Tipo de Documento:</label>
													</div>
													<div class="col-md-8">
														
														<select class="form-control selectpicker" data-size="10" name="tipo_documento" id="tipo_documento" data-live-search="true" data-style="btn-white" style="display: none;">
														<optgroup label="Documentos">
															<?php
																if($TipoDocumento):
																	foreach($TipoDocumento as $val):
															?>
															<option value="<?php echo $val['num_docu']?>"><?php echo $val['nombre_docu']?></option>
															<?php 
																	endforeach;
																endif;
															?>
														</optgroup>
													</select>    
													</div> 
												</div>
											</div>  
											<div class="col-md-2">
												<div class="row">
													<div class="col-sm-4">
														<label  for="medidas">C&aacute;lculo IGV:</label>
													</div>
													<div class="col-md-6">
														<input type="text" placeholder="IGV" class="form-control input-sm" value="0.18" id="calc_igv" name="calc_igv">
													</div> 
												</div>
											</div>
											<div class="col-md-2">
												<div class="row">
													<div class="col-sm-4">
														<label  for="medidas">C&aacute;lculo ISC:</label>
													</div>
													<div class="col-md-6">
														<input type="text" placeholder="ISC" value="0.10"  class="form-control input-sm" id="calc_isc" name="calc_isc">
													</div> 
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-sm-4">
														<label  for="medidas">C&aacute;lculo Detracci&oacute;n:</label>
													</div>
													<div class="col-md-4">
														<input type="text" value="0.04" class="form-control input-sm" name="cal_detraccion" id="cal_detraccion">
													</div> 
												</div>
											</div>          
										</div>
										<div class="row ">                                                       
											<div class="col-md-12">
												<fieldset><legend><b>Datos del Receptor</b></legend>
													<div class="row ">
														<div class="col-md-12">
															<div class="row">
																<div class="col-sm-1">
																	<label  for="TipoDoc">Tipo de Documento:</label>
																</div>
																<div class="col-md-2">                                                            
																	<select class="form-control selectpicker " data-size="10" name="TipoDocEmisor" id="TipoDocEmisor"  data-live-search="true" data-style="btn-white" style="display: none;">
																	<optgroup label="Documentos">
																		<?php
																			if($TipoDocumentoIdent):
																				foreach($TipoDocumentoIdent as $val):
																		?>
																		<option value="<?php echo $val['cod_docuident']?>"><?php echo $val['descripcion_docuident']?></option>
																		<?php 
																				endforeach;
																			endif;
																		?>                                                                
																	</optgroup>
																</select>    
																</div>                                                   
																<div class="col-sm-1">
																	<label  for="numdoc">Nro. Doc:</label>
																</div>
																<div class="col-md-2">
																	<input type="text" placeholder="N. Documento" data-parsley-maxlength="11" data-parsley-type="integer" data-parsley-required="true"  class="form-control input-sm" maxlength="11" name="DocReceptor" id="DocReceptor">
																</div>  
															
																<div class="col-sm-1">
																	<label  for="nomLegal">Nombre Legal:</label>
																</div>
																<div class="col-md-2">
																	<input type="text" placeholder="Nom. Legal" class="form-control input-sm" data-parsley-required="true"  name="NomLegalEmisor" id="NomLegalEmisor">
																</div>  
																<div class="col-sm-1">
																	<label  for="Direccion">Direcci&oacute;n:</label>
																</div>
																<div class="col-md-2">
																	<input type="text" placeholder="Dirección" class="form-control input-sm" id="DireccionEmisor" name="DireccionEmisor">
																</div>
															</div>                      
														</div>
													</div>      
												</fieldset>
											</div>  
										</div>  
										<hr>
										<div class="row">
											<div class="col-md-12">
												<div class="row "> 
													<div class="col-sm-2">
														<label  for="tipooperacion">Tipo Operaci&oacute;n:</label>                                            
														<select class="form-control selectpicker" data-size="10" name="TipoOperacion" id="TipoOperacion"  data-live-search="true" data-style="btn-white" style="display: none">
															<optgroup label="Tipo Operación">
															   
																 <?php
																	if($TipOpera):
																		foreach($TipOpera as $val):
																?>
																<option value="<?php echo $val['num_tipope'];?>"><?php echo $val['nombre_tipope'];?></option>
																<?php 
																		endforeach;
																	endif;
																?>
																
															</optgroup>
														</select>
													</div>
													<div class="col-sm-2">
														<label  for="montopercepcion">Monto Percepci&oacute;n:</label>                                            
														<input type="text" placeholder="Percepción" class="form-control input-sm" name="MontoPercepcion">
													</div>
													<div class="col-sm-2">
														<label  for="montopercepcion">Fecha Emisi&oacute;n:</label>                                           
														<input id="datapicker2" type="text" value="<?php echo date("m/d/Y");?>" name="fecharegistro" class="form-control input-sm">
													</div>                                       
													<div class="col-sm-1">
														<label  for="montoletras">Descuento Global:</label>                                            
														<input type="text" placeholder="Descuento Global" class="form-control input-sm" name="DescuentoGlobal">
													</div>
													<div class="col-sm-1">
														<label  for="montodetraccion">Moneda:</label>                                            
														<select class="form-control selectpicker" data-size="10" name="Moneda"  data-live-search="true" data-style="btn-white" style="display: none">
															<optgroup label="Tipo Moneda">
																<option value="PEN">Soles</option>
																<option value="USD">Dolares</option>
																
															</optgroup>
														</select>
													</div>
													<div class="col-sm-1">
														<label  for="montodetraccion">Monto Detracci&oacute;n:</label>                                           
														<input type="text" placeholder="Detracción" class="form-control input-sm" name="MontoDetraccion" id="MontoDetraccion">
													</div>
													<div class="col-sm-2">
														<button type="button" name="CalcularDetrac" id="CalcularDetrac" class="btn-xs btn-info">Calcular Detracci&oacute;n</button>
													</div>
													

												</div>
											</div>
										</div>  
										<div class="row">
											<fieldset> <legend><b>Regularizaci&oacute;n de Anticipos</b></legend>
												<div class="row col-md-10"> 
													<div class="col-sm-1">
														<label  for="tipooperacion">Tipo Doc. Anticipo:</label>
													</div>
													<div class="col-sm-2">
													   
														<select class="form-control selectpicker" data-size="10" name="TipoOperacionAnticipo" id="TipoOperacionAnticipo"  data-live-search="true" data-style="btn-white" style="display: none">
															<optgroup label="Tipo Operación">
																<?php
																	if($Anticipo):
																		foreach($Anticipo as $val):
																?>
																<option value="<?php echo $val['cod_anticipo']?>"><?php echo $val['descripcion_anticipo']?></option>
																<?php 
																		endforeach;
																	endif;
																?>
																
															</optgroup>
														</select>
													</div>
													<div class="col-sm-1">
														<label  for="montopercepcion">Doc. Anticipo:</label>
													</div>  
													<div class="col-sm-1">
														<input type="text"  class="form-control input-sm" name="DocAnticipo">
													</div>
													<div class="col-sm-1">
														<label  for="montopercepcion">Monto Anticipo:</label>
													</div>
													<div class="col-sm-1">
														<input type="text" class="form-control input-sm" name="Monto Anticipo">
													</div>                                       
												   
													<div class="col-sm-1">
														<label  for="montodetraccion">Moneda Anticipo:</label>
													</div>  
													<div class="col-sm-1">
													   <select class="form-control selectpicker" data-size="10" name="MonedaAnticipo"  data-live-search="true" data-style="btn-white" style="display: none">
															<optgroup label="Tipo Moneda">
																<option value="PEN">Soles</option>
																<option value="USD">Dolares</option>
																
															</optgroup>
														</select>
													</div>
												</div>
											</fieldset>
										</div>
										<div class="row">
											<div class="col-md-12 ui-sortable"> 
												<ul class="nav nav-tabs">
													<li class="active"><a href="#nav-pills-tab-1" data-toggle="tab">Detalle de Documentos</a></li>
													<li><a href="#nav-pills-tab-2" data-toggle="tab">Datos Adicionales</a></li>
													<li><a href="#nav-pills-tab-3" data-toggle="tab">Documentos Relacionados</a></li>
													<li><a href="#nav-pills-tab-4" data-toggle="tab">Discrepancias</a></li>
												</ul>                                           
												<div class="panel">
													<div class="tab-content">
														<div class="tab-pane fade active in" id="nav-pills-tab-1">                                                  
															<a href="#" class="btn btn-info btn-xs m-r-5" id="modal_detalle" ><i class="fa fa-plus-square"></i> Agregar</a>
															<!--<table id="datatable" class="table table-striped table-bordered nowrap" width="100%">                                                       
															</table>-->
															<div class="table-responsive">
																<table class="table table-striped table-hover" id="table">
																	<thead >
																		<tr class='success'>
																			<th>Cod. Item</th>
																			<th>Descripci&oacute;n</th>
																			<th>Cantidad</th>
																			<th>Uni. Med</th>
																			<th>Pre. Unit.</th>
																			<th>Pre. Ref.</th>
																			<th>Tipo Precio</th>
																			<th>Impuesto</th>
																			<th>Tipo Impuesto</th>
																			<th>ISC</th>
																			<th>Otro Impuesto</th>
																			<th>Sub Total</th>
																			<th>Total</th>
																			<th>#</th>
																		</tr>
																	</thead>
																	<tbody>                                                                
																	</tbody>
																</table>
															</div>                                                    
															<div class="row">
																<div class="col-md-10">
																	<div class="row">                                                               
																		<div class="col-sm-2"><label  for="Gravadas">Total Gravadas:</label></div>
																		<div class="col-sm-2"><input type="text" value="0.00" name="TotGravada" id="TotGravada" class="form-control input-sm"></div>
																			
																	</div>
																	<div class="row">
																		<div class="col-sm-2"><label  for="Exoneradas">Total Exoneradas:</label></div>
																		<div class="col-sm-2"><input type="text" value="0.00" name="TotExoneradas" id="TotExoneradas" class="form-control input-sm"></div>
																	</div>
																	<div class="row">
																		<div class="col-sm-2"><label  for="Inafectas">Total Inafectas:</label></div>
																		<div class="col-sm-2"><input type="text" value="0.00" name="TotInafectas" id="TotInafectas" class="form-control input-sm"></div>
																	</div>
																	<div class="row">
																		<div class="col-sm-2"><label  for="Gratuitas">Total Gratuitas:</label></div>
																		<div class="col-sm-2"><input type="text" value="0.00" name="TotGratuitas" id="TotGratuitas" class="form-control input-sm"></div>
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="row ">                                                              
																		<div class="col-sm-5"><label  for="Gravadas">Total IGV:</label></div>
																		<div class="col-sm-6"><input type="text" value="0.00" name="TotIgv" id="TotIgv" class="form-control input-sm"></div>
																			
																	</div>
																	<div class="row  ">
																		<div class="col-sm-5"><label  for="Exoneradas">Total ISC:</label></div>
																		<div class="col-sm-6"><input type="text" value="0.00" name="TotIsc" id="TotIsc" class="form-control input-sm"></div>
																	</div>
																	<div class="row">
																		<div class="col-sm-5"><label  for="Inafectas">Otros Tributos:</label></div>
																		<div class="col-sm-6"><input type="text" value="0.00" name="TotOtrosTributos"  id="TotOtrosTributos" class="form-control input-sm"></div>
																	</div>
																	<div class="row">
																		<div class="col-sm-5"><label  for="Gratuitas">Total Venta:</label></div>
																		<div class="col-sm-6"><input type="text" value="0.00" name="TotVenta" id="TotVenta" class="form-control input-sm"></div>
																	</div>
																</div>
																
															</div>
																	
														</div>
														<div class="tab-pane fade" id="nav-pills-tab-2">
															<a href="#" class="btn btn-info btn-xs m-r-5" id="modal_adicional" ><i class="fa fa-plus-square"></i> Agregar</a>
															<div class="table-responsive">
																<table class="table table-striped table-hover" id="table_adicional">
																	<thead >
																		<tr class='success'>
																			<th>C&oacute;digo</th>
																			<th>Descripci&oacute;n</th>                                                                                        
																			<th>#</th>
																		</tr>
																	</thead>
																	<tbody>                                                                
																	</tbody>
																</table>
															</div> 
														</div>
														<div class="tab-pane fade" id="nav-pills-tab-3">
															<a href="#" class="btn btn-info btn-xs m-r-5" id="modal_relacionados" ><i class="fa fa-plus-square"></i> Agregar</a>
															<div class="table-responsive">
																<table class="table table-striped table-hover" id="table_relacionados">
																	<thead >
																		<tr class='success'>
																			<th>Tipo de Documento</th>
																			<th>Nro. Documento</th>                                                                                        
																			<th>#</th>
																		</tr>
																	</thead>
																	<tbody>                                                                
																	</tbody>
																</table>
															</div>
														</div>
														<div class="tab-pane fade" id="nav-pills-tab-4">
															<a href="#" class="btn btn-info btn-xs m-r-5" id="modal_discrepancia" ><i class="fa fa-plus-square"></i> Agregar</a>
															<div class="table-responsive">
																<table class="table table-striped table-hover" id="table_discrepancia">
																	<thead >
																		<tr class='success'>
																			<th>Nro. Referencia</th>
																			<th>Tipo</th>
																			<th>Descripci&oacute;n</th>                                                                                        
																			<th>#</th>
																		</tr>
																	</thead>
																	<tbody>                                                                
																	</tbody>
																</table>
															</div>
															
														</div>
													</div>
												</div>
											</div>
										</div>
										
									</div>
							   
							</div>
							<div class="">
								<a href="javascript:;" class="btn btn-white" ><i class="fa fa-file"></i> Nuevo</a>
								<button type="submit" id="GuardarVenta" class="btn  btn-primary"><i id="lienvia2" class="fa fa-file-code-o"></i> Generar</button>
								<!--<a href="javascript:;" onclick="grabaTodoTabla('table')" class="btn btn-sm btn-primary"><i class="fa fa-file-code-o"></i> Generar</a>-->
							</div>
						</form>                                  
					</div>
				</div>    
			</div>
			<div class="tab-pane fade" id="default-tab-2">
				<div class="hpanel hblue">
					<div class="panel-heading bg-info">               
					   B&Uacute;SQUEDA DE DOCUMENTOS
					</div>
					<div class="panel-body" style="display: block;">
						<div class="col-md-12">
						   <form class="form-horizontal" data-parsley-validate="true"  id="BuscarDocumentos" method="post" role="form"> 
								<div class="row">
									<div class="form-group">
										<label class="col-sm-5 col-xs-12 control-label">RUC/DNI Cliente:</label>
										<div class="col-md-2 col-sm-4 col-xs-12">
											<input type="text" class="form-control" placeholder="00000000000" autocomplete="false" id="DocCliBus" name="DocCliBus"  data-parsley-maxlength="11" data-parsley-type="integer" />
										</div>
									</div> 
									<div class="form-group">
										<label for="cmbTipoServicio" class="col-sm-5 col-xs-12 control-label">Tipo de Documento:<!--<span style="color:red"> (*)--></span></label>
										<div class="col-md-2 col-sm-4 col-xs-12">
											<select class="form-control selectpicker" data-parsley-required="true" data-size="10" id="cmbTipoServicio" name="cmbTipoServicio" data-live-search="true" data-style="btn-white" style="display: none;">
											   <optgroup label="Documentos">
													<?php
														if($TipoDocumento):
															foreach($TipoDocumento as $val):
													?>
													<option value="<?php echo $val['num_docu']?>"><?php echo $val['nombre_docu']?></option>
													<?php 
															endforeach;
														endif;
													?>
												</optgroup>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5 col-xs-12 control-label">N&deg;. Documento:</label>                                                    
										<div class="col-md-2 col-sm-4 col-xs-12">
											<input type="text" class="form-control" placeholder="xxxx-xxxxxxxx" autocomplete="false" id="NumDocBuscar" name="NumDocBuscar" />

										</div>
									</div> 
									<div class="form-group">
										<label class="col-sm-5 col-xs-12 control-label">Fecha de Env&iacute;o:</label>
										<div class="col-md-2 col-sm-4 col-xs-12">
											<input type="text" class="form-control" id="datepicker-default" data-parsley-required="true" value="<?php echo date('m-d-Y');?>" />
										</div>
									</div>

								</div>
								<div class="row" >
									<div class="col-md-2 col-sm-4 col-sm-offset-5" align="center">
										<div align="left" class="col-xs-6" >
											<button id="btnBuscar" class="btn btn-primary btn-sm" type="submit" value="Buscar" name="btnBuscar">
												<i class="fa fa-search"></i> Buscar
											</button>
										</div>
										<div align="right" class="col-xs-6" >
											<button id="btnLimpiar" class="btn btn-default btn-sm" type="reset" value="Limpiar" name="btnLimpiar">
												<i class="glyphicon glyphicon-trash"></i> Limpiar
											</button>
										</div>
									</div>
								</div>

						   </form>
						</div>  
					   <table id="example" class="table table-hover table-striped" width="100%">  
							<thead>
								<tr class="success">
									<th>RUC/DNI</th>
									<th>Cliente</th> 
									<th>Nro. Correlativo</th>
									<th>Total</th>
									<th>Cod. Estado</th>
									<th>Descripci&oacute;n</th>
									<th>XML</th>
									<th>CDR</th>
									<th>PDF</th>
								</tr>
							</thead>
										  
					   </table>
					</div>
				</div>    

			</div>
			<div class="tab-pane fade" id="default-tab-3">                            
				<div class="hpanel hblue">
					<div class="panel-heading bg-info">               
						FACTURACI&Oacute;N ELECTR&Oacute;NICA V1.0
					</div>
					<div class="panel-body" style="display: block;">
						 <form role="form" id="form" enctype="multipart/form-data" data-parsley-validate="true"  method="post">
							<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>  
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>URL del Servicio</label> 
										<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white" style="display: none;">
											<optgroup label="URL SUNAT">
												<option value="https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService">Desarrollo</option>
												<option value="https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService">Homologaci&oacute;n</option>
												<option value="https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService">Producci&oacute;n</option>
												<option value="https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService">Retenci&oacute;n/Percepci&oacute;n Desarrollo
												</option>
												<option value="https://www.sunat.gob.pe:443/ol-ti-itemision-otroscpe-gem/billService">Retenci&oacute;n/Percepci&oacute;n Producci&oacute;n</option>
											</optgroup>
										</select> 

									</div>
								</div>
								<div class="col-md-6">
									<p class="pager" >
										<!--<button type="button" data-toggle="modal" data-target="#myModal5" class="btn btn-primary"><i class="fa fa-server"></i> Documentos</button>-->
										<!--<a href="#modal-message" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fa fa-server"></i> Documentos</a>-->
									</p>

								</div>                          
							</div>
							<div class="row">
								<fieldset><legend><h6><strong>Grupo de Opciones</strong> </h6></legend>
									<div class="col-md-12">                             
										<div class="radio radio-info radio-inline ">
											<input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="">
											<label for="inlineRadio1"> Factura, Boleta, NC, ND </label>
										</div>
										<div class="radio radio-info radio-inline">
											<input type="radio" id="inlineRadio2" value="option2" name="radioInline">
											<label for="inlineRadio2"> Retenciones y Percepciones </label>
										</div>
										<div class="radio radio-info radio-inline ">
											<input type="radio" id="inlineRadio2" value="option2" name="radioInline">
											<label for="inlineRadio2">Resumen y Comunicaci&oacute;n de Baja</label>
										</div>
									</div>
								</fieldset>                             
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									 <div class="form-group">
										<label>N&uacute;mero de RUC</label> 
										<input type="text" placeholder="RUC" class="form-control input-sm" name="rucempresa" placeholder="Required" data-parsley-required="true">
									</div>
								</div>
								<div class="col-md-6">
									 <div class="form-group">
										<label>Tipo de Documento</label> 
										<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white" style="display: none;">
											<optgroup label="Documentos">
												 <?php
													if($TipoDocumento):
														foreach($TipoDocumento as $val):
												?>
												<option value="<?php echo $val['num_docu']?>"><?php echo $val['nombre_docu']?></option>
												<?php 
														endforeach;
													endif;
												?>
											</optgroup>
										</select>    
									</div>
								</div>                          
							</div>
							<div class="row">
								<div class="col-md-6">
									 <div class="form-group">
										<label>Usuario SOL</label> 
										<input type="text" placeholder="Usuario Sol" class="form-control input-sm" name="usuario_sol" placeholder="Required" data-parsley-required="true">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Clave SOL</label> 
										<input type="text" placeholder="Clave Sol" class="form-control input-sm" name="clave_sol" placeholder="Required" data-parsley-required="true">
									</div> 
								</div>                          
							</div>
							
							<div class="row">                           
								<div class="col-md-6">
									<div class="form-group">
										<label>Documento XML</label>                                    
										<input id="url_xml" name="url_xml" type="file" data-show-upload="false" class="file" data-allowed-file-extensions='["xml"]' data-show-preview="false">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Serie-Numeraci&oacute;n</label> 
										<input type="text" placeholder="Serie-Numeración" class="form-control input-sm" name="ser_numera" placeholder="Required" data-parsley-required="true">
									</div>      
								</div>
							</div>
												 
							<div>
								<button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Submit</strong></button>
							</div>
						</form>
					</div>              
				</div>                            
			</div>
			<div class="tab-pane fade " id="default-tab-4">
				<div class="hpanel hblue">
					<div class="panel-heading bg-info">               
					  ANULAR DOCUMENTOS EMITIDOS
					</div>
					<div class="panel-body" style="display: block;">
						 <div class="col-md-12">
							<form class="form-horizontal" data-parsley-validate="true"  id="GuardaDocAnula" method="post" role="form"> 
								<div class="row">                                                
									<div class="form-group">
										 <?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>      
										<label for="cmbTipoServicio" class="col-sm-5 col-xs-12 control-label">Tipo de Documento:<!--<span style="color:red"> (*)--></span></label>
										<div class="col-md-2 col-sm-4 col-xs-12">
											<select class="form-control selectpicker" data-parsley-required="true" data-size="10" id="TipDocAnula" name="TipDocAnula" data-live-search="true" data-style="btn-white" style="display: none;">
											   <optgroup label="Documentos">
													<?php
														if($TipoDocumento):
															foreach($TipoDocumento as $val):
													?>
													<option value="<?php echo $val['num_docu']?>"><?php echo $val['nombre_docu']?></option>
													<?php 
															endforeach;
														endif;
													?>
												</optgroup>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5 col-xs-12 control-label">Serie:</label>
										<div class="col-md-2 col-sm-4 col-xs-12">
											<input type="text" class="form-control" placeholder="xxxx" autocomplete="false" id="SerieAnula" name="SerieAnula" maxlength="4" data-parsley-maxlength="4" data-parsley-minlength="4"  data-parsley-required="true"/>
										</div>
									</div> 
									<div class="form-group">
										<label class="col-sm-5 col-xs-12 control-label">N&deg;. Documento:</label>                                                    
										<div class="col-md-2 col-sm-4 col-xs-12">
											<input type="text" class="form-control" placeholder="xxxxxxxx" autocomplete="false" maxlength="8" data-parsley-maxlength="8" id="NumDocBuscarAnula" name="NumDocBuscarAnula"  data-parsley-required="true" data-parsley-minlength="8" data-parsley-type="integer"/>

										</div>
									</div> 
									<div class="form-group">
										<label class="col-sm-5 col-xs-12 control-label">Motivo:</label>
										<div class="col-md-2 col-sm-4 col-xs-12">
											<textarea class="form-control" name="MotivoAnula" id="MotivoAnula"  rows="5" data-parsley-required="true" ></textarea>
										</div>
									</div>

								</div>
								<div class="row" >
									<div class="col-md-2 col-sm-4 col-sm-offset-5" align="center">
										<div align="left" class="col-xs-6" >
											<button id="btnBuscar" class="btn btn-primary btn-sm" type="submit" value="aGREGAR" name="btnBuscar">
												<i class="fa fa-save"></i> Agregar
											</button>
										</div>
										<div align="right" class="col-xs-6" >
											<button id="btnLimpiar" class="btn btn-default btn-sm" type="reset" value="Limpiar" name="btnLimpiar">
												<i class="fa fa-file-o"></i> Limpiar
											</button>
										</div>
									</div>
								</div>

								<div class="col-md-8 col-sm-10 col-sm-offset-2" align="center">
									<div class="table-responsive">
										<table class="table table-striped table-hover" id="tableAnula">
											<thead >
												<tr class='success'>                                                       
													<th>Tip. Docu.</th>                                                     
													<th>Serie</th>
													<th>Correlativo</th>
													<th>Motivo</th>                                                        
													<th>#</th>
												</tr>
											</thead>
											<tbody>                                                                
											</tbody>
										</table>
									</div> 
								</div>
								<div class="row" >
									<div class="col-md-2 col-sm-4 col-sm-offset-5" align="center">
										<div align="left" class="col-xs-6" >
											<button id="btnAlular" class="btn btn-primary btn-sm" type="button" value="Buscar" name="btnAlular">
												<i class="fa fa-file-code-o" id="liAnula"></i> Generar
											</button>
										</div>
										<div align="right" class="col-xs-6" >
											<button id="btnLimpiarAnula" class="btn btn-default btn-sm" type="reset" value="Limpiar" name="btnLimpiarAnula">
												<i class="fa fa-file-o"></i> Nuevo
											</button>
										</div>
									</div>
								</div>   
							</form>                                           
						</div>                                                                       
					</div>
				</div>    
			 </div>
		</div>
	</div>
			
</div>

 <!-- #modal-dialog -->
	<div class="modal fade" id="modal-dialog" data-backdrop="static" ><!--data-keyboard="false"-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Detalle de Producto</h4>
				</div>
                 <form data-parsley-validate="true" class="form-horizontal"   id="detalle_producto" method="post" role="form">
    				<div class="modal-body">    				   
                    	
                        <div class="row">
                             <div class="col-sm-3">
                                <label  for="medidas">C&oacute;digo Item:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" autocomplete="false" autofocus="true" name="codprod" id="codprod" data-parsley-required="true" data-parsley-type="alphanum">
                            </div>                   
                        </div>
                        <div class="row">
                             <div class="col-sm-3">
                                <label  for="medidas">Descripci&oacute;n:</label>
                            </div>
                            <div class="col-md-6">
                               <textarea class="form-control" name="desprod" id="desprod"  rows="5" data-parsley-required="true" ></textarea>
                            </div>                   
                        </div>
                         <div class="row">
                             <div class="col-sm-3">
                                <label  for="medidas">Precio Unitario:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" autocomplete="false" name="preuniprod" id="preuniprod" data-parsley-required="true" data-parsley-pattern="^\d+(.\d+)?$">
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Precio Referencial:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" autocomplete="false" data-parsley-required="true" value="0.00" name="prerefprod" id="prerefprod">
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Tipo de Precio:</label>
                            </div>
                            <div class="col-md-6">
                               <select class="form-control selectpicker" data-size="10" name="tipprecioprod" id="tipprecioprod" data-live-search="true" data-style="btn-white" style="display: none;" data-parsley-required="true">
                                    <optgroup label="Tipo Precio">
                                    <?php
                                        if($TipoPrecio):
                                            foreach($TipoPrecio as $val):
                                    ?>
                                    <option value="<?php echo $val['param_codparam'];?>"><?php echo $val['param_descripcion'];?></option>
                                    <?php 
                                            endforeach;
                                        endif;
                                    ?>
                                    </optgroup>
                                </select>    
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Cantidad:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm"  autocomplete="false" name="cantidadprod" id="cantidadprod" data-parsley-required="true" data-parsley-type="integer">
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Unidad Medida:</label>
                            </div>
                            <div class="col-md-6">
                                 <select class="form-control selectpicker" data-size="10" name="unimedprod" id="unimedprod" data-live-search="true" data-style="btn-white" style="display: none;" data-parsley-required="true">
                                    <optgroup label="Uni. Medida">
                                    <?php
                                        if($UniMedida):
                                            foreach($UniMedida as $val):
                                    ?>
                                    <option value="<?php echo $val['param_codparam'];?>"><?php echo $val['param_descripcion'];?></option>
                                    <?php 
                                            endforeach;
                                        endif;
                                    ?>
                                    </optgroup>
                                </select>   
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Impuesto:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" value="0.00" name="impuestoprod" id="impuestoprod" data-parsley-required="true">
                            </div>                   
                        </div>
                         <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Tipo Impuesto:</label>
                            </div>
                            <div class="col-md-6">
                                 <select class="form-control selectpicker" data-size="10" name="tipoimpuestoprod" id="tipoimpuestoprod" data-live-search="true" data-style="btn-white" style="display: none;" data-parsley-required="true">
                                    <optgroup label="Tipo Impuesto">
                                    <?php
                                        if($TipoImpuesto):
                                            foreach($TipoImpuesto as $val):
                                    ?>
                                    <option value="<?php echo $val['param_codparam'];?>"><?php echo $val['param_descripcion'];?></option>
                                    <?php 
                                            endforeach;
                                        endif;
                                    ?>
                                    </optgroup>
                                </select>   
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Impuesto Selectivo:</label>
                            </div>
                            <div class="col-md-6">
                                   <input type="text" class="form-control input-sm" value="0.00" name="totiscprod" data-parsley-pattern="^\d+(.\d+)?$" id="totiscprod">
                            </div> 
                            <div class="col-sm-2">
                                 <!--<button class="btn btn-xs btn-success" id="CalculaISC"><i class="fa fa-times-circle"></i> <strong>Calcula ISC</strong></button>-->
                                 <a href="javascript:;" class="btn btn-xs btn-success" id="CalculaISC" ><i class="fa fa-table"></i> Calcula ISC</a>                                 
                            </div>                  
                        </div>                        
                         <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Otro Impuesto:</label>
                            </div>
                            <div class="col-md-6">
                                 <input type="text" class="form-control input-sm" value="0.00" name="otroimpuestoprod" id="otroimpuestoprod">
                            </div>                   
                        </div>
                         <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Sub Total:</label>
                            </div>
                            <div class="col-md-6">
                                 <input type="text" class="form-control input-sm" value="0.00" name="subtotalprod" id="subtotalprod">
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label  for="medidas">Total:</label>
                            </div>
                            <div class="col-md-6">
                                 <input type="text" class="form-control input-sm" value="0.00" name="totalprod" id="totalprod" data-parsley-required="true">
                            </div>                   
                        </div>
    				</div>
    				<div class="modal-footer">
    					<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal" id="CerrarDetalle" ><i class="fa fa-times-circle"></i> Cerrar</a>
                        <button class="btn btn-sm btn-success" id="AgregarDetalle" type="submit"><i class="fa fa-times-circle"></i> <strong>Agregar</strong></button>
    				</div>
                </form>    
			</div>
		</div>
	</div>   

    <!--Datos Adicionales-->
    <div class="modal" id="modal_adicionales" data-backdrop="static" ><!--data-keyboard="false"-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Datos Adicionales</h4>
                </div>
                 <form data-parsley-validate="true" class="form-horizontal"   id="datos_adicionales" method="post" role="form">
                    <div class="modal-body"> 
                        <div class="row">
                             <div class="col-sm-3">
                                <label  for="medidas">C&oacute;digo :</label>
                            </div>
                            <div class="col-md-6">
                                 <select class="form-control selectpicker" data-size="10" name="CodDatoAdicional" id="CodDatoAdicional" data-live-search="true" data-style="btn-white" style="display: none;" data-parsley-required="true">
                                    <optgroup label="Tipo Precio">
                                    <?php
                                        if($DatosAdicionales):
                                            foreach($DatosAdicionales as $val):
                                    ?>
                                    <option value="<?php echo $val['cod_adicional'];?>"><?php echo $val['descripcion_adicional'];?></option>
                                    <?php 
                                            endforeach;
                                        endif;
                                    ?>
                                    </optgroup>
                                </select> 
                            </div>                   
                        </div>
                        <div class="row">
                             <div class="col-sm-3">
                                <label  for="medidas">Contenido:</label>
                            </div>
                            <div class="col-md-6">
                               <textarea class="form-control" name="DesAdicional" id="DesAdicional"  rows="5" data-parsley-required="true" ></textarea>
                            </div>                   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal" id="CerrarAdicional" ><i class="fa fa-times-circle"></i> Cerrar</a>
                        <button class="btn btn-sm btn-success" id="AgregarAdicional" type="submit"><i class="fa fa-times-circle"></i> <strong>Agregar</strong></button>
                    </div>
                </form>    
            </div>
        </div>
    </div>  

    <!--Documento Relacionado-->
    <div class="modal" id="modal_docrelacionado" data-backdrop="static" ><!--data-keyboard="false"-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Documento Relacionado</h4>
                </div>
                 <form data-parsley-validate="true" class="form-horizontal"   id="datos_docrelacionado" method="post" role="form">
                    <div class="modal-body"> 
                        <div class="row">
                             <div class="col-sm-3">
                                <label  for="medidas">Tipo Documento :</label>
                            </div>
                            <div class="col-md-6">
                                 <select class="form-control selectpicker" data-size="10" name="CodDocRelacionado" id="CodDocRelacionado" data-live-search="true" data-style="btn-white" style="display: none;" data-parsley-required="true">
                                    <optgroup label="Tipo Precio">
                                    <?php
                                        if($DocRelacionados):
                                            foreach($DocRelacionados as $val):
                                    ?>
                                    <option value="<?php echo $val['cod_relacionado'];?>"><?php echo $val['des_relacionado'];?></option>
                                    <?php 
                                            endforeach;
                                        endif;
                                    ?>
                                    </optgroup>
                                </select> 
                            </div>                   
                        </div>
                        <div class="row">
                             <div class="col-sm-3">
                                <label  for="medidas">Num. Documento:</label>
                            </div>
                            <div class="col-md-6">
                               <input type="text" class="form-control input-sm"  name="docuRelacionado" data-parsley-required="true" id="docuRelacionado">
                            </div>                   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal" id="CerrarDetalle" ><i class="fa fa-times-circle"></i> Cerrar</a>
                        <button class="btn btn-sm btn-success" id="AgregarRelacionado" type="submit"><i class="fa fa-times-circle"></i> <strong>Agregar</strong></button>
                    </div>
                </form>    
            </div>
        </div>
    </div>    

     <!--Discrepancia-->
    <div class="modal" id="modal_discrepancias" data-backdrop="static" ><!--data-keyboard="false"-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Discrepancias</h4>
                </div>
                 <form data-parsley-validate="true" class="form-horizontal"   id="datos_discrepancias" method="post" role="form">
                    <div class="modal-body" id="carga_discrepancia"> 
                        
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal" id="CerrarDetalle" ><i class="fa fa-times-circle"></i> Cerrar</a>
                        <button class="btn btn-sm btn-success" id="AgregarDiscrepancia" type="submit"><i class="fa fa-times-circle"></i> <strong>Agregar</strong></button>
                    </div>
                </form>    
            </div>
        </div>
    </div>    
  
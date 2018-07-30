
<div class="row">
     <div class="col-sm-3">
        <label  for="medidas">C&oacute;digo :</label>
    </div>
    <div class="col-md-6">
         <select class="form-control selectpicker" data-size="10" name="TipDiscrepancia" id="TipDiscrepancia" data-live-search="true" data-style="btn-white"  data-parsley-required="true">
            <optgroup label="Tipo Discrepancias">
            <?php
                if($Discrepancias):
                    foreach($Discrepancias as $val):
            ?>
            <option value="<?php echo $val['codigo_discre'];?>"><?php echo $val['descripcion_discre'];?></option>
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
        <label  for="medidas">Num. Referencia:</label>
    </div>
    <div class="col-md-6">
       <input type="text" class="form-control input-sm"  data-parsley-required="true" name="NumReferenciaDis" id="NumReferenciaDis">
    </div>                   
</div>
<div class="row">
     <div class="col-sm-3">
        <label  for="medidas">Descripci&oacute;n:</label>
    </div>
    <div class="col-md-6">
       <input type="text" class="form-control input-sm"  name="DesReferenciaDis" id="DesReferenciaDis">
    </div>                   
</div>
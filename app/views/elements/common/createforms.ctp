<?php
// debug($modelfields); 
// debug($this->data);
	foreach ($modelfields as $kkey => $kvalue) {		
			$getOptions = $this->MatInflector->getOptions($model,$kvalue['TableDesc']['COLUMN_NAME']);
		?>	
		<?php if( $getOptions['success'] ){?>

			<div class="" id="div_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>">
		        <label><?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']); ?></label>
		        <a style="float: right;" class='btn-xs btn btn-success quick_manage' data-model="<?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']);?>" data-select="form_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>" >Manage</a>
				<select id="form_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>" class="form-control" name="data[<?php echo $model;?>][<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>]" <?php echo $modelfieldsreadOnly[$kvalue['TableDesc']['COLUMN_NAME']]?'readonly="readonly" disabled="disabled"':''; ?> >

					<option value="" selected >Select <?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']); ?></option>

					<?php  foreach ($getOptions['options'] as $optionkey => $optionvalue) { ?>

						  	<option value="<?php echo $optionkey ?>" <?php echo $this->data[$model][$kvalue['TableDesc']['COLUMN_NAME']] == $optionkey?"selected":""; ?> ><?php echo $optionvalue ?></option>

					<?php } ?>                  

                </select>
		    </div>
		    <br>
		
		<?php } elseif( in_array( $kvalue['TableDesc']['COLUMN_NAME'],array('id')) && $kvalue['TableDesc']['COLUMN_KEY'] == 'PRI' ){?>

			<div class="" id="div_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>"> 
		        <label><?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']); ?></label>
		        <input id="form_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>" type="text" class="form-control" readonly="readonly" name="data[<?php echo $model;?>][<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>]" value="<?php echo $this->data[$model][$kvalue['TableDesc']['COLUMN_NAME']]; ?>" >
		    </div>

		<?php } elseif( in_array( $kvalue['TableDesc']['COLUMN_NAME'],array('password')) ){?>

			<div class="" id="div_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>"> 
		        <label><?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']); ?></label>
		        <input id="form_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>" type="password" class="form-control" name="data[<?php echo $model;?>][<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>]" value="<?php echo $this->data[$model][$kvalue['TableDesc']['COLUMN_NAME']]; ?>" >
		    </div>

		<?php } elseif( in_array( $kvalue['TableDesc']['DATA_TYPE'],array('char','varchar','int')) ) {?>

			<div class="" id="div_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>">
		        <label><?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']); ?></label>
		        <input id="form_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>" class="form-control" name="data[<?php echo $model;?>][<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>]"  value="<?php echo $this->data[$model][$kvalue['TableDesc']['COLUMN_NAME']]; ?>" <?php echo $modelfieldsreadOnly[$kvalue['TableDesc']['COLUMN_NAME']]?'readonly="readonly" disabled="disabled"':''; ?> >
				
				<?php if( !empty( $modelfieldErrors[$kvalue['TableDesc']['COLUMN_NAME']] ) ) ?>
		        	 <p class="" style="color: red;"><?php echo $modelfieldErrors[$kvalue['TableDesc']['COLUMN_NAME']]; ?></p>
		    </div>
		
	    <?php }  elseif( in_array( $kvalue['TableDesc']['DATA_TYPE'],array('tinyint')) ){?>	

		    <div class="form-group">	                
	                <div class="checkbox">
	                    <label>
	                    	<input type="hidden" name="data[<?php echo $model;?>][<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>]" value="0">
	                        <input type="checkbox" name="data[<?php echo $model;?>][<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>]" value="1" <?php echo $this->data[$model][$kvalue['TableDesc']['COLUMN_NAME']]==1 || !isset($this->data[$model][$kvalue['TableDesc']['COLUMN_NAME']]) ?"checked":""; ?> > <?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']); ?>
	                    </label>
	                </div>
	            </div>

		<?php }  else { ?>
	
			<div class="" id="div_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>">
		        <label><?php echo $this->MatInflector->camelize($kvalue['TableDesc']['COLUMN_NAME']); ?></label>
		        <input id="form_<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>" class="form-control" name="data[<?php echo $model;?>][<?php echo $kvalue['TableDesc']['COLUMN_NAME'];?>]" value="<?php echo $this->data[$model][$kvalue['TableDesc']['COLUMN_NAME']]; ?>">
		       
		    </div>

		<?php } ?>
<?php } ?>

<?php echo $this->element('/common/scriptforms'); ?>
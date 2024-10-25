	<div class="modal_title_details"><h4><?php echo $this->lang->line('edit_category');?></h4></div>
        <form class="form-sample" id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/monthly_subscription_for_company_users/monthly_subscription_for_company_users/update" method="POST">
        <input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('concept'); ?></label>
		<textarea class="form-control" name="concept" rows="4"><?php echo $data['concept']; ?></textarea> 
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('price');?></label>
         <input type="text" class="form-control" name="price" value="<?php echo $data['price']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('currency');?></label>
		 <select id="currencySelect" class="form-control" name="currency">
        <option value="0">Seleccione una opción</option>
        <option value="MXN" <?php if( $data['currency']=='MXN'){ echo'selected'; }?>>MXN</option>
        <option value="USA" <?php if( $data['currency']=='USA'){ echo'selected'; }?>>USA</option>
        <option value="EUR" <?php if( $data['currency']=='EUR'){ echo'selected'; }?>>EUR</option>
    </select>
	</div>
	<div class="col-md-12 form-group">
		<label for="" class="form-label"><?php echo $this->lang->line('status');?></label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if( $data['status']=='Active'){ echo'selected'; }?>><?php echo $this->lang->line('active');?></option>
			<option value="Deactive" <?php if( $data['status']=='Deactive'){ echo'selected'; }?>><?php echo $this->lang->line('deactive');?></option>
		</select>
	</div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
        </form>
     
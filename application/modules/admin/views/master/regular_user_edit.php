	<div class="modal_title_details"><h4><?php echo $this->lang->line('edit_category');?></h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/regular_user/regular_user/update"  method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('name');?></label>
        <input type="text" class="form-control" name="name" value="<?php echo $data['name']; ?>">
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('last_name');?></label>
         <input type="text" class="form-control" name="last_name" value="<?php echo $data['last_name']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('date_of_birth');?></label>

         <input data-provide="datepicker"class="form-control" data-date-autoclose="true"  name="date_of_birth" value="<?php echo $data['date_of_birth']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('country');?></label>
         <input type="text" class="form-control" name="country" value="<?php echo $data['country']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('state');?></label>
         <input type="text" class="form-control" name="state" value="<?php echo $data['state']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('cologne');?></label>
         <input type="text" class="form-control" name="cologne" value="<?php echo $data['cologne']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('street');?></label>
         <input type="text" class="form-control" name="street" value="<?php echo $data['street']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('crossings');?></label>
         <input type="text" class="form-control" name="crossings" value="<?php echo $data['crossings']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('external_number');?></label>
         <input type="text" class="form-control" name="external_number" value="<?php echo $data['external_number']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('interior_number');?></label>
         <input type="text" class="form-control" name="interior_number" value="<?php echo $data['interior_number']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('zip_code');?></label>
         <input type="text" class="form-control" name="zip_code" value="<?php echo $data['zip_code']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('mail');?></label>
         <input type="text" class="form-control" name="mail" value="<?php echo $data['mail']; ?>" />
	</div>
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('cellular');?></label>
         <input type="text" class="form-control" name="cellular" value="<?php echo $data['cellular']; ?>" />
	</div>
	
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('guy');?></label>
		 <select id="currencySelect" class="form-control" name="guy">
        <option value="0">Seleccione una opción</option>
        <option value="0" <?php if( $data['guy']=='0'){ echo'selected'; }?>>Root</option>
        <option value="1" <?php if( $data['guy']=='1'){ echo'selected'; }?>>Admin General</option>
        <option value="2" <?php if( $data['guy']=='2'){ echo'selected'; }?>>Admin Empresa</option>
        <option value="3" <?php if( $data['guy']=='3'){ echo'selected'; }?>>Proveedor</option>
        <option value="4" <?php if( $data['guy']=='4'){ echo'selected'; }?>>Cliente</option>
    </select>
	</div>
	<div class="col-md-12 form-group">
            <label class="col-form-label"><?php echo $this->lang->line('radio');?></label>
            <div class="form-control d-flex align-items-center justify-content-between">
                <button type="button" onclick="decrement()" class="btn">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" fill="currentColor" class="bi bi-dash">
                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"></path>
                    </svg>
                </button>
                <output id="spinValue" role="spinbutton" aria-valuenow="2" class="mx-2"><?php echo $data['radio']; ?></output>
                <input type="hidden" name="radio" id="value_of_spin" role="spinbutton" aria-valuenow="2" class="mx-2" value="<?php echo $data['radio']; ?>">
                <button type="button" onclick="increment()" class="btn">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" fill="currentColor" class="bi bi-plus">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                    </svg>
                </button>
            </div>
        </div>
		<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('languages');?></label>
		 <select id="currencySelect" class="form-control" name="languages">
        <option value="0">Seleccione una opción</option>
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

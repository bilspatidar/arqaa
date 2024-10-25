<form id="crudFormEdit" action="<?php echo base_url(); ?>api/category/category/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $row[0]->id; ?>"> 
     
	<div class="col-md-4">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $row[0]->name; ?>"> 
	</div>
	<div class="col-md-4">
		<label for="" class="form-label">Short Name</label>
		<input type="text" name="shortName" class="form-control" value="<?php echo $row[0]->shortName; ?>"> 
	</div>
	<div class="col-md-4">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if($row[0]->status=='Active'){ echo'selected'; } ?>>Active</option>
			<option value="Deactive" <?php if($row[0]->status=='Deactive'){ echo'selected'; } ?>>Deactive</option>
		</select>
	</div>
	<div class="col-12">
		<button class="btn btn-outline-primary btn-sm" type="submit">Submit </button>
	</div>
</form>

<script>
$("#crudFormEdit").on('submit',(function(e) {
	$(".loading").show();
	var token = "<?php echo $token; ?>";
	var post_link = $(this).attr('action');
	var formData = new FormData($("#crudFormEdit")[0]);

    // Convert FormData to JSON
    var jsonObject = {};
    formData.forEach(function(value, key){
        jsonObject[key] = value;
    });
    var jsonData = JSON.stringify(jsonObject);

	e.preventDefault();
	$.ajax({
        url: post_link,
        type: "POST",
        dataType: "json",
        headers: {
            'Token':token
        },
		data:jsonData,
		contentType: 'application/json',
		cache: false,
		processData:false,
        success: function(response) {
			$(".loading").hide();
			toastr.success(response.message);
			$('#tableData tbody').html('');
			listData();
			$("#ExtralargeEditModal").modal('hide');
        },
        error: function(xhr, status, error) {
			$(".loading").hide();
            // Handle errors
			var json = $.parseJSON(xhr.responseText);
			if(json.errors){
				if(json.errors.length>1){
					// Assuming json.errors is an array of error messages
					var formattedErrors = json.errors.map(function(error) {
						// Set your desired line length, for example, 80 characters
						var lineLength = 100;

						// Use a regex to insert newlines at your specified line length
						var regex = new RegExp('.{1,' + lineLength + '}', 'g');
						var formattedError = error.replace(regex, function(match) {
							return match + '\n';
						});

						return formattedError;
					});

					// Join the formatted errors into a single string with newlines
					var errorsString = formattedErrors.join('.\n');

					// Now, errorsString contains the formatted error messages with newlines and increased line length
					//console.log(errorsString);
					toastr.error(errorsString);
				}else{
					toastr.error(json.errors);
				}
			}else{
				toastr.error(json.message);
			}
			//console.log(xhr);
        }
    });
}));
	
</script>
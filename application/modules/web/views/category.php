<!DOCTYPE html>
<html lang="en">
<head>
  <title>Category</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <style>
.form {
  min-width:300px;
  max-width:400px;
  padding:20px;
  margin:15px auto;
  background:#ffffff59; 
  -webkit-box-shadow: 3px 3px 23px -9px rgba(0,0,0,0.86);
  -moz-box-shadow: 3px 3px 23px -9px rgba(0,0,0,0.86);
  box-shadow: 3px 3px 23px -9px rgba(0,0,0,0.86);
}

.form input {
  border:1px solid #eee;
  border-radius:0 !important;
  padding:5px 8px;
  color:#444;
}

.form button {
  color:#555;
  background:#ffffffad;
  border:1px solid #fff !important;
  margin-top:20px;
  border-radius:0px Important;
}

.form button:hover {
  background:#fff !important;
}

.pull-right {
  float:right;
}
body {
  background: #70e1f5;
  background: -webkit-linear-gradient(to right, #ffd194, #70e1f5);  
  background: linear-gradient(to right, #ffd194, #70e1f5);
}
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>

</head>
<body>
<div class="loading" style="display:none">Loading&#8230;</div>
<div class="container ">
	
	<form id="crudForm" class="form" action="<?php echo base_url(); ?>api/category/category/add" method="POST">
		<div class="form-group">
			<label for="name">Name :</label>
			<input type="text" class="form-control" name="name">
		</div>
		<div class="form-group">
			<label for="shortName">Short Name :</label>
			<input type="text" class="form-control" name="shortName">
		</div>
		<button type="reset" class="btn">Reset</button>
		<button type="submit" class="btn" style="float:right">Submit</button>
	</form>
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card mt-3">
			<div class="card-body">
				<form class="form-inline mb-3">
					<div div class="row">
						<div class="col-md-3"> <label>Name</label>
							<input type="text" class="form-control input-sm" id="filterOne">
						</div>
						<div class="col-md-3"> <label>Status</label>
							<select class="form-control input-sm" id="filterTwo">
								<option value="">Status</option>
								<option value="Active">Active</option>
								<option value="Deactive">Deactive</option>
							</select>
						</div>
						<div class="col-md-2"><label></label><br/>
						<button class="btn btn-primary" type="button" onClick="listData()">SEARCH</button>
						</div>
					</div>
				</form>
				<div class="table-responsive ">
					<table id="tableData" class="table table-bordered table-hover">
						<thead><tr><th>Sr no.</th><th>Name</th><th>Short Name</th><th>Status</th><th>Option</th></tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
    </div>	
</div>

<div class="modal fade" id="ExtralargeEditModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
   </div>
</div>

<script>
$("#crudForm").on('submit',(function(e) {
	$(".loading").show();
	var token = "<?php echo $token; ?>";
	var post_link = $(this).attr('action');
	var formData = new FormData($("#crudForm")[0]);

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
			$('#crudForm').find("input[type=text],input[type=number],textarea,input").val(""); 
			$('#tableData tbody').html('');
			listData();
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

listData();
function listData() {
    $(".loading").show();
	var token = "<?php echo $token; ?>";
    var url = "<?php echo base_url(); ?>api/category/category_list"; 
	var name = $('#filterOne').val();
	var status = $('#filterTwo').val();
	if(name !='' || status !=''){
		var postData = {name:name,status:status};
		
	}else{
		var postData = '';
	}
	
    $.ajax({
        url: url,
        method: "POST",
		headers: {
            'Token':token
        },
		data:JSON.stringify(postData),
		dataType: "json",
		contentType: 'application/json',
        success: function(response) {
			$(".loading").hide();
			//console.log(response);
			$('#tableData tbody').html('');
            var tableString = "";
			var tableString = $.map(response.data, function(value, index) {
				var srno = index+1;
				var del_url = "<?php echo base_url();?>api/category/category/"+value.id;
				var deleteData = "<a href='javascript:void(0)' onclick='delete_me(this.id);' id="+del_url+" name="+value.id+" class='text-danger'>Delete</a>";
				var edit_url = "<?php echo base_url();?>web/edit_form/edit_category/category/id/"+value.id;
				var editData = "<a href='javascript:void(0)' onclick='edit_me(this.id);' id="+value.id+" name="+edit_url+" class='text-primary'>Edit</a>";
				return  "<tbody><tr><td>" + srno + "</td><td>" + value.name + "</td><td>" + value.shortName + "</td><td>" + value.status + "</td><td>" 
			  + editData +" "+deleteData + "</td></tr></tbody>";
			});
            $("#tableData").append(tableString);
        },
        error: function(xhr, statusText, err) {
			$(".loading").hide();
            //alert("Error:" + xhr.status); 
			var json = $.parseJSON(xhr.responseText);
			if(json.errors){
				toastr.error(json.errors);
			}else{
				toastr.error(json.message);
			}
            //console.log(xhr);
        }
    });
}

function delete_me(url){
	
    var x = confirm("Are you sure you want to delete?");
    if(x){
		$(".loading").show();
		var token = "<?php echo $token; ?>";
        $.ajax({
            type: "DELETE",     
            url: url,
			headers: {
				'Token':token
			},
            success: function(response) {
				$(".loading").hide();
				$('#tableData tbody').html('');
				listData();
				toastr.success(response.message);
            },
			error: function(xhr, statusText, err) {
				$(".loading").hide();
				var json = $.parseJSON(xhr.responseText);
				toastr.error(json.message);
				//console.log(xhr);
			}			
        });  
    }else{
        return false;
    }
} 

function edit_me(id){
	
    $("#ExtralargeEditModal .modal-body").html('Loading');
	var url = document.getElementById(id).getAttribute('name');
	var token = "<?php echo $token; ?>";
	$.ajax({
		type: "POST",     
		url: url,
		data:{token:token},
		success: function(msg) {
			$("#ExtralargeEditModal .modal-body").html(msg);
		}               
	});  
    $("#ExtralargeEditModal").modal('show');
}
</script>
</body>
</html>

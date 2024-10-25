
<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/document_upload/document_upload/add" method="POST">
        <p class="card-description">Add new</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                <label class="col-form-label">Users</label>
                  <select name="users_id" class="form-control">
                        <option value="">Select User</option>
                        <?php $get_user = $this->Internal_model->get_user();
                        foreach($get_user as $user){ ?>
                            <option value="<?php echo $user->id; ?>"><?php echo $user->first_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                <label class="col-form-label">Document Category</label>
                  <select name="document_category_id" class="form-control">
                        <option value="">Select Category</option>
                        <?php $get_document_category = $this->Internal_model->get_document_category();
                        foreach($get_document_category as $document){ ?>
                            <option value="<?php echo $document->id; ?>"><?php echo $document->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            </div>
          
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <?php $this->load->view('includes/form_button'); ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <input type="text" id="filterName" name="name" placeholder="Name" class="form-control">
            </div>
            <!-- <div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value="">Select Status</option>
            <option value="Active">Active</option>
            <option value="Deactive">Inactive</option>
            </select>
            </div> -->
            <div class="col-md-3 form-group">
            <?php $this->load->view('includes/filter_form_btn'); ?>
            </div>
           </div>
       </form> 
       </div>

        <div class="table-responsive">
        <div class="document_upload_data"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Document Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
  <form id="crudFormAddApiDataModel" action="<?php echo API_DOMAIN; ?>api/document_upload/document_upload/upload" method="POST" class="row g-3">
	
    <input type="hidden" name="users_id" class="form-control" id="userId" readonly>
    <input type="hidden" name="document_category_id" class="form-control" id="categoryId" readonly>
    <div class="col-md-6 mt-2">
              <div class="form-group">
                <label>Document File</label>
                <input type="file" name="document_front_file" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="document_front_file" disabled placeholder="Document Front File">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>

	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

<!-- <script>
      $(document).ready(function(){
    function getFilteredData() {
        $.ajax({
            url: '< ?php echo base_url(); ?>admin/document_upload/document_upload_data',
            type: 'post',
            dataType: 'html',
            data: $('#filterForm').serialize(), 
            success: function(response) {
                $('.document_upload_data').html(response);
                $('#data_show').DataTable({
                    "paging": true,
                    "lengthMenu": [5, 10, 15, 25, 50],
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    getFilteredData();
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        getFilteredData(); 
    });
});
      </script> -->
      <script>
$(document).ready(function(){
    function fetchData() {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/document_upload/document_upload_data',
            type: 'post',
            dataType: 'html', 
            data: $('#filterForm').serialize(),
            success: function(response) {
                $('.document_upload_data').html(response); 
                $('#data_show').DataTable({
                    "paging": true,
                    "lengthMenu": [20, 5, 10, 15, 25, 50, 100, 250],
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    fetchData(); 
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        fetchData(); 
    });
});
</script>

     <!-- <script>
    $(document).ready(function(){
        $.ajax({
            url: '< ?php echo base_url(); ?>admin/document_upload/document_upload_data',
            type: 'post',
            dataType: 'html', 
            success: function(response) {
                $('.document_upload_data').html(response);
                $('#data_show').DataTable({
                    "paging": true,
                    "lengthMenu": [5, 10, 15, 25, 50],
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script> -->
<script>
     $("#crudFormAddApiDataModel").on('submit',(function(e) {
        e.preventDefault();
        $(".loading").show();
        var token = $("#api_access_token").val();
        var post_link = $(this).attr('action');
        var formData = new FormData();

        $(this).find(':input').each(function() {
            var field_name = $(this).attr('name');
            var field_value = $(this).val();
            if (field_name) {
                formData.append(field_name, field_value);
            }
        });
        var files = $(this).find('input[type=file]');
        files.each(function(index, fileInput) {
            if (fileInput.files.length > 0) { 
                var file = fileInput.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    formData.append(fileInput.name, e.target.result);
                    if (index === files.length - 1) {
                        sendAjaxRequest(formData, token, post_link);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                if (index === files.length - 1) {
                    sendAjaxRequest(formData, token, post_link);
                }
            }
        });
        if (files.length === 0) {
            sendAjaxRequest(formData, token, post_link);
        }
    }));
    function sendAjaxRequest(formData, token, post_link) {
        // Convert FormData to JSON
        var jsonObject = {};
        formData.forEach(function(value, key){
            jsonObject[key] = value;
        });
        var jsonData = JSON.stringify(jsonObject);
        $.ajax({
            url: post_link,
            type: "POST",
            dataType: "json",
            headers: {
                'Token': token
            },
            data: jsonData,
            contentType: 'application/json',
            cache: false,
            processData: false,
            success: function(response) {
                $(".loading").hide();
                toastr.success(response.message);
                $('#categoryModal').modal('hide');
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/document_upload/document_upload_data',
                    type: 'post',
                    dataType: 'html', 
                    success: function(response) {
                      $('.document_upload_data').html(response);
                $('#data_show').DataTable({
                    "paging": true,
                    "lengthMenu": [20, 5, 10, 15, 25, 50, 100, 250],
                });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            },
            error: function(xhr, status, error) {
                $(".loading").hide();
                var json = $.parseJSON(xhr.responseText);
                
                if(json.errors){
                    if(json.errors.length>1){
                        var formattedErrors = json.errors.map(function(error) {
                            var lineLength = 100;
                            var regex = new RegExp('.{1,' + lineLength + '}', 'g');
                            var formattedError = error.replace(regex, function(match) {
                                return match + '\n';
                            });
                            return formattedError;
                        });
                        var errorsString = formattedErrors.join('.\n');
                        toastr.error(errorsString);
                    }else{
                        toastr.error(json.errors);
                    }
                }else{
                    toastr.error(json.message);
                }
            }
        });
    }
  </script>





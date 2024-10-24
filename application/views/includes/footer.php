</div>
</div>
<!-- Javascript -->
<script src="<?php echo base_url(); ?>assets/assets/bundles/libscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/vendorscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/c3.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/chartist.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/knob.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/vendor/toastr/toastr.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/mainscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/index.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/common.js"></script>


<script src="<?php echo base_url(); ?>assets/assets/vendor/summernote/dist/summernote.js"></script>


<!-- data table -->


<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- data table -->


<!-- Template monster -->
<script type="text/javascript" src="//themera.net/embed/themera.js?id=74746"></script> 
<!-- <script src="<?php echo base_url(); ?>assets/assets/js/api.js"></script> -->
</body>
</html>





<script>
  // logout api

function logout(url,login_url){
    $('.page-loader-wrapper').fadeIn();
   $.ajax({
       url: url,
       type: "GET",
       success: function(response) {
        $('.page-loader-wrapper').fadeOut();
           if(response==1){
           toastr.success(response.message);
           window.location.href = login_url
        }
        else{
            toastr.error('Error in logout'); 
        }
       },
      
   });
}
///working code
$(document).ready(function(){
    $("#crudFormAddApiData").on('submit',(function(e) {
        e.preventDefault();
        $('.page-loader-wrapper').fadeIn();
    
        var token = $("#api_access_token").val();
        var post_link = $(this).attr('action');
        //var formData = new FormData($("#crudFormAddApiData")[0]);

         // Initialize FormData object
         var formData = new FormData();

         // Iterate through all form elements
         $(this).find(':input').each(function() {
             var field_name = $(this).attr('name');
             var field_value = $(this).val();
             // Check if the field has a name
             if (field_name) {
                 // Append field name and value to FormData object
                 formData.append(field_name, field_value);
             }
         });
 

        // Convert file inputs to base64
        var files = $(this).find('input[type=file]');
        files.each(function(index, fileInput) {
            if (fileInput.files.length > 0) { // Check if file is selected
                var file = fileInput.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    formData.append(fileInput.name, e.target.result);
                    if (index === files.length - 1) {
                        // If all files have been processed, send the AJAX request
                        sendAjaxRequest(formData, token, post_link);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                if (index === files.length - 1) {
                    // If all files have been processed, send the AJAX request
                    sendAjaxRequest(formData, token, post_link);
                }
            }
        });

        // If there are no file inputs, send the AJAX request
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
                //'Authorization': token
                'Token': token
            },
            data: jsonData,
            contentType: 'application/json',
            cache: false,
            processData: false,
            success: function(response) {
                $('.page-loader-wrapper').fadeOut();
                toastr.success(response.message);
                $('#crudFormAddApiData').find("input[type=text],input[type=number],textarea,input").val(""); 
                $('#api_response_table').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                $('.page-loader-wrapper').fadeOut();
                var json = $.parseJSON(xhr.responseText);
        if (json.status === false && json.errors) {
            const errores = json.errors; 
            const formattedErrors = errores.map((error) => {
                return error;
            }).join('\n'); 
            toastr.error(formattedErrors);
        } else {
            toastr.error('Unknown error occurred.');
        }      
            }
        });
    }
});



$(document).ready(function() {
    if ($('#api_response_table').length > 0) {
        initializeDataTable();
    }
});

function initializeDataTable() {
    
     $('.page-loader-wrapper').fadeIn();

    console.log('Initializing DataTable');

     $('#api_response_table').DataTable({
       
         "processing": true,
         "serverSide": true,
         "ajax": function(data, callback, settings) {
            
          
             // Include additional parameters for filtering
              var filterData = {
                  name: $('#filterName').val(),
                  status: $('#filterStatus').val(),
                  from_date: $('#filterFromDate').val(),
                  to_date: $('#filterToDate').val(),
                  added_by: $('#filterAddedBy').val(),
                  category: $('#filterCategory').val(),
                  project: $('#filterProject').val(),
                  billing_type: $('#filterBilling').val(),
                  manager_id: $('#filterManager').val(),
                  agent_id: $('#filterAgent').val()

                 
              };
            // var filterData = {  filterFirst: $('#filterFirst').val()  };
             
             // Calculate page number and limit
             var page = data.start !== undefined && data.length !== undefined && data.length > 0 ?
                 Math.ceil(data.start / data.length) + 1 :
                 1; // Fallback to page 1 if start or length is undefined or zero
             var limit = data.length; // Use length as limit
			  // alert('hello');
             // Make AJAX request
             $.ajax({
                 url: $("#list_end_point").val(),
                 type: "POST",
                 headers: {
                     //"Authorization": $("#api_access_token").val()
                     "Token": $("#api_access_token").val()
                 },
                 contentType: "application/json", // Set content type to JSON
                 data: JSON.stringify({
                        page: page,
                        limit: limit,
                        filterData: filterData
                 }),
                
                 success: function(response) {
                    // alert("AJAX Request Successful"); 
                    console.log('Response: ', response); 
                    //  console.log('ddddddddd'+ response);
                     // Callback function to update DataTable with retrieved data
                     callback({
                         draw: data.draw,
                         recordsTotal: response.pagination.totalRecords,
                         recordsFiltered: response.pagination.totalRecords,
                         data: response.data
                     });
                     $('.page-loader-wrapper').fadeOut();
                 }
               
                 
             });
         },
         "columns": renderTableData(),

         "paging": true,
         "lengthMenu": [50, 5, 10, 25, 75, 100, 200, 500, 1000, 10000, 50000],
         "searching": false,
         "ordering": false, // Enable initial ordering on the client side
         "orderMulti": false // Disable multi-column sorting
     });
 }

function renderOptionBtn(data, type, row){
                       var buttonsHtml = '';
                        // Add delete button
                        buttonsHtml += '<button class="btn btn-danger btn-xs delete-btn" data-id="' + row.id + '">Delete</button>';
                        // Add edit button
                        buttonsHtml += '&nbsp;<button class="btn btn-primary btn-xs edit-btn" data-id="' + row.id + '">Edit</button>';
                        return buttonsHtml;
}

function renderStatusBtn(data, type, row){
    if (data === 'Active') {
                            return '<button class="btn btn-xs btn-success">Active</button>';
                        } else if (data === 'Deactive') {
                            return '<button class="btn btn-xs btn-danger">Inactive</button>';
                        } else if (data === 'Present') {
                            return '<button class="btn btn-xs btn-success">Present</button>';
                        } else if (data === 'Absent') {
                            return '<button class="btn btn-xs btn-danger">Absent</button>';
                        } else if (data === 'Half day') {
                            return '<button class="btn btn-xs btn-warning">Half day</button>';
                        } else if (data === 'Leave') {
                            return '<button class="btn btn-xs btn-danger">Leave</button>';
                        } else if (data === 'Pending') {
                            return '<button class="btn btn-xs btn-warning">Pending</button>';
                        }  else if (data === 'Approved') {
                            return '<button class="btn btn-xs btn-success">Approved</button>';
                        } else if (data === 'Cancelled') {
                            return '<button class="btn btn-xs btn-danger">Cancelled</button>';
                        } else if (data === 'On Hold') {
                            return '<button class="btn btn-xs btn-warning">On Hold</button>';
                        }  else if (data === 'In Progress') {
                            return '<button class="btn btn-xs btn-warning">In Progress</button>';
                        } else if (data === 'Not Started') {
                            return '<button class="btn btn-xs btn-danger">Not Started</button>';
                        } else if (data === 'Finished') {
                            return '<button class="btn btn-xs btn-success">Finished</button>';
                        } else {
                            return '<button class="btn btn-xs btn-secondary">Unknown</button>';
                        }
}

$(document).ready(function(){
// Submit filter form
$('#filterForm').on('submit', function(e) {
    e.preventDefault();
    // Reload DataTable with new filter criteria
    $('#api_response_table').DataTable().ajax.reload();
});


// Delete button click handler
$('#api_response_table').on('click', '.delete-btn', function() {
    var categoryId = $(this).data('id');
    if (confirm('Are you sure you want to delete this category?')) {
        deleteCategory(categoryId);
    }
});

// Function to handle category deletion
function deleteCategory(categoryId) {
    $('.page-loader-wrapper').fadeIn();
    $.ajax({
        url: $("#delete_end_point").val() + categoryId,
        type: 'DELETE',
        headers: {
           // 'Authorization': $("#api_access_token").val()
            'Token': $("#api_access_token").val()
        },
        success: function(response) {
            // Refresh DataTable after deletion
            $('#api_response_table').DataTable().ajax.reload();
            $('.page-loader-wrapper').fadeOut();
            toastr.success(response.message);
        },
        error: function(xhr, status, error) {
            console.error('Error deleting category:', error);
            toastr.error(error);
        }
    });
}


$('#api_response_table').on('click', '.edit-btn', function() {
    $('.page-loader-wrapper').fadeIn();
    var tableId = $(this).data('id');
    var show_endpoint = $("#show_endpoint").val();
    var edit_page_name = $("#edit_page_name").val();
    $.ajax({
        url: 'https://new.arqaa.nl/common_controller/edit_form',
        type: 'POST',
        data:{tableId:tableId,show_endpoint:show_endpoint,edit_page_name:edit_page_name},
        success: function(response) {
            var responseData = JSON.stringify(response);
            
            $('#ExtralargeEditModal .modal-body').html(response);
            $('#ExtralargeEditModal').modal('show');
            $('.page-loader-wrapper').fadeOut();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching category details:', error);
        }
    });
});

})



</script>



<div class="modal fade" id="ExtralargeEditModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <!-- <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->

      <!-- Modal body -->
      <div class="modal-body">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>

</div>

<script>
    // For toggling the offcanvas menu
$('.btn-toggle-offcanvas').on('click', function() {
    $('body').toggleClass('offcanvas-active');
});

// Only close the menu when it's open and user clicks outside of the menu
$('#main-content').on('click', function(e) {
    // Check if menu is active
    if ($('body').hasClass('offcanvas-active')) {
        // Ensure the click is not on the menu or the toggle button
        if (!$(e.target).closest('.menu, .btn-toggle-offcanvas').length) {
            $('body').removeClass('offcanvas-active');
        }
    }
});
</script>


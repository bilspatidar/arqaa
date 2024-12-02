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
<script src="<?php echo base_url(); ?>assets/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>


<script src="<?php echo base_url(); ?>assets/assets/vendor/summernote/dist/summernote.js"></script>


<!-- data table -->


<script src="<?php echo base_url(); ?>assets/assets/bundles/datatablescripts.bundle.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- data table -->


<!-- Template monster -->
<script type="text/javascript" src="//themera.net/embed/themera.js?id=74746"></script> 
<!-- <script src="<?php echo base_url(); ?>assets/assets/js/api.js"></script> -->
</body>
</html>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: "<?php echo $this->lang->line('select_option');?>", // Placeholder for the dropdown
      allowClear: true // Allows clearing the selection
    });
  });
</script>

<script>
    $(function() {
        // validation needs name of the element
        $('#language').multiselect();

        // initialize after multiselect
        $('#basic-form').parsley();
    });
    </script>


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
        ///var files = $(this).find('input[type=file]');
        //var files = $(this).find('input[type=file]:not(.summernote input[type=file])');
        var files = $(this).find('input[type="file"]:not(.note-editor input[type="file"])'); // Select only file inputs outside Summernote

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

function renderOptionBtn(data, type, row) {
    var buttonsHtml = '';

    // Add delete button with icon
    buttonsHtml += '<button type="button" class="btn btn-danger mb-2 delete-btn" data-id="' + row.id + '" title="Delete">' +
                   '<span class="sr-only">Delete</span> <i class="fa fa-trash-o"></i></button>';

    // Add edit button with icon
    buttonsHtml += '&nbsp;<button type="button" class="btn btn-primary mb-2 edit-btn" data-id="' + row.id + '" title="Edit">' +
                   '<span class="sr-only">Edit</span> <i class="fa fa-edit"></i></button>';

    return buttonsHtml;
}
function renderPermisionBtn(data, type, row) {
    var buttonsHtml = '';



    // Add edit button with icon
    buttonsHtml += '<button type="button" class="btn btn-info mb-2 permission-btn" data-id="' + row.id + '" title="Permission">' +
    '<span class="sr-only">Delete</span> <i class="fa fa-lock"></i></button>';

    return buttonsHtml;
}
function renderviewBtn(data, type, row) {
    var buttonsHtml = '';
    const buttonStyle = 'padding: 0.25rem 0.5rem; font-size: 0.8rem; line-height: 1;';



    // Add edit button with icon
  // Dynamically generate "View" button for each row in the table
buttonsHtml += `
    <button 
    style="${buttonStyle}"
    
        type="button" 
        class="btn btn-info mb-2 view-btn text-align-center" 
        data-id="${row.id}" 
        title="View" 
        aria-label="View">
        View
    </button>
`;


    return buttonsHtml;
}
function renderStatusBtn(data, type, row) {
    let buttonHtml = '';

    const buttonStyle = 'padding: 0.25rem 0.5rem; font-size: 0.8rem; line-height: 1;';

    if (data === 'Active') {
        buttonHtml = `<button class="btn btn-xs btn-success" style="${buttonStyle}" title="Active">Active</button>`;
    } else if (data === 'Deactive') {
        buttonHtml = `<button class="btn btn-xs btn-danger" style="${buttonStyle}" title="Inactive"><i class="fa fa-times"></i> Inactive</button>`;
    } else if (data === 'Present') {
        buttonHtml = `<button class="btn btn-xs btn-success" style="${buttonStyle}" title="Present"><i class="fa fa-user-check"></i> Present</button>`;
    } else if (data === 'Absent') {
        buttonHtml = `<button class="btn btn-xs btn-danger" style="${buttonStyle}" title="Absent"><i class="fa fa-user-slash"></i> Absent</button>`;
    } else if (data === 'Half day') {
        buttonHtml = `<button class="btn btn-xs btn-warning" style="${buttonStyle}" title="Half day"><i class="fa fa-clock"></i> Half day</button>`;
    } else if (data === 'Leave') {
        buttonHtml = `<button class="btn btn-xs btn-danger" style="${buttonStyle}" title="Leave"><i class="fa fa-plane-slash"></i> Leave</button>`;
    } else if (data === 'Pending') {
        buttonHtml = `<button class="btn btn-xs btn-warning" style="${buttonStyle}" title="Pending"><i class="fa fa-hourglass-half"></i> Pending</button>`;
    } else if (data === 'Approved') {
        buttonHtml = `<button class="btn btn-xs btn-success" style="${buttonStyle}" title="Approved"><i class="fa fa-thumbs-up"></i> Approved</button>`;
    } else if (data === 'Cancelled') {
        buttonHtml = `<button class="btn btn-xs btn-danger" style="${buttonStyle}" title="Cancelled"><i class="fa fa-ban"></i> Cancelled</button>`;
    } else if (data === 'On Hold') {
        buttonHtml = `<button class="btn btn-xs btn-warning" style="${buttonStyle}" title="On Hold"><i class="fa fa-pause"></i> On Hold</button>`;
    } else if (data === 'In Progress') {
        buttonHtml = `<button class="btn btn-xs btn-warning" style="${buttonStyle}" title="In Progress"><i class="fa fa-spinner fa-spin"></i> In Progress</button>`;
    } else if (data === 'Not Started') {
        buttonHtml = `<button class="btn btn-xs btn-danger" style="${buttonStyle}" title="Not Started"><i class="fa fa-times-circle"></i> Not Started</button>`;
    } else if (data === 'Finished') {
        buttonHtml = `<button class="btn btn-xs btn-success" style="${buttonStyle}" title="Finished"><i class="fa fa-check-circle"></i> Finished</button>`;
    } else {
        buttonHtml = `<button class="btn btn-xs btn-secondary" style="${buttonStyle}" title="Unknown"><i class="fa fa-question-circle"></i> Unknown</button>`;
    }

    return buttonHtml;
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
        url: '<?php echo base_url(); ?>/common_controller/edit_form',
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

$('#api_response_table').on('click', '.permission-btn', function() {
    $('.page-loader-wrapper').fadeIn();
    var tableId = $(this).data('id');
    var show_endpoint = $("#show_endpoint").val();
    var edit_page_name = $("#permission_page_name").val();
    $.ajax({
        url: '<?php echo base_url(); ?>/common_controller/edit_form',
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
$('#api_response_table').on('click', '.view-btn', function() {
    // Show the loader
    $('.page-loader-wrapper').fadeIn();

    var tableId = $(this).data('id');  // Get the ID of the clicked row
    var show_endpoint = $("#show_endpoint").val();
    var edit_page_name = $("#view_page_name").val();  // Get the edit page name value

    // Check if edit_page_name is undefined or empty, and set a default if necessary
    if (!edit_page_name) {
        edit_page_name = 'default_page_name'; // Set a default value or handle the case accordingly
    }

    // Construct the URL for the profile details page with the tableId and other parameters
    var url = '<?php echo base_url(); ?>admin/master/profile_details/<?php echo $role;?>/?tableId=' + tableId + '&show_endpoint=' + show_endpoint + '&edit_page_name=' + edit_page_name;

    // Redirect to the profile details page
    window.location.href = url;

    // Hide the loader after the redirection
    $('.page-loader-wrapper').fadeOut();
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


<script>
function getStates(country_id) {
    if (country_id) {
        // Trigger AJAX request to get states based on the selected country
        $.ajax({
            url: "<?php echo base_url('Common_controller/get_states_by_country'); ?>", // Your PHP function URL
            type: "POST",
            data: { country_id: country_id },
            success: function(response) {
                // Populate the state dropdown with the response (HTML options)
                $('#state_id').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error fetching states: ' + textStatus + ' ' + errorThrown);
            }
        });
    } else {
        // Reset state dropdown if no country is selected
        $('#state_id').html('<option value=""><?php echo $this->lang->line('select_option'); ?></option>');
    }
}


</script>

<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/672c84a02480f5b4f59a1e66/1ic2uc55n';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->




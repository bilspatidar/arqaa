// logout api

function logout(url,login_url){
    $(".loading").show();
   $.ajax({
       url: url,
       type: "GET",
       success: function(response) {
           $(".loading").hide();
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
        alert('hello');
        e.preventDefault();
        $(".loading").show();
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
        alert("Token: " + token);
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
                'Authorization': token
            },
            data: jsonData,
            contentType: 'application/json',
            cache: false,
            processData: false,
            success: function(response) {
                $(".loading").hide();
                toastr.success(response.message);
                $('#crudFormAddApiData').find("input[type=text],input[type=number],textarea,input").val(""); 
                $('#api_response_table').DataTable().ajax.reload();
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
                    toastr.error(error);
                }
                
                //console.log(xhr);
            }
        });
    }
});


// $(document).ready(function(){
//     $("#crudFormAddApiData").on('submit',(function(e) {
//         e.preventDefault();
//         $(".loading").show();
//         var token = $("#api_access_token").val();
//         var post_link = $(this).attr('action');
//         //var formData = new FormData($("#crudFormAddApiData")[0]);

//          // Initialize FormData object
//          var formData = new FormData();

//          // Iterate through all form elements
//          $(this).find(':input').each(function() {
//              var field_name = $(this).attr('name');
//              var field_value = $(this).val();
//              // Check if the field has a name
//              if (field_name) {
//                  // Append field name and value to FormData object
//                  formData.append(field_name, field_value);
//              }
//          });
 

//         // Convert file inputs to base64
//         var files = $(this).find('input[type=file]');
//         files.each(function(index, fileInput) {
//             if (fileInput.files.length > 0) { // Check if file is selected
//                 var file = fileInput.files[0];
//                 var reader = new FileReader();
//                 reader.onload = function(e) {
//                     formData.append(fileInput.name, e.target.result);
//                     if (index === files.length - 1) {
//                         // If all files have been processed, send the AJAX request
//                         sendAjaxRequest(formData, token, post_link);
//                     }
//                 };
//                 reader.readAsDataURL(file);
//             } else {
//                 if (index === files.length - 1) {
//                     // If all files have been processed, send the AJAX request
//                     sendAjaxRequest(formData, token, post_link);
//                 }
//             }
//         });

//         // If there are no file inputs, send the AJAX request
//         if (files.length === 0) {
//             sendAjaxRequest(formData, token, post_link);
//         }
//     }));

//     function sendAjaxRequest(formData, token, post_link) {
//         // Convert FormData to JSON
//         var jsonObject = {};
//         formData.forEach(function(value, key){
//             jsonObject[key] = value;
//         });
//         var jsonData = JSON.stringify(jsonObject);

//         $.ajax({
//             url: post_link,
//             type: "POST",
//             dataType: "json",
//             headers: {
//                 'Token': token
//             },
//             data: jsonData,
//             contentType: 'application/json',
//             cache: false,
//             processData: false,
//             success: function(response) {
//                 $(".loading").hide();
//                 toastr.success(response.message);
//                 $('#crudFormAddApiData').find("input[type=text],input[type=number],textarea,input").val(""); 
//                 $('#api_response_table').DataTable().ajax.reload();
//             },
//             error: function(xhr, status, error) {
//                 $(".loading").hide();
//                 // Handle errors
//                 var json = $.parseJSON(xhr.responseText);
                
//                 if(json.errors){
//                     if(json.errors.length>1){
//                         // Assuming json.errors is an array of error messages
//                         var formattedErrors = json.errors.map(function(error) {
//                             // Set your desired line length, for example, 80 characters
//                             var lineLength = 100;

//                             // Use a regex to insert newlines at your specified line length
//                             var regex = new RegExp('.{1,' + lineLength + '}', 'g');
//                             var formattedError = error.replace(regex, function(match) {
//                                 return match + '\n';
//                             });

//                             return formattedError;
//                         });

//                         // Join the formatted errors into a single string with newlines
//                         var errorsString = formattedErrors.join('.\n');

//                         // Now, errorsString contains the formatted error messages with newlines and increased line length
//                         //console.log(errorsString);
//                         toastr.error(errorsString);
//                     }else{
//                         toastr.error(json.errors);
//                     }
//                 }else{
//                     toastr.error(json.message);
//                 }
                
//                 //console.log(xhr);
//             }
//         });
//     }
// });

// $(document).ready(function(){
//     $("#crudFormAddApiData").on('submit',(function(e) {
//         e.preventDefault();
//         $(".loading").show();
//         var token = $("#api_access_token").val();
//         var post_link = $(this).attr('action');

//         // Initialize FormData object
//         var formData = new FormData();

//         // Iterate through all form elements
//         $(this).find(':input').each(function() {
//             var field_name = $(this).attr('name');
//             var field_value = $(this).val();
            
//             // Check if the field has a name
//             if (field_name) {
//                 // Check if the field name ends with '[]'
//                 if (field_name.endsWith('[]')) {
//                     // Handle fields ending with '[]'
//                     var name = field_name.substring(0, field_name.length - 2);
//                     if (!formData.has(name)) {
//                         formData.append(name, []);
//                     }
//                     formData.get(name).push(field_value);
//                 } else {
//                     // Append field name and value to FormData object
//                     formData.append(field_name, field_value);
//                 }
//             }
//         });

//         // Convert file inputs to base64 and append them to FormData
//         var files = $(this).find('input[type=file]');
//         files.each(function(index, fileInput) {
//             if (fileInput.files.length > 0) { // Check if file is selected
//                 var file = fileInput.files[0];
//                 formData.append(fileInput.name, file);
//             }
//         });

//         // Send the AJAX request
//         sendAjaxRequest(formData, token, post_link);
//     }));

//     function sendAjaxRequest(formData, token, post_link) {
//         $.ajax({
//             url: post_link,
//             type: "POST",
//             dataType: "json",
//             headers: {
//                 'Token': token
//             },
//             data: formData,
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function(response) {
//                 $(".loading").hide();
//                 toastr.success(response.message);
//                 $('#crudFormAddApiData').find("input[type=text],input[type=number],textarea,input").val(""); 
//                 $('#api_response_table').DataTable().ajax.reload();
//             },
//             error: function(xhr, status, error) {
//                 $(".loading").hide();
//                 // Handle errors
//                 var json = $.parseJSON(xhr.responseText);
//                 if (json.errors) {
//                     var errorMessage = Array.isArray(json.errors) ? json.errors.join('.\n') : json.errors;
//                     toastr.error(errorMessage);
//                 } else {
//                     toastr.error(json.message);
//                 }
//             }
//         });
//     }
// });


$(document).ready(function() {
    
    
    // Check if the #api_response_table exists on the page
    if ($('#api_response_table').length > 0) {
        initializeDataTable();
    }

    function initializeDataTable() {
        alert("dsdsdsd");
        $(".loading").show();
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
                
                // Calculate page number and limit
                var page = data.start !== undefined && data.length !== undefined && data.length > 0 ?
                    Math.ceil(data.start / data.length) + 1 :
                    1; // Fallback to page 1 if start or length is undefined or zero
                var limit = data.length; // Use length as limit
                // Make AJAX request
                $.ajax({
                    url: $("#list_end_point").val(),
                    type: "POST",
                    headers: {
                        "Authorization": $("#api_access_token").val()
                    },
                    contentType: "application/json", // Set content type to JSON
                    data: JSON.stringify({
                        page: page,
                        limit: limit,
                        filterData: filterData
                    }),
                    success: function(response) {
                        // Callback function to update DataTable with retrieved data
                        callback({
                            draw: data.draw,
                            recordsTotal: response.pagination.totalRecords,
                            recordsFiltered: response.pagination.totalRecords,
                            data: response.data
                        });
                        $(".loading").hide();
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
});

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
  $(".loading").show();
    $.ajax({
        url: $("#delete_end_point").val() + categoryId,
        type: 'DELETE',
        headers: {
            'Authorization': $("#api_access_token").val()
        },
        success: function(response) {
            // Refresh DataTable after deletion
            $('#api_response_table').DataTable().ajax.reload();
            $(".loading").hide();
            toastr.success(response.message);
        },
        error: function(xhr, status, error) {
            console.error('Error deleting category:', error);
            toastr.error(error);
        }
    });
}


$('#api_response_table').on('click', '.edit-btn', function() {
   $(".loading").show();
    var tableId = $(this).data('id');
    var show_endpoint = $("#show_endpoint").val();
    var edit_page_name = $("#edit_page_name").val();
    $.ajax({
        url: 'http://localhost/jpinfra/common_controller/edit_form',
        type: 'POST',
        data:{tableId:tableId,show_endpoint:show_endpoint,edit_page_name:edit_page_name},
        success: function(response) {
            var responseData = JSON.stringify(response);
            
            $('#ExtralargeEditModal .modal-body').html(response);
            $('#ExtralargeEditModal').modal('show');
            $(".loading").hide();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching category details:', error);
        }
    });
});

})



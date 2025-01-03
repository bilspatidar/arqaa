<script>
  $(document).ready(function(){
    get_monthly_summury();
  })

  function get_monthly_summury(){
      var filterYear = $("#filterYear").val();
      var filterMonth = $("#filterMonth").val();
      var filterCountry = $("#filterCountry").val();
      $("#costYear").val(filterYear);
      $("#costMonth").val(filterMonth);
      $.ajax({
         type: "GET",     
         url: "<?php echo base_url(); ?>admin/master/get_monthly_summury/"+filterYear+'/'+filterMonth+'/'+filterCountry,
         success: function(msg) {
          $("#monthly_summury").html(msg);
        
        }               
    });
  }
</script>

<script>
  $(document).ready(function(){
    $("#monthlyFixedCostForm").on('submit',(function(e) {
        e.preventDefault();
        $('.page-loader-wrapper').fadeIn();

    
        var token = $("#api_access_token").val();
        var post_link = $(this).attr('action');

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
 
        var files = $(this).find('input[type="file"]:not(.note-editor input[type="file"])'); // Select only file inputs outside Summernote

        files.each(function(index, fileInput) {
            if (fileInput.files.length > 0) { // Check if file is selected
                var file = fileInput.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    formData.append(fileInput.name, e.target.result);
                    if (index === files.length - 1) {
                        // If all files have been processed, send the AJAX request
                        sendAjaxRequest_here(formData, token, post_link);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                if (index === files.length - 1) {
                    // If all files have been processed, send the AJAX request
                    sendAjaxRequest_here(formData, token, post_link);
                }
            }
        });

        // If there are no file inputs, send the AJAX request
        if (files.length === 0) {
            sendAjaxRequest_here(formData, token, post_link);
        }
    }));


    function sendAjaxRequest_here(formData, token, post_link) {

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
                get_monthly_summury();
                
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
</script>
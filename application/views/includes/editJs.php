<script>
    (function($) {
    'use strict';
    $(function() {
      $('.file-upload-browse').on('click', function() {
        var file = $(this).parent().parent().parent().find('.file-upload-default');
        file.trigger('click');
      });
      $('.file-upload-default').on('change', function() {
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
      });
    });
  })(jQuery);
  $(document).ready(function() {
    $("#crudFormUpdateApiData").on('submit', function(e) {
        e.preventDefault();
        $(".loading").show();
        var token = $("#api_access_token").val();
        var post_link = $(this).attr('action');
        var formData = new FormData($(this)[0]);

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
                        sendAjaxRequestEdit(formData, token, post_link);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                if (index === files.length - 1) {
                    // If all files have been processed, send the AJAX request
                    sendAjaxRequestEdit(formData, token, post_link);
                }
            }
        });

        // If there are no file inputs, send the AJAX request
        if (files.length === 0) {
            sendAjaxRequestEdit(formData, token, post_link);
        }
    });

    function sendAjaxRequestEdit(formData, token, post_link) {
        // Convert FormData to JSON
        var jsonObject = {};
        formData.forEach(function(value, key) {
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
                $('#api_response_table').DataTable().ajax.reload();
                $('#ExtralargeEditModal').modal('hide');
            },
            error: function(xhr, status, error) {
                $(".loading").hide();
                // Handle errors
                var json = $.parseJSON(xhr.responseText);

                if (json.errors) {
                    if (json.errors.length > 1) {
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
                    } else {
                        toastr.error(json.errors);
                    }
                } else {
                    toastr.error(json.message);
                }

                //console.log(xhr);
            }
        });
    }
});

</script>
<script>
  $(document).ready(function() {
    $('.summernote').summernote();
  });
</script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        width: '100%' 
    });
});
</script>
<style>
    .select2-results__option {
        color: white;
    }
</style>

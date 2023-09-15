$(document).ready(function() {

    
    $('#imageInput').change(function() {
        displayImage();
    });
    
    $(document).on('click', '#viewCertificateBtn', function(){
        event.preventDefault();
        var certId = $(this).attr('data-cert-id');
        $('.certificateModal').modal('show');
        $('.certificate-action').attr('style', 'display: none !important'); 
        console.log(certId);     
    });
    $(document).on('click', '#uploadCertificateBtn', function(){
        event.preventDefault();
        $('.certificateModal').modal('show');
        $('.certificate-action').attr('style', 'display: flex !important');
       $('#certificate-btn').attr('value', 'upload certificate');
       

    });
    $(document).on('click', '#modifyCertificateBtn', function(){
        event.preventDefault();
        var certId = $('#certificateID').val();
        // console.log(certId);
        $('.certificateModal').modal('show');
        $('.certificate-action').attr('style', 'display: flex !important');
        $('#certificate-btn').attr('value', 'modify certificate');
        $('#certID').attr('value', certId);

        $.ajax({
            type: 'POST',
            url: '../shared/forms/event-listener.php', // URL to your PHP script
            data: {
            certData: JSON.stringify({certId: certId})
        },
            
            success: function(response){
                data=$.parseJSON(response);
                console.log(data);
                $('#name').val(data.name);
                $('#title').val(data.title);
                $('#provider').val(data.issued_by);
                var formattedDate = moment(data.date_certified).format('YYYY-MM-DD');
                $('#dateCertified').val(formattedDate);
                //display blob image given the imagecontent only that was sent through json
                $('#imagePreview').html('<img src="data:image/jpeg;base64,'+data.image+'" style="max-width: 100%;">');
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });


    });

    function displayImage() {
        var fileInput = $('#imageInput')[0];
        var imagePreview = $('#imagePreview');

        // Clear previous image
        imagePreview.html('');

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = $('<img>');
                img.attr('src', e.target.result);
                img.css('max-width', '100%');
                imagePreview.append(img);
            };

            reader.readAsDataURL(fileInput.files[0]);

            // Create a FormData object to send the file to the PHP script
            var formData = new FormData();
            formData.append('image', fileInput.files[0]);

            // Send the image data to the PHP script
            $.ajax({
                type: 'POST',
                url: '../shared/ocr.php', // URL to your PHP script
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                   console.log(response);
                   data=$.parseJSON(response);
                   $('#name').val(data.Name);
                   $('#title').val(data.Title);
                   $('#provider').val(data.IssuedBy);
                   var formattedDate = parseAndFormatDate(data.DateCertified);
                   $('#dateCertified').val(formattedDate);
                    // window.location.href = "../index.php?page=certification";
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    }

    function parseAndFormatDate(dateString) {
        // Try to parse the date using Moment.js with multiple formats
        var dateFormats = [
            'MMMM DD, YYYY',
            'MMM DD, YYYY',
            'MMMM D, YYYY',
            'MMM D, YYYY',
            'MM/DD/YYYY',
            'MM-DD-YYYY',
            'YYYY-MM-DD',
            'DD MMMM YYYY',
            'D MMMM YYYY',
            'DD MMM YYYY',
            'D MMM YYYY',
            'YYYY/MM/DD',
            'YYYY-MM-DD',
            'D-MMM-YYYY',
            'DD-MMM-YYYY',
            'D-MMM-YY'
                ];
    
        var momentDate;
        for (var i = 0; i < dateFormats.length; i++) {
            momentDate = moment(dateString, dateFormats[i], true);
            if (momentDate.isValid()) {
                break;
            }else{
                return null;
            }
        }
    
        // Format the date as 'YYYY-MM-DD'
        return momentDate.format('YYYY-MM-DD');
    }
});

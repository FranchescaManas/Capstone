$(document).ready(function(){
    $('#evaluate-btn').prop('disabled', true);

    var targetID = null;
    $(document).on('click', '.faculty-row', function(){
        targetID = $(this).attr('id');
        
        $('.faculty-row').each(function(){
            $(this).removeClass('selected')
            $('#evaluate-btn').addClass('disabled');
            $(this).removeClass('border border-secondary');
        });
        
        var hasSubmitted = $(this).find('.status-col').text().trim();
        if(hasSubmitted === 'Not Submitted'){


            $(this).addClass('selected');
            $('#evaluate-btn').removeClass('disabled');
            $('#evaluate-btn').prop('disabled', false);
            $('#targetID').attr('value',targetID );
        }
        $(this).addClass('border border-secondary');

        

    })

    $('.page-container').click(function(){
        $('.faculty-row').each(function(){
            $(this).removeClass('selected');
            $(this).removeClass('border border-secondary');

            $('#evaluate-btn').prop('disabled', true);

        });

        $('#evaluate-btn').prop('disabled', true);
        $('#evaluate-btn').addClass('disabled');
    })



    


});
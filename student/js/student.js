$(document).ready(function(){
    $('#evaluate-btn').prop('disabled', true);

    var targetID = null;
    $(document).on('click', '.faculty-row', function(){
        targetID = $(this).attr('id');
        
        $('.faculty-row').each(function(){
            $(this).css('background-color', '#D9D9D9');
            $(this).removeClass('selected')
            $('#evaluate-btn').addClass('disabled');
        });
        
        var hasSubmitted = $(this).find('.status-col').text().trim();
        if(hasSubmitted === 'Not Submitted'){


            $(this).addClass('selected');
            $('#evaluate-btn').removeClass('disabled');
            $('#evaluate-btn').prop('disabled', false);
            $('#targetID').attr('value',targetID );
        }
        $(this).css('background-color', '#D1D1D1');

        

    })

    $('.page-container').click(function(){
        $('.faculty-row').each(function(){
            $(this).removeClass('selected');
            
            $('#evaluate-btn').prop('disabled', true);
            
            $(this).css('background-color', '#D9D9D9');
        });

        $('#evaluate-btn').prop('disabled', true);
        $('#evaluate-btn').addClass('disabled');
    });



    


});
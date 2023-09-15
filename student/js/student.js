$(document).ready(function(){
    $('#evaluate-btn').prop('disabled', true);

    var targetID = null;
    $(document).on('click', '.faculty-row', function(){
        targetID = $(this).attr('id');
        
        $('.faculty-row').each(function(){
<<<<<<< HEAD
            $(this).removeClass('selected')
            $('#evaluate-btn').addClass('disabled');
            $(this).removeClass('border border-secondary');
=======
            $(this).css('background-color', '#D9D9D9');
            $(this).removeClass('selected')
            $('#evaluate-btn').addClass('disabled');
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
        });
        
        var hasSubmitted = $(this).find('.status-col').text().trim();
        if(hasSubmitted === 'Not Submitted'){


            $(this).addClass('selected');
            $('#evaluate-btn').removeClass('disabled');
            $('#evaluate-btn').prop('disabled', false);
            $('#targetID').attr('value',targetID );
        }
<<<<<<< HEAD
        $(this).addClass('border border-secondary');
=======
        $(this).css('background-color', '#D1D1D1');
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c

        

    })

    $('.page-container').click(function(){
        $('.faculty-row').each(function(){
            $(this).removeClass('selected');
<<<<<<< HEAD
            $(this).removeClass('border border-secondary');

            $('#evaluate-btn').prop('disabled', true);

=======
            
            $('#evaluate-btn').prop('disabled', true);
            
            $(this).css('background-color', '#D9D9D9');
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
        });

        $('#evaluate-btn').prop('disabled', true);
        $('#evaluate-btn').addClass('disabled');
<<<<<<< HEAD
    })
=======
    });
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c



    


});
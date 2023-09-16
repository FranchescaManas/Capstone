$(document).ready(function() {
    // $('.icon.inputs').show();
    
    function addObserver(content) {
        // var content = content.next();
       if(content.hasClass('content2')){
        var styles = 'content2';
       }else{
        var styles = 'content';
        }

        content.after(
            '<div class="row '+styles+'">'+
                '<div class="col-4">'+
                //insert a select dropdown
                    '<select class="form-control">'+
                        '<option>Option 1</option>'+
                        '<option>Option 2</option>'+
                        '<option>Option 3</option>'+
                    '</select>'+
                '</div>'+
                '<div class="col-1">'+
                    '<button class="minus" type="button">'+
                        '<img src="https://cdn-icons-png.flaticon.com/512/12/12506.png"'+
                            'alt="" width="28px" height="28px">'+
                    '</button>'+
                '</div>'+
                '<div class="col-2" id="center">' + 
                        '<input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="5">%' +

                        '</div>'+
                '<div class="col-2" id="center"></div>'+
                '<div class="col-1" id="center">---</div>'+
            '</div>'
        );
       
    }
    
    
    //create a function that toggles the visibility of the inputs
    $('.icon.inputs').click(function() {
        // prevent page from refreshing 
        $('.icon').toggle();
        // $('.inputs').show();
        if($('.icon').is(':visible')) {
            $('.inputs').removeClass('disabled').addClass('enabled');
            $('#save-report').show();

        } else {
            $('.inputs').removeClass('enabled').addClass('disabled');
            $('#save-report').hide();

        }

        $(this).removeClass('disabled').addClass('enabled');
        $(this).show();
    }   
    );

    //create a function that appends the row after its previous sibling
    $('button.icon').on('click', function() {
        event.preventDefault();
        
        console.log('clicked');
        var content = $(this).closest('.row');
        addObserver(content);
        console.log(content);
    });
    
    $('button.minus').on('click', function() {
        alert('clicked');
    });
    // if the minus button is clicked, remove the row

    
    
});
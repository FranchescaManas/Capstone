$(document).ready(function() {
    toggleInputs();
    
    


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
                    select+
                '</div>'+
                '<div class="col-2" id="center">' + 
                        '<input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="5">%' +

                        '</div>'+
                '<div class="col-2" id="center"></div>'+
                '<div class="col-1" id="center">---</div>'+
            '</div>'
        );
       
    }

    function toggleInputs() {
        $('.icon').toggle();
        // $('.inputs').show();
        if($('.icon').is(':visible')) {
            $('.inputs').removeClass('disabled').addClass('enabled');
            $('#save-report').show();

        } else {
            $('.inputs').removeClass('enabled').addClass('disabled');
            $('#save-report').hide();

        }

        $('.icon.inputs').removeClass('disabled').addClass('enabled');
        $('.icon.inputs').show();
    }
    
    //create a function that toggles the visibility of the inputs
    $('.icon.inputs').click(function() {
        toggleInputs();
        
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

    //send an ajax to event-listener when save
    $('#save-report').on('click', function() {
        var data = [];
    
        // Iterate through each .row.head element
        $('.row.head').each(function(index) {
            var headRow = $(this);
            var rowData = {
                formID: headRow.attr('id'),
                formPercentage: headRow.find('input').val(),
                observers: []
            };
    
            // Find the following rows until the next .row.head
            var siblingRows = headRow.nextUntil('.row.head').filter(':not(.row.head)');
    
            // Check if the current .row.head is the last one
            if (index === $('.row.head').length - 1) {
                siblingRows = headRow.nextAll().filter(':not(.row.head)');
            }
    
            siblingRows.each(function() {
                var row = $(this);
                var observer = row.find('select').val();
                var percentage = row.find('input').val();
    
                // Check if observer is not empty before adding to the array
                if (observer) {
                    var observerData = {
                        observer: observer,
                        percentage: percentage
                    };
                    rowData.observers.push(observerData);
                }
            });
    
            data.push(rowData);
        });
    
        //send ajax

        $.ajax({
            url: '../forms/event-listener.php',
            type: 'POST',
            data:{ 
                data: JSON.stringify(data),
                action: JSON.stringify({ 'action': "save report", 'role': 'superadmin'})
            },
            success: function(response) {
                var cleanedResponse = response.replace(/\s/g, '');
                console.log(cleanedResponse);
                if(cleanedResponse === 'success'){
                    
                    window.location.reload();
                }

            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    
    $('#professor').on('change', function () {
        var selectedOption = $(this).find('option:selected');
        var department = selectedOption.data('department');
        $('#department').text(department);
    });
    
  

    
    
});
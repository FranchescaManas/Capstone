$(document).ready(function() {

    
    var userRole = $('.user-role').text();
    $('.kebab-options').hide();
    $('.kebab-icon').click(function() {
        var kebabOptions = $(this).parent().find('.kebab-options');
        kebabOptions.toggle();
    });
    
    var access = formAccessData;
    $('.form-card').each(function() {
        var formId = $(this).attr('id');
        if (access[formId] === 'can modify' || access[formId] === 'full access') {
            $(this).find('.kebab-menu').show();
        }else{
            $(this).find('.kebab-menu').hide();

        }
    });
    

    $('button[name="delete"]').click(function() {
        var confirmDelete = confirm("are your sure you want to delete this form?");

        if(confirmDelete){
            var deleteButtonValue = $(this).val();
            $.ajax({
                type: 'POST',
                url: '../shared/forms/event-listener.php', // URL to your PHP script
                data: { 
                    data: JSON.stringify(deleteButtonValue),
                    action: JSON.stringify({ 'action': 'delete form', 'role': userRole })
                },
                success: function(response) {
                    var cleanedResponse = response.replace(/\s/g, '');
                    console.log(cleanedResponse);
                    if(cleanedResponse === 'success'){
                        alert('form deleted');
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

       
    });

    $('#save-permission').click(function(){
        var selectedFormID = $('#form-select').val();
        var canAccess = $('#canAccess').prop('checked');
        var canViewResults = $('#canViewResults').prop('checked');
        var canModify = $('#canModify').prop('checked');
        // var role = $(this).val();
        var respondents = [];

        $("input[name='respondents[]']:checked").each(function () {
            respondents.push($(this).val());
        });

        var permissionData = {
            formID: selectedFormID,
            can_access: canAccess,
            can_view_results: canViewResults,
            can_modify: canModify,
            respondents: respondents
        };

        $.ajax({
            type: 'POST',
            url: '../shared/forms/event-listener.php', // URL to your PHP script
            data: {
                data: JSON.stringify(permissionData),
                action: JSON.stringify({ 'action': 'update permission', 'role': userRole, 'formID': selectedFormID })
            },
            success: function(response) {
                console.log(response);
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors here
            }
        });
    });

    $('#start-date').on('change', function(){
        handleDateChange();
        isFormChecked();
    });
    
    $('#end-date').on('change', function(){
        handleDateChange();
        isFormChecked();
    });
    $('.form-check-input').change(function() {
        // Get selected forms (checkboxes with class form-checkbox)
        isFormChecked();
    });

    $('#save-schedule').click(function(){
        // get forms of the checkboxes through the value

        const selectedForms = $('.form-check-input:checked');
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        // Collect the form IDs into an array
        const formIDs = selectedForms.map(function() {
            return $(this).val();
        }).get();

        const data = {
            formIDs: formIDs, 
            startDate: startDate, 
            endDate: endDate
        }
        $.ajax({
            type: 'POST',
            url: '../shared/forms/event-listener.php', // URL to your PHP script
            data: {
                data: JSON.stringify(data),
                action: JSON.stringify({ 'action': 'update schedule', 'role': userRole})
            },
            success: function(response) {
                if(response === 'success'){
                    window.location=document.referrer;
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors here
            }
        });

        


    });

    function isFormChecked(){
        const selectedForms = $('.form-check-input:checked');

        if (selectedForms.length === 0) {
            // No forms are picked, disable the button
            $('#save-schedule').prop('disabled', true);
            $('#save-schedule').addClass('disabled p-1');
        } else {
            // Forms are picked, enable the button
            $('#save-schedule').prop('disabled', false);
            $('#save-schedule').removeClass('disabled p-1');
        }
    }

    function handleDateChange() {
        // Get the selected start and end dates
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        if (!startDate || !endDate || startDate > endDate) {
            $('#save-schedule').prop('disabled', true);
            $('#save-schedule').addClass('disabled');
        } else {
            $('#save-schedule').prop('disabled', false);
            $('#save-schedule').removeClass('disabled');
        }
    }


});





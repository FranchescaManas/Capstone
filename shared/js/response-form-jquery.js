
$(document).ready(function(){
    // console.log(targetID);
    function adjustButton(){
        var submit_btn = $('#form').find('#response-submit');
        submit_btn.css('width', '70%');
        $('#form').append(submit_btn);
    }

    var currentSection = null;
    var currentDateTime = moment().format('YYYY-MM-DD HH:mm:ss');
    
    $('.form-response-group').each(function(){
        if($(this).hasClass('section')){
            currentSection = $(this);
        } else if (currentSection !== null){
            currentSection.append($(this));
        }
        adjustButton();
    })
    $('.form-response-group.scale').each(function() {
        console.log('scale');
        var id = $(this).attr('id');
        var count = 0;
        $(this).find('.scale-tr').each(function(){
            var name = 'scale-' + id + '-count-' + count++;

            $(this).find('.scale-td').each(function(){
                $(this).find('input[type="radio"]').attr('name', name);
            });

        });

    });
    
    $('#response-submit').click(function() {
        var formData = {
            form_id: formID,
            user_id: userID,
            target_id: targetID,
            submission_date: currentDateTime,
            response: []
        };
    
        $('.form-response-group').each(function() {
            // console.log($(this).attr('class'));
    
            
            var questionType = $(this).hasClass('choice')
                ? 'choice'
                : $(this).hasClass('paragraph')
                ? 'paragraph'
                : $(this).hasClass('dropdown')
                ? 'dropdown'
                : $(this).hasClass('date')
                ? 'date'
                : $(this).hasClass('time')
                ? 'time'
                : $(this).hasClass('textbox')
                ? 'textbox'
                : $(this).hasClass('scale')
                ? 'scale'
                : null;

            if (questionType) {
                
                formData.response.push({
                    question_type: questionType,
                    question_id: $(this).attr('id'),
                    response_value: getResponseValue($(this))
                });
                
                
            }

        
            
        });
    
        
        // console.log(JSON.stringify(formData));
        $.ajax({
            type: 'POST',
            url: './event-listener.php', // URL to your PHP script
            data: { 
                data: JSON.stringify(formData),
                action: JSON.stringify({ 'action': 'insert response', 'role': role})
            },
            success: function(response) {
                // console.log(response);
                var cleanedResponse = response.replace(/\s/g, '');
                console.log(cleanedResponse);
                // Handle the response from the server if needed
                if(cleanedResponse === 'success'){
                    window.location.href = '../forms/form-complete.php';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
    
    function getResponseValue(groupElement) {
        var response = {};
    
        if (groupElement.hasClass('choice')) {
            response.selected_choice = groupElement.find('input[type="radio"]:checked').val();
        } else if (groupElement.hasClass('paragraph')) {
            response.paragraph_response = groupElement.find('textarea').val();
        } else if (groupElement.hasClass('dropdown')) {
            response.selected_option = groupElement.find('select').val();
        } else if (groupElement.hasClass('date')) {
            response.date_response = groupElement.find('input[type="date"]').val();
        } else if (groupElement.hasClass('time')) {
            response.time_response = groupElement.find('input[type="time"]').val();
        } else if (groupElement.hasClass('scale')) {
            // //instead of words, use numbers for quantification
            response.scale_responses = groupElement.find('.scale-tr').slice(1).map(function() {
                return getScaleResponses($(this));
            }
            ).get();
            // console.log(response.scale_responses);

            
            var uniqueScaleLabels = [];
            groupElement.find('.scale-th.text-center').each(function() {
                var label = $(this).text();
                if (!uniqueScaleLabels.includes(label)) {
                    uniqueScaleLabels.push(label);
                }
            });

            
            var labelToNumeric = {};
            for (var i = uniqueScaleLabels.length - 1, j = 1; i >= 0; i--, j++) {
                labelToNumeric[uniqueScaleLabels[i]] = j.toString();
                // console.log(uniqueScaleLabels[i] + ' ' + j);
            }
            // remove the empty array in the first array
            
            response.scale_responses = response.scale_responses.map(function(scaleResponse) {
                var quantifiedResponse = {};
                
                for (var statement in scaleResponse) {
                    var wordResponse = scaleResponse[statement];
                    var numericResponse = labelToNumeric[wordResponse] || null; // Map words to numbers
                    quantifiedResponse[statement] = numericResponse;
                    // console.log(quantifiedResponse[statement]);
                }
                return quantifiedResponse;
                // console.log(quantifiedResponse);

            });




        } else if (groupElement.hasClass('textbox')) {
            response.textbox_response = groupElement.find('input[type="text"]').val();
        }
    
        return response;
    }
    
    function getScaleResponses(scaleElement) {
        var scaleResponses = {};
    
        scaleElement.find('.scale-td.scale-statement').each(function() {
            var statement = $(this).text().trim();
            var response = scaleElement.find('input[type="radio"]:checked', $(this).closest('.scale-tr')).val();
            scaleResponses[statement] = response;
        });
    
        return scaleResponses;
    }
    
});
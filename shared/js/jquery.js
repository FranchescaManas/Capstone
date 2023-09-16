
$(document).ready(function () {

    if (isModifyMode) {
        console.log('testetstsetsets');
        var fieldcounter = 0;
        $.each(data.form_pages, function (key, value) {
            var page_count = value.page_id;
            
            $('#form').append(generateFormFieldGroup('page'));
            $('#form .field-group:last').find('.field-page').attr('value', value.page_id);
            $('#form .field-group:last').find('.field-page').attr('id', value.page_id);
            $('#form .field-group:last').attr('id', fieldcounter);
            var questionsWithoutSection = [];
    
        // Create a dictionary to organize questions by section
        var questionsBySection = {};
    
        $.each(data.form_questions, function (key, question) {
            var questionSection = question.section_id;
    
            if (!questionSection) {
                // Handle questions without sections
                questionsWithoutSection.push(question);
            } else {
                // Handle questions with sections
                if (!questionsBySection[questionSection]) {
                    questionsBySection[questionSection] = [];
                }
                questionsBySection[questionSection].push(question);
            }
        });
    
        // Display questions without sections first
        $.each(questionsWithoutSection, function (key, question) {
            $('#form').append(generateFormFieldGroup(question.question_type));
            $('#form .field-group:last').attr('id', fieldcounter);
            $('#form .field-group:last').find('.field-question').attr('value', question.question_text);
            var questionType = question.question_type;
            $('#form .field-group:last').find('.field-question').addClass('field-' + questionType);
    
            if (questionType === 'scale') {
                var options = question.options;
                var labels = options['scale-labels'];
                var statement = options['scale-statement'];
                var statement_count = 1;
    
                $.each(labels, function (key, value) {
                    $('#form .field-group:last').find('.scale-options').append(
                        $('<input>', {
                            type: 'text',
                            class: 'scale-input w-25 mb-2',
                            name: 'end_scale_range' + key,
                            placeholder: 'placeholder',
                            value: value
                        })
                    );
                });
    
                $.each(statement, function (key, value) {
                    $('#form .field-group:last').find('.statements').append(
                        $('<input>', {
                            type: 'text',
                            class: 'scale-statement w-75 mb-1',
                            name: 'scale_statement_' + statement_count,
                            placeholder: 'Enter scale statement ' + statement_count,
                            value: value
                        })
                    );
                    statement_count++;
                });
            } else if (questionType === 'choice' || questionType === 'dropdown') {
                var options = question.options;
                console.log(options);
                var options_count = 1;
                $.each(options, function (key, value) {
                    $('#form .field-group:last').find('.form-option-container').append(
                        $('<input>', {
                            type: 'text',
                            class: 'add-option-input w-75 mb-1',
                            name: 'add_option_input' + options_count++,
                            placeholder: 'Enter option ' + options_count,
                            value: value
                        })
                    );
                });
            }
            $('#form .field-group:last').find('.field-question').attr('id', question.question_id);
        });
    
        // Display questions within sections
        $.each(data.form_sections, function (key, section) {
            var section_count = section.section_id;
            var section_name = section.section_name;
    
            // Display the section
            if (section_count !== null) {
                $('#form').append(generateFormFieldGroup('section'));
                $('#form .field-group:last').attr('id', fieldcounter);
                $('#form .field-group:last').find('.field-section').attr('value', section_name);
                $('#form .field-group:last').find('.field-section').attr('id', section_count);
                $('#form .field-group:last').find('.field-question').addClass('field-section');
            }
    
            // Display questions within this section
            if (section_count in questionsBySection) {
                $.each(questionsBySection[section_count], function (key, question) {
                    $('#form').append(generateFormFieldGroup(question.question_type));
                    $('#form .field-group:last').attr('id', fieldcounter);
                    $('#form .field-group:last').find('.field-question').attr('value', question.question_text);
                    var questionType = question.question_type;
                    $('#form .field-group:last').find('.field-question').addClass('field-' + questionType);
    
                    if (questionType === 'scale') {
                        var options = question.options;
                        var labels = options['scale-labels'];
                        var statement = options['scale-statement'];
                        var statement_count = 1;
    
                        $.each(labels, function (key, value) {
                            $('#form .field-group:last').find('.scale-options').append(
                                $('<input>', {
                                    type: 'text',
                                    class: 'scale-input w-25 mb-2',
                                    name: 'end_scale_range' + key,
                                    placeholder: 'placeholder',
                                    value: value
                                })
                            );
                        });
    
                        $.each(statement, function (key, value) {
                            $('#form .field-group:last').find('.statements').append(
                                $('<input>', {
                                    type: 'text',
                                    class: 'scale-statement w-75 mb-1',
                                    name: 'scale_statement_' + statement_count,
                                    placeholder: 'Enter scale statement ' + statement_count,
                                    value: value
                                })
                            );
                            statement_count++;
                        });
                    } else if (questionType === 'choice' || questionType === 'dropdown') {
                        var options = question.options;
                        console.log(options);
                        var options_count = 1;
                        $.each(options, function (key, value) {
                            $('#form .field-group:last').find('.form-option-container').append(
                                $('<input>', {
                                    type: 'text',
                                    class: 'add-option-input w-75 mb-1',
                                    name: 'add_option_input' + options_count++,
                                    placeholder: 'Enter option ' + options_count,
                                    value: value
                                })
                            );
                        });
                    }
                    $('#form .field-group:last').find('.field-question').attr('id', question.question_id);
                });
            }
            });
    
            adjustButton();
            
        });
        console.log(page_count);
    
        // Create an array to hold questions without sections
        
        
    }
    

    function generateFormFieldGroup(selectedValue = 'paragraph') {
        var formGroup = $('<div>', {
            class: 'field-group',
            id: fieldcounter++
        }).append(
            $('<section>', { class: 'w-100' }).append(
                $('<input>', {
                    type: 'text',
                    class: 'field-question rounded',
                    placeholder: 'Question'
                }),
                $('<select>', {
                    name: 'field-option',
                    class: 'field-option rounded'
                }).append(
                    $("<option>", { value: "textbox", text: "Textbox" }),
                    $("<option>", { value: "paragraph", text: "Short Paragraph" }),
                    $("<option>", { value: "date", text: "Date" }),
                    $("<option>", { value: "time", text: "Time" }),
                    $("<option>", { value: "choice", text: "Multiple Choice" }),
                    $("<option>", { value: "dropdown", text: "Dropdown" }),
                    $("<option>", { value: "scale", text: "Linear Scale" }),
                    $("<option>", { value: "page", text: "Page" }),
                    $("<option>", { value: "section", text: "Section" })
                ).val(selectedValue)
            )
        );

        if (selectedValue === 'choice' || selectedValue === 'dropdown') {
            appendChoiceOptions(formGroup, selectedValue);

        } else if (selectedValue === 'date' || selectedValue === 'time') {
            appendDateOrTimeInput(formGroup, selectedValue);
        } else if (selectedValue === 'section' || selectedValue === 'page' || selectedValue === 'paragraph') {
            appendSectionOrPageInput(formGroup, selectedValue);
        } else if (selectedValue === 'scale') {
            appendScaleOptions(formGroup);
        } else if (selectedValue === 'textbox') {
            appendTextboxInput(formGroup);
        }
        renameField(formGroup, selectedValue);


        return formGroup;
    }

    function renameField(formGroup, selectedValue){
        var fieldID = formGroup.attr('id');
        var fieldname = 'input-field-'+ selectedValue + '-'+ fieldID;
        formGroup.find('.field-question').attr('name', fieldname);
    }

    function appendChoiceOptions(formGroup, selectedValue) {
        renameField(formGroup, selectedValue);
        formGroup.find('.field-question').attr('placeholder', 'Enter Question');
        formGroup.find('.field-question').addClass('field-' + selectedValue);
        formGroup.find('.field-question').attr('id', 0);
    
        var formOptions = $('<section>', {
            class: 'form-options w-100 my-1',
            id: 'form-options' + fieldcounter
        });
        formOptions.append(
            $('<div>', {
                class: 'form-option-container',
                id: 'form-option-container' + fieldcounter
            }),
            $('<a>', { href: 'javascript:void(0)', class: 'add-option' }).append(
                $('<small>').html(' Add option or <u>import from excel</u>')
            )
        );
        formGroup.append(formOptions);
    }
    

    function appendDateOrTimeInput(formGroup, selectedValue) {
        renameField(formGroup, selectedValue);
        formGroup.find('.field-question').addClass('field-' + selectedValue);
        formGroup.find('.field-question').attr('id', 0);
   
    }

    function appendSectionOrPageInput(formGroup, selectedValue) {
        renameField(formGroup, selectedValue);
        var inputElement;
        if (selectedValue === 'paragraph') {
            inputElement = $('<input>', {
                type: 'text',
                class: 'field-question field-paragraph rounded',
                id: 0, 
                name: 'field-paragraph_' + fieldcounter,
                placeholder: 'Enter Question'
            });
        } else {
            var inputType = selectedValue === 'section' ? 'field-section' : 'field-page';
            inputElement = $('<input>', {
                type: 'text',
                class: 'field-question ' + inputType + ' rounded',
                id: 0, 
                name: 'field-' + selectedValue + '_' + fieldcounter,
                placeholder: selectedValue === 'section' ? 'Section Name' : 'Page',
                disabled: selectedValue === 'page'
            });
        }
        formGroup.find('.field-question').replaceWith(inputElement);
    }
    function appendTextboxInput(formGroup) {
        var inputElement;
        inputElement = $('<input>', {
            type: 'text',
            class: 'field-question field-textbox rounded',
            id: 0, 
            name: 'field-textbox_' + fieldcounter,
            placeholder: 'Enter Question'
        });
        
        formGroup.find('.field-question').replaceWith(inputElement);
    }

    function appendScaleOptions(formGroup) {
        // renameField(formGroup, selectedValue);
        var fieldGroupId = formGroup.attr('id'); // Get the fieldGroupId
        formGroup.find('.field-question').attr('placeholder', 'Enter Scale Category');
        formGroup.find('.field-question').attr('id', 0);
        renameField(formGroup, 'scale');
        formGroup.find('.field-question').removeClass('field-paragraph').addClass('field-scale')
        var formOptions = $('<section>', { class: 'form-options w-100 my-1' });
    
        var scaleContainer = $('<div>', { class: 'd-flex w-100' });
        var scaleRange = $('<aside>', { class: 'scale-range d-flex flex-row me-5' });
        scaleRange.append(
            $('<select>', { name: 'startselect', class: 'rounded', id: 'start_select' }).append(
                $('<option>', { value: '1', text: '1' })
            ),
            $('<p>').text(' to '),
            $('<select>', { name: 'endselect', class: 'end_select' }).append(
                $('<option>', { value: '1', text: '1' }),
                $('<option>', { value: '2', text: '2' }),
                $('<option>', { value: '3', text: '3' }),
                $('<option>', { value: '4', text: '4' }),
                $('<option>', { value: '5', text: '5' })
            )
        );
        scaleContainer.append(scaleRange);
    
        var scaleLabels = $('<aside>', { class: 'd-flex flex-column w-100 ml-3' });
        scaleLabels.append(
            $('<p>').text('Scale Labels:'),
            $('<div>', { class: 'scale-options d-flex flex-column flex-wrap', id: fieldcounter })
            // You can append more scale-specific elements here if needed
        );
        scaleContainer.append(scaleLabels);
    
        formOptions.append(scaleContainer);
    
        // Generate a unique id for statementsContainer using the fieldGroupId
        var statementsContainerId = 'statements_' + fieldGroupId;
        var statementsContainer = $('<div>', { class: 'statements mt-5', id: statementsContainerId });
        statementsContainer.append($('<p>').html('<u>Statements:</u>'));
        formOptions.append(statementsContainer);
    
        formOptions.append(
        $('<a>', { href: 'javascript:void(0);', class: 'add-scale-statement' }).append(
                $('<small>').html(' Add option or <u>import from excel</u>')
            )
        );
    
        formGroup.append(formOptions);
    }

    function adjustButton(){
        var submit_btn = $('#form').find('#form-submit');
        submit_btn.css('width', '70%');
        $('#form').append(submit_btn);
    }
    
    if(isModifyMode){
        var fieldcounter = $('#form .field-group:last').attr('id');
        fieldcounter++;
        
    }else{
        var fieldcounter = 1;
        var statement_count = 1;
        var option_count = 1;
        var page_count = 1;
        var section_count = 0;
    }
    
  
    

    // Generates default formgroup/question box when the page first loads

    $('#form').on('change', '.field-option', function () {

        $($(this).closest('.field-group')).find('.form-options').remove();

        // var fieldGroupId = $(this).closest('.field-group').attr('id');
        var selectedValue = $(this).val();
        var formGroup = $(this).closest('.field-group');

        if (selectedValue === 'choice' || selectedValue === 'dropdown') {
            appendChoiceOptions(formGroup, selectedValue);
        } else if (selectedValue === 'date' || selectedValue === 'time') {
            appendDateOrTimeInput(formGroup, selectedValue);
        } else if (selectedValue === 'section' || selectedValue === 'page' || selectedValue === 'paragraph') {
            appendSectionOrPageInput(formGroup, selectedValue);
            renameField(formGroup, selectedValue)
        } else if (selectedValue === 'scale') {
            appendScaleOptions(formGroup);
        } else if (selectedValue === 'textbox') {
            appendTextboxInput(formGroup);
        }

    });


    // generatese new form-group/question box when add button is clicked on the side bar
    $('#add-btn').click(function () {
        $('#form').append(generateFormFieldGroup('textbox'));
        adjustButton();

    });
    $('#choice-btn').click(function () {
        $('#form').append(generateFormFieldGroup('choice'));
        adjustButton();

    });
    $('#date-btn').click(function () {
        $('#form').append(generateFormFieldGroup('date'));
        adjustButton();

    });
    $('#time-btn').click(function () {
        $('#form').append(generateFormFieldGroup('time'));
        adjustButton();

    });
    $('#page-btn').click(function () {
        $('#form').append(generateFormFieldGroup('page'));
        adjustButton();

    });
    $('#section-btn').click(function () {
        $('#form').append(generateFormFieldGroup('section'));
        adjustButton();

    });
    $('#text-btn').click(function () {
        $('#form').append(generateFormFieldGroup('paragraph'));
        adjustButton();

    });

    // GENERATING OF INPUT FIELDS ON RESPECTIVE QUESTION TYPE FIELD-GROUP

    $(document).on('click', '.add-scale-statement', function() {
        var fieldGroupId = $(this).closest('.field-group').attr('id');
    
        // Calculate the current statement count based on the existing statements
        var currentStatementCount = $('#' + fieldGroupId + ' .form-options .statements input.scale-statement').length + 1;
    
        var added_statement = $('<input>', {
            type: 'text',
            class: 'scale-statement w-75 mb-1',
            name: 'scale_statement_' + statement_count,
            placeholder: 'Enter scale statement ' + currentStatementCount
        });
        statement_count++;
    
        // Find the statements container within the same field-group and append the input element
        $(this).closest('.form-options').find('.statements').append(added_statement);
    });

    $(document).on('click', '.add-option', function() {
        var fieldGroupId = $(this).closest('.field-group').attr('id');
    
    //     // Calculate the current statement count based on the existing statements
        var currentOptionCount = $('#' + fieldGroupId + ' .form-options .form-option-container input.add-option-input').length + 1;
    
        var added_option = $('<input>', {
            type: 'text',
            class: 'add-option-input w-75 mb-1',
            name: 'add_option_input' + option_count++,
            placeholder: 'Enter option ' + currentOptionCount
        });
        option_count++;
    
    //     // Find the statements container within the same field-group and append the input element
        $(this).closest('.form-options').find('.form-option-container').append(added_option);
    });

    // Uncommented code for adding form options
    // TODO: WHERE IS THIS BEING USED?? 
    $('#form').on('click', '.form-add-option', function () {
        var fieldGroupId = $(this).closest('.field-group').attr('id');
    
        var added_option = $('<input>', {
            type: 'text',
            class: 'form-option-input w-75 mb-1',
            name: 'form_option_input_' + option_count++,
            placeholder: 'Enter option ' + option_count
        });
    
        $('#' + fieldGroupId + ' .form-option-container').append(added_option);
    });

    // Uncommented code for generating scale label text boxes
    $('#form').on('change', '.end_select', function () {
        var endSelectValue = parseInt($(this).val());
        var scaleOptions = '';

        for (var i = 0; i < endSelectValue; i++) {
            scaleOptions += '<input type="text" class="scale-input w-25 mb-2" name="end_scale_range' + i + '" placeholder="placeholder">';
        }

        $(this).closest('.field-group').find('.scale-options').html(scaleOptions);
    });

    

    
    $('#form-submit').click(function () {
        // console.log(isModifyMode);

        var actionType = isModifyMode ? 'modify form' : 'create form';
        formid = formid ? formid : null;

        
        var role = $(this).attr('value');
        var questionsData = [];
       
    
        $('.field-group').each(function() {
            var selectedValue = $(this).find('.field-option').val();
            var groupID = $(this).attr('id');
            var questionID = null;
            var option = null;
            // console.log('order ' + groupID);

            
            
    
            if (selectedValue === 'section') {
                if(isModifyMode){
                    section_count = $(this).find('.field-section').attr('id');
                }else{
                    section_count++;
                }
                var inputValue = $(this).find('.field-section').val();
            } else if (selectedValue === 'paragraph') {
                var inputValue = $(this).find('.field-paragraph').val();
            } else if (selectedValue === 'page') {
                var inputValue = $(this).find('.field-page').val();
                if(isModifyMode){
                    page_count = $(this).find('.field-page').attr('id');
                }else{
                    page_count++;
                }
            } else if (selectedValue === 'textbox') {
                var inputValue = $(this).find('.field-textbox').val();
            } else if (selectedValue === 'date'|| selectedValue === 'time') {
                var inputValue = $(this).find('.field-' + selectedValue).val();
            } else if (selectedValue === 'dropdown' || selectedValue === 'choice') {
                var inputValue = $(this).find('.field-' + selectedValue).val();
                option = {};
                var optionCounter = 1;
                $(this).find('.add-option-input').each(function() {
                    var optionValue = $(this).val();
                    if (optionValue.trim() !== '') {
                        option['option' + optionCounter] = optionValue;
                        optionCounter++;
                    }
                });
            } else if (selectedValue === 'scale') {
                var inputValue = $(this).find('.field-' + selectedValue).val();

                var scaleLabels = {};
                $(this).find('.scale-options .scale-input').each(function(index) {
                    var labelValue = $(this).val();
                    if (labelValue.trim() !== '') {
                        scaleLabels['label' + (index + 1)] = labelValue;
                    }
                });

                var scaleStatements = {};
                $(this).find('.statements .scale-statement').each(function(index) {
                    var statementValue = $(this).val();
                    if (statementValue.trim() !== '') {
                        scaleStatements['statement' + (index + 1)] = statementValue;
                    }
                });

                option = {
                    'scale-labels': scaleLabels,
                    'scale-statement': scaleStatements
                };
            } else {
                if($(this).hasClass('form-title')){
                    var inputValue = $('.form-title input[type="text"]').val();
                    selectedValue = 'form-title';
                }
        
            }

            if(isModifyMode){
                questionID = $(this).find('.field-question').attr('id');
                
            }else{
                var questionID = null;
            }
    
            var questionObj = {
                sectionID: section_count,
                questionID: questionID,
                question: inputValue,
                type: selectedValue,
                options: option,
                order: groupID,
                page: page_count
                
            };
            
            questionsData.push(questionObj);
        });
    
     
        var formData = {
            data: questionsData,
            action: { 'action': actionType, 'role': role }, 
            formid: formid
        };
        if (isModifyMode) {
            formData.formid = formid;
        }
        console.log(formData);

        $.ajax({
            type: 'POST',
            url: '../forms/event-listener.php', // URL to your PHP script
            data: { 
                data: JSON.stringify(formData),
                action: JSON.stringify({ 'action': actionType, 'role': role, 'formID': formid })
            },
            success: function(response) {
                // console.log(response);
                var cleanedResponse = response.replace(/\s/g, '');
                console.log(cleanedResponse);
                // Handle the response from the server if needed
                if(cleanedResponse === 'success'){
                    
                    window.location.href = '../forms/form.php';
                   
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors here
            }
        });
    });
    
    
});

    

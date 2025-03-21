"use strict";

var $table = $("#table_list"); // "table" accordingly
var electiveSubjectGroupCounter = 1;

$(function () {
    // $("#sortable-row").sortable({
    //     placeholder: "ui-state-highlight"
    // });
    function checkList(listName, newItem, id) {
        var dupl = false;
        $("#" + listName + " > div").each(function () {
            if ($(this)[0] !== newItem[0]) {
                if ($(this).find("li").attr('id') == newItem.find("li").attr('id')) {
                    dupl = true;
                }
            }
        });
        return dupl;
    }
    $('#table_list_exam_questions').on('check.bs.table', function (e, row) {
        var questions = $(this).bootstrapTable('getSelections');
        let li = ''
        $.each(questions, function (index, value) {
            if (value.question_type) {
                li = $('<div class="list-group"><input type="hidden" name="assign_questions[' + value.question_id + '][question_id]" value="' + value.question_id + '"><li id="q' + value.question_id + '"class="list-group-item d-flex justify-content-between align-items-center ui-state-default list-group-item-secondary m-2">' + value.question_id + ". " + value.question + ' <span class="text-right row"><input type="number" class="list-group-item col-md-6" name="assign_questions[' + value.question_id + '][marks]" style="width: 10rem"><a class="btn btn-danger btn-sm remove-row ml-2" data-id="' + value.question_id + '"><i class="fa fa-times" aria-hidden="true"></i></a></span></li></div>');
            } else {
                li = $('<div class="list-group"><input type="hidden" name="assign_questions[' + value.question_id + '][question_id]" value="' + value.question_id + '"><li id="q' + value.question_id + '"class="list-group-item d-flex justify-content-between align-items-center ui-state-default list-group-item-secondary m-2">' + value.question_id + ". " + '<span class="text-center">' + value.question + '</span> <span class="text-right row"><input type="number" class="list-group-item col-md-6" name="assign_questions[' + value.question_id + '][marks]" style="width: 10rem"><a class="btn btn-danger btn-sm remove-row ml-2" data-id="' + value.question_id + '"><i class="fa fa-times" aria-hidden="true"></i></a></span></li></div>');
            }
            var pasteItem = checkList("sortable-row", li, row.question_id);
            if (!pasteItem) {
                $("#sortable-row").append(li);
            }
        });
        createCkeditor();
    })
    $('#table_list_exam_questions').on('uncheck.bs.table', function (e, row) {
        $("#sortable-row > div").each(function () {
            $(this).find('#q' + row.question_id).remove();
        });
    })
    $table.bootstrapTable('destroy').bootstrapTable({
        exportTypes: ['csv', 'excel', 'pdf', 'txt', 'json'],
    });

    $("#toolbar")
        .find("select")
        .change(function () {
            $table.bootstrapTable("refreshOptions", {
                exportDataType: $(this).val()
            });
        });

    //File Upload Custom Component
    $('.file-upload-browse').on('click', function () {
        var file = $(this).parent().parent().parent().find('.file-upload-default');
        file.trigger('click');
    });
    $('.file-upload-default').on('change', function () {

        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    // tinymce.init({
    //     height: "400",
    //     selector: '#tinymce_message',
    //     menubar: 'file edit view formate tools',
    //     toolbar: [
    //         'styleselect fontselect fontsizeselect',
    //         'undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify',
    //         'bullist numlist | outdent indent | blockquote autolink | lists |  code'
    //     ],
    //     plugins: 'autolink link image lists code'
    // });

    $('.modal').on('hidden.bs.modal', function () {
        //Reset input file on modal close
        $('.file-upload-default').val('');
        $('.file-upload-info').val('');
    })
    /*simplemde editor*/
    if ($("#simpleMde").length) {
        var simplemde = new SimpleMDE({
            element: $("#simpleMde")[0],
            hideIcons: ["guide", "fullscreen", "image", "side-by-side"],
        });
    }

    //Color Picker Custom Component
    if ($(".color-picker").length) {
        $('.color-picker').asColorPicker({
            format: 'hex',
            keepInput: true, // Keep the input value in HEX format
            hideInput: true, // Hide the original input field
            onChange: function (color) {
                $('.color_value').val(color); // Update the HEX color value
            }
        });
    }

    //Added this for Dynamic No Future Date Picker input Initialization
    $('body').on('focus', ".datepicker-popup-no-future", function () {
        if (!$(this).hasClass('hasDatepicker')) {
            var today = new Date();
            var maxDate = new Date();
            maxDate.setDate(today.getDate());
            $(this).datepicker({
                enableOnReadonly: false,
                todayHighlight: true,
                format: "dd-mm-yyyy",
                endDate: maxDate,
            });
        }
    });


    //Added this for Dynamic Date Picker input Initialization
    $('body').on('focus', ".datepicker-popup", function () {
        // Check if the element has the `hasDatepicker` class
        if (!$(this).hasClass('hasDatepicker')) {
            $(this).datepicker({
                enableOnReadonly: false,
                todayHighlight: true,
                format: "dd-mm-yyyy",
            });
        }
    });


    //Time Picker
    if ($("#timepicker-example").length) {
        $('#timepicker-example').datetimepicker({
            format: 'LT'
        });
    }
    //Select
    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }
    // form reapeater
    $('.repeater').repeater({
        // (Optional)
        // "defaultValues" sets the values of added items.  The keys of
        // defaultValues refer to the value of the input's name attribute.
        // If a default value is not specified for an input, then it will
        // have its value cleared.
        defaultValues: {
            'text-input': 'foo'
        },
        // (Optional)
        // "show" is called just after an item is added.  The item is hidden
        // at this point.  If a show callback is not given the item will
        // have $(this).show() called on it.
        show: function () {
            $(this).slideDown();
        },
        // (Optional)
        // "hide" is called when a user clicks on a data-repeater-delete
        // element.  The item is still visible.  "hide" is passed a function
        // as its first argument which will properly remove the item.
        // "hide" allows for a confirmation step, to send a delete request
        // to the server, etc.  If a hide callback is not given the item
        // will be deleted.
        hide: function (deleteElement) {
            // if (confirm('Are you sure you want to delete this element?')) {
            //     $(this).slideUp(deleteElement);
            // }
            if ($(this).find('input:first').val() != '') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't to delete this element?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/timetable/" + $(this).find('input:first').val(),
                            type: "DELETE",
                            success: function (response) {
                                if (response['error'] == false) {
                                    showSuccessToast(response['message']);
                                    $(this).slideUp(deleteElement);
                                } else {
                                    showErrorToast(response['message']);
                                }
                            }
                        });
                    }
                })
            } else {
                $(this).slideUp(deleteElement);
            }
        },
        // (Optional)
        // Removes the delete button from the first list item,
        // defaults to false.
        isFirstItemUndeletable: true
    })
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

});
//Setup CSRF Token default in AJAX Request
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#create-form,.create-form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        formElement[0].reset();
        $('#table_list').bootstrapTable('refresh');
        setTimeout(function () {
            window.location.reload();
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$('#edit-form,.editform').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let data = new FormData(this);
    data.append("_method", "PUT");
    let url = $(this).attr('action') + "/" + data.get('edit_id');

    function successCallback(response) {
        $('#table_list').bootstrapTable('refresh');
        setTimeout(function () {
            $('#editModal').modal('hide');
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$(document).on('click', '.delete-form', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = $(this).attr('href');
            let data = null;

            function successCallback(response) {
                $('#table_list').bootstrapTable('refresh');
                showSuccessToast(response.message);
            }

            function errorCallback(response) {
                showErrorToast(response.message);
            }

            ajaxRequest('DELETE', url, data, null, successCallback, errorCallback);
        }
    })
})

$(document).on('click', '.add-feature', function (e) {
    e.preventDefault();

    let lastRow = $('.feature-row:last');
    let newRow = lastRow.clone();

    newRow.find(':input').each(function () {
        let name = $(this).attr('name');

        if (name) {
            $(this).attr('name', name.replace(/\[(\d+)\]/, function (match, index) {
                return '[' + (parseInt(index, 10) + 1) + ']';
            }));
        }
        $(this).val('');
    });

    newRow.find('.add-feature')
    .removeClass('add-feature btn-primary')
    .addClass('remove-feature btn-danger')
    .text('-');

    $('.extra-features').append(newRow);
});

$(document).on('click', '.remove-feature', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = $(this).data('url');

    if(id != null && url != null) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let data = null;
                function successCallback(response) {
                    showSuccessToast(response.message);
                    window.location.reload(true);
                }
    
                function errorCallback(response) {
                    showErrorToast(response.message);
                }
    
                ajaxRequest('DELETE', url, data, null, successCallback, errorCallback); 
            }
        })
    }else{
        $(this).closest('.feature-row').remove();
    }   
});

$('#tags').tagsInput({
    'width': '100%',
    'height': '75%',
    'interactive': true,
    'defaultText': "Add More",
    'removeWithBackspace': true,
    'minChars': 0,
    // 'maxChars': 20, // if not provided there is no limit
    'placeholderColor': '#666666'
});

$(document).on('click', '.add-category', function (e) {
    e.preventDefault();

    let lastRow = $('.category-row:last');
    let newRow = lastRow.clone();

    newRow.find(':input').each(function () {
        let name = $(this).attr('name');

        if (name) {
            $(this).attr('name', name.replace(/\[(\d+)\]/, function (match, index) {
                return '[' + (parseInt(index, 10) + 1) + ']';
            }));
        }
        $(this).val('');
    });

    newRow.find('.add-category')
    .removeClass('add-category btn-primary')
    .addClass('remove-category btn-danger')
    .text('-');

    $('.extra-category').append(newRow);
});

$(document).on('click', '.remove-category', function (e) {

    e.preventDefault();
    var id = $(this).data('id');
    var url = $(this).data('url');

    if(id != null && url != null) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let data = null;
                function successCallback(response) {
                    showSuccessToast(response.message);
                    window.location.reload(true);
                }
    
                function errorCallback(response) {
                    showErrorToast(response.message);
                }
    
                ajaxRequest('DELETE', url, data, null, successCallback, errorCallback); 
            }
        })

    }else{
        $(this).closest('.category-row').remove();
    }
   
});


$(document).on('click', '.add-key-feature', function (e) {
    e.preventDefault();

    let lastRow = $('.key-feature-row:last');
    let newRow = lastRow.clone();

    newRow.find(':input').each(function () {
        let name = $(this).attr('name');

        if (name) {
            $(this).attr('name', name.replace(/\[(\d+)\]/, function (match, index) {
                return '[' + (parseInt(index, 10) + 1) + ']';
            }));
        }
        $(this).val('');
    });

    newRow.find('.img-thumbnail').attr('src', '').hide(); 

    newRow.find('.add-key-feature')
    .removeClass('add-key-feature btn-primary')    
    .addClass('remove-key-feature btn-danger')
    .text('-');

    $('.extra-key-feature').append(newRow);
});

$(document).on('click', '.remove-key-feature', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');

    if(id != null && url != null) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let data = null;
                function successCallback(response) {
                    showSuccessToast(response.message);
                    window.location.reload(true);
                }
    
                function errorCallback(response) {
                    showErrorToast(response.message);
                }
    
                ajaxRequest('DELETE', url, data, null, successCallback, errorCallback); 
            }
        })
    }else{
        $(this).closest('.key-feature-row').remove();
    }
    
});

$(document).on('click', '.add-industry', function (e) {
    e.preventDefault();

    let lastRow = $('.industry-row:last');
    let newRow = lastRow.clone();

    newRow.find(':input').each(function () {
        let name = $(this).attr('name');

        if (name) {
            $(this).attr('name', name.replace(/\[(\d+)\]/, function (match, index) {
                return '[' + (parseInt(index, 10) + 1) + ']';
            }));
        }
        $(this).val('');
    });

    newRow.find('.img-thumbnail').attr('src', '').hide(); 

    newRow.find('.add-industry')
    .removeClass('add-industry btn-primary')    
    .addClass('remove-industry btn-danger')
    .text('-');

    $('.extra-industry').append(newRow);
});

$(document).on('click', '.remove-industry', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');

    if(id != null && url != null) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let data = null;
                function successCallback(response) {
                    showSuccessToast(response.message);
                    window.location.reload(true);
                }
    
                function errorCallback(response) {
                    showErrorToast(response.message);
                }
    
                ajaxRequest('DELETE', url, data, null, successCallback, errorCallback); 
            }
        })
    }else{
        $(this).closest('.industry-row').remove();
    }

});

$(document).on('click', '.remove-grade', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');

    if(id != null && url != null) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let data = null;
                function successCallback(response) {
                    showSuccessToast(response.message);
                    window.location.reload(true);
                }
    
                function errorCallback(response) {
                    showErrorToast(response.message);
                }
    
                ajaxRequest('DELETE', url, data, null, successCallback, errorCallback); 
            }
        })
    }else{
        $(this).closest('.industry-row').remove();
    }

});

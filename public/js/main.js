$(document).ready(function() {
    $('#btnSaveNewProduct').on('click', function() {
        var formdata = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'title': $('#title').val(),
            'description': $('#description').val(),
            'vendor': $('#vendor').val(),
            'product_type': $('#product_type').val(),
            'sku': $('#sku').val(),
            'price': $('#price').val(),
            'weight': $('#weight').val(),
            'images': images
        };

        var save = $.ajax({
            url: '/product/create',
            method: 'POST',
            dataType: 'json',
            data: formdata
        });

        save.done(function(ret) {
            switch (ret.status) {
                case 'success':
                    window.location = ret.location;
                    break;

                case 'error':
                    display_errors(ret.errors, 'msgErrors');
                    break;
            }
        });
    });

    var images = '';

    Dropzone.options.imageDropzone = {
        paramName: "productImage",
        maxFilesize: 2,
        maxFiles: 10,
        dictDefaultMessage: 'Drop product images here or click to select your image files for this product<br />Allowed file type is <strong>JPEG</strong>, maximum file size 2MB',
        addRemoveLinks: false,
        url: '/product/create/imageupload',
        success: function(file, response) {
            images = images + response.filename + ',';
        },
        sending: function(file, xhr, formData) {
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        },
        error: function(file, response) {
            if($.type(response) === "string")
                var message = response;
            else
                var message = response.message;
            file.previewElement.classList.add("dz-error");
            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i];
                _results.push(node.textContent = message);
            }
            return _results;
        },
        maxfilesexceeded: function() {
            alert('You have reached the image file limit (10).');
        }
    };
});


function display_errors(errors, element) {
    var errorHeader = '<div class="row"><div class="col-sm-12 no-padding"><div class="msg-errors"><div class="content">';
    var errorFooter = '</div></div></div></div>';

    var errorContent = errors.join('<br />');

    $('#msgNotifications').hide();
    $('#' + element).html(errorHeader + errorContent + errorFooter);

    $('html, body').animate({ scrollTop: 0 }, 'slow');
}
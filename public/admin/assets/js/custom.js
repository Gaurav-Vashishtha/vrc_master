
// for category
$(document).ready(function () {
    const baseUrl = $('meta[name="base-url"]').attr('content');

    // Load subcategories on category change
    $('#category_id').on('change', function () {
        const categoryId = $(this).val();
        const $subcategory = $('#subcategory_id');
        const $type = $('#type_id');

        $subcategory.html('<option value="">Loading...</option>');
        $type.html('<option value="">Select Type</option>');

        if (categoryId) {
            $.get(baseUrl + '/category/' + categoryId + '/subcategories', function (response) {
                let options = '<option value="">Select Subcategory</option>';
                response.subcategories.forEach(function (sub) {
                    options += `<option value="${sub.id}">${sub.name}</option>`;
                });
                $subcategory.html(options);
            }).fail(function () {
                $subcategory.html('<option value="">Failed to load</option>');
            });
        } else {
            $subcategory.html('<option value="">Select Subcategory</option>');
        }
    });

    // Load product types on subcategory change
    $('#subcategory_id').on('change', function () {
        const subcategoryId = $(this).val();
        const $type = $('#type_id');

        $type.html('<option value="">Loading...</option>');

        if (subcategoryId) {
            $.get(baseUrl + '/subcategory/' + subcategoryId + '/types', function (response) {
                let options = '<option value="">Select Type</option>';
                response.types.forEach(function (t) {
                    options += `<option value="${t.id}">${t.name}</option>`;
                });
                $type.html(options);
            }).fail(function () {
                $type.html('<option value="">Failed to load</option>');
            });
        } else {
            $type.html('<option value="">Select Type</option>');
        }
    });
});




// for brands
$('#brand_id').on('change', function () {
    const brandId = $(this).val();
    const baseUrl = $('meta[name="base-url"]').attr('content');
    const $mnfSelect = $('#mnfNameAdd_id');
    const $mrkSelect = $('#mrkNameAdd_id');

    $mnfSelect.html('<option value="">Loading...</option>');
    $mrkSelect.html('<option value="">Loading...</option>');

    if (brandId) {
        $.get(`${baseUrl}/brands/${brandId}/details`, function (response) {
            // Populate manufacturers
            let mnfOptions = '';
            response.manufacturers.forEach(item => {
                mnfOptions += `<option value="${item.id}">${item.name}, ${item.address}</option>`;
            });
            $mnfSelect.html(mnfOptions);

            // Populate marketers
            let mrkOptions = '';
            response.marketers.forEach(item => {
                mrkOptions += `<option value="${item.id}">${item.name}, ${item.address}</option>`;
            });
            $mrkSelect.html(mrkOptions);
        }).fail(function () {
            $mnfSelect.html('<option value="">Failed to load</option>');
            $mrkSelect.html('<option value="">Failed to load</option>');
        });
    } else {
        $mnfSelect.html('');
        $mrkSelect.html('');
    }
});



$('#forgotPasswordForm').on('submit', function (e) {
    e.preventDefault();

    const baseUrl = $('meta[name="base-url"]').attr('content');
    const email = $('#resetEmail').val();
    const errorBox = $('#forgotError');
    const successBox = $('#forgotSuccess');
    const btn = $('#send-reset-btn');

    // Reset messages
    errorBox.html('&nbsp;');
    successBox.html('');

    // Disable button and show spinner
    btn.prop('disabled', true).html(`Sending <span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span>`);

    $.ajax({
        url: `${baseUrl}/api/v1/forgotPassword`,
        method: 'POST',
        data: JSON.stringify({ email: email }),
        contentType: 'application/json',
        success: function (response) {
            if (response.status) {
                successBox.text(response.message || 'Reset link sent to your email.').show();
                $('#resetEmail').val('');
            } else {
                if (response.data?.error?.email?.length) {
                    errorBox.text(response.data.error.email[0]).show();
                } else {
                    errorBox.text(response.message || 'Something went wrong.').show();
                }
            }
        },
        error: function (xhr) {
            const res = xhr.responseJSON;

            if (res?.data?.error?.email?.length) {
                errorBox.text(res.data.error.email[0]).show();
            } else if (res?.message) {
                errorBox.text(res.message).show();
            } else {
                errorBox.text('An unexpected error occurred.').show();
            }
        },
        complete: function () {
            btn.prop('disabled', false).html('Send Reset Link');
        }
    });
});
@extends('admin.template.base')
@section('title', 'Edit User')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin">
                <a href="{{ route('admin.user-list') }}">
                    <i class="mdi mdi-keyboard-backspace" style="font-size: 25px;"></i>
                </a>

                <div class="card mt-2">
                    <div class="card-body">
                        <h4 class="card-title">Edit User</h4>

                        <form id="userEditForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- Name --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                                        <span id="product_error_first_name" class="text-danger error_msg"></span>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                        <span id="product_error_email" class="text-danger error_msg"></span>
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                        <span id="product_error_phone" class="text-danger error_msg"></span>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Change Password (optional)</label>
                                        <input type="password" name="password" class="form-control">
                                        <span id="product_error_password" class="text-danger error_msg"></span>
                                    </div>
                                </div>

                                {{-- User Type --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>User Type <span class="text-danger">*</span></label>
                                        <select name="usertype" class="form-control select2">
                                            <option value="1" {{ $user->usertype == 1 ? 'selected' : '' }}>Admin</option>
                                            <option value="2" {{ $user->usertype == 2 ? 'selected' : '' }}>Seller</option>
                                            <option value="3" {{ $user->usertype == 3 ? 'selected' : '' }}>Customer</option>
                                        </select>
                                        <span id="product_error_usertype" class="text-danger error_msg"></span>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <span id="product_error_status" class="text-danger error_msg"></span>
                                    </div>
                                </div>  

                                {{-- Submit --}}
                                <div class="col-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status" aria-hidden="true"></span>
                                        Update User
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div id="alertBox" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('#userEditForm').on('submit', function (e) {
        e.preventDefault();
        $('.error_msg').text('');
        $('#alertBox').html('');

        const formData = $(this).serialize();
        const $submitBtn = $('#userEditForm button[type="submit"]');
        const $spinner = $('#submitSpinner');

        $submitBtn.prop('disabled', true);
        $spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('admin.user.update', $user->id) }}",
            type: "POST",
            data: formData,
            success: function (response) {
                $('#alertBox').html('<div class="alert alert-success">' + response.message + '</div>');
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $('#product_error_' + field).text(errors[field][0]);
                    }
                } else {
                    $('#alertBox').html('<div class="alert alert-danger">Something went wrong.</div>');
                }
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            },
            complete: function () {
                $submitBtn.prop('disabled', false);
                $spinner.addClass('d-none');
            }
        });
    });
});
</script>
@endsection
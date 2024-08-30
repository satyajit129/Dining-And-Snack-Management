<!DOCTYPE html>

<html lang="en">

<head>

    @include('backend.global.css_support')
    
</head>

<body class="bg-light-gray" id="body">
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="d-flex flex-column justify-content-between">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10">
                    <div class="card card-default mb-0">
                        <div class="card-header pb-0">
                        </div>
                        <div class="card-body px-5 pb-5 pt-0">

                            <h4 class="text-dark mb-6 text-center">Sign in for free</h4>



                            <form id="loginForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <x-input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" />
                                    <x-input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Enter your PassWord" />
                                    <x-button id="loginButton" type="submit" class="btn-primary btn-block btn-pill" additionalClass="mb-4">
                                        <span id="loginButtonText">Sign In</span>
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('backend.global.js_support')
    <script>
        $(document).ready(function() {
            $('#loginButton').click(function(e) {
                e.preventDefault(); 
                var formData = $('#loginForm').serialize();
                
                $.ajax({
                    url: "{{ route('adminLoginRequest') }}", 
                    method: 'POST', 
                    data: formData,
                    success: function(response) {
                        if (response.redirect_url) { 
                            window.location.href = response.redirect_url;
                        } else {
                            toastr.error('Unexpected response from the server.', 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loginButtonText').show(); 
                        $('#loginButtonLoader').hide(); 
    
                        0
                    }
                });
            });
        });
    </script>
    
</body>

</html>

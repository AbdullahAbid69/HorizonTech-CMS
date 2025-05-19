<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizon Tech</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, rgb(255, 255, 255) 0%, rgb(231, 231, 231) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #1C355E;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 8px 20px rgba(27, 17, 85, 0.19);
            padding: 2rem;
            width: 100%;
            max-width: 600px;
            animation: fadeIn 1s ease;
            color: #ffffff;
            height: 500px;
        }

        .login-card a {
            color: rgb(229, 224, 255);
        }

        .image-card {
            background: rgb(255, 255, 255);
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            border: 2px solid rgb(255, 255, 255);
            box-shadow: 0 8px 20px rgba(27, 17, 85, 0.19);
            padding: 2rem;
            width: 100%;
            max-width: 600px;
            animation: fadeIn 1s ease;
            align-items: center;
            justify-content: center;
            justify-items: center;
            align-content: center;
            height: 500px;
        }

        .image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control:focus {
            box-shadow: none;
            border-color: rgb(255, 255, 255);
        }

        .btn-primary {
            background: rgb(255, 255, 255);
            border: none;
            color: #1C355E;
        }

        .btn-primary:hover {
            background: rgb(12, 23, 41);
        }

        .toggle-password {
            position: absolute;
            top: 68%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

    <div class="image-card">
        <img src="{{ asset('authpage-images/login.png') }}" alt="Login Image" class="img-fluid">
    </div>

    <div class="login-card">
        <h4 class="text-center">Create your account</h4>

        <form id="signupForm" method="POST" action="{{ route('student.basic') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="role" value="UnRegistered">
            <input type="hidden" name="status" value="active">
            <div class="row g-4">
                <div class="col-lg-12">

                    {{-- Display all validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Full Name"
                            value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Father Name</label>
                        <input type="text" name="fatherName" class="form-control" placeholder="Father's Name"
                            value="{{ old('fatherName') }}" required>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone"
                            value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password" required>
                    </div>
                </div>

                <div class="col-lg-6">
                    <label for="">Enter Profile Image</label>
                    <div class="form-group">
                        <input type="file" name="photoOfStudent" class="form-control" required accept="image/*">
                    </div>
                </div>
            </div>
            <div class="row">
                <span class="text-center mt-2">Already Have Account <a href="{{ route('loginPage') }}">Login</a></span>
            </div>

            <div class="text-end mt-3">
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
        </form>
        <div id="errorContainer" class="alert alert-danger d-none"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signupForm');

            const fields = {
                name: {
                    element: document.querySelector('input[name="name"]'),
                    message: 'Full Name is required.'
                },
                fatherName: {
                    element: document.querySelector('input[name="fatherName"]'),
                    message: "Father's Name is required."
                },
                email: {
                    element: document.querySelector('input[name="email"]'),
                    message: 'Valid email is required.'
                },
                phone: {
                    element: document.querySelector('input[name="phone"]'),
                    message: 'Phone is required.'
                },
                password: {
                    element: document.querySelector('input[name="password"]'),
                    message: 'Password is required.'
                },
                confirmPassword: {
                    element: document.querySelector('input[name="password_confirmation"]'),
                    message: 'Passwords must match.'
                },
                // photo: {
                //     element: document.querySelector('input[name="photoOfStudent"]'),
                //     message: 'Profile Image is required.'
                // }
            };

            Object.keys(fields).forEach(key => {
                const field = fields[key];

                field.element.addEventListener('blur', function() {
                    validateField(key);
                });

                if (key === 'name' || key === 'fatherName') {
                    field.element.addEventListener('input', function() {
                        this.value = this.value.replace(/\d/g, ''); // Remove numbers
                    });
                }
            });

            function validateField(key) {
                const field = fields[key];
                const value = field.element.value.trim();
                let isValid = true;

                if (!value) {
                    isValid = false;
                    field.element.placeholder = field.message;
                } else {
                    if (key === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        isValid = false;
                        field.element.placeholder = 'Invalid email format.';
                    }
                    if (key === 'phone' && !/^[0-9]+$/.test(value)) {
                        isValid = false;
                        field.element.placeholder = 'Phone must contain only digits.';
                    }
                    if (key === 'confirmPassword' && value !== fields.password.element.value.trim()) {
                        isValid = false;
                        field.element.placeholder = 'Passwords do not match.';
                    }
                    if (key === 'photo' && !/(\.jpg|\.jpeg|\.png|\.gif)$/i.test(value)) {
                        isValid = false;
                        field.element.placeholder = 'Invalid image file type.';
                    }
                }

                if (!isValid) {
                    field.element.classList.add('is-invalid');
                    field.element.style.backgroundColor = '#f8d7da'; // Light red background
                } else {
                    field.element.classList.remove('is-invalid');
                    field.element.style.backgroundColor = ''; // Reset background color
                }
            }

            const photoInput = document.querySelector('input[name="photoOfStudent"]');
            photoInput.addEventListener('change', function(e) {
                const file = this.files[0];
                if (file && !file.type.match(/^image\/(jpeg|png|gif|bmp|webp)$/)) {
                    toastr.error('Only image files (jpg, jpeg, png, gif, bmp, webp) are allowed.');
                    this.value = '';
                }
            });
        });
    </script>

    @if (Session::has('success'))
        <script>
            toastr.options = {
                "progressBar": true,
                "closeButton": true,
            }
            toastr.success("{{ Session::get('success') }}");
        </script>
    @elseif (Session::has('error'))
        <script>
            toastr.options = {
                "progressBar": true,
                "closeButton": true,
            }
            toastr.error("{{ Session::get('error') }}");
        </script>
    @endif
</body>

</html>
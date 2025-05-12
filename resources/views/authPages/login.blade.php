<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizon Tech</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg,rgb(255, 255, 255) 0%,rgb(231, 231, 231) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #1C355E;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            border: 2px solidrgb(255, 255, 255);
            box-shadow: 0 8px 20px rgba(27, 17, 85, 0.19);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            animation: fadeIn 1s ease;
            color: #ffffff;
            height: 500px;
        }
        .login-card a{
            color:rgb(229, 224, 255);
        }
        .image-card{
            background:rgb(255, 255, 255);
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            border: 2px solidrgb(255, 255, 255);
            box-shadow: 0 8px 20px rgba(27, 17, 85, 0.19);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            animation: fadeIn 1s ease;
            height: 500px;
            align-items: center;
            justify-content: center;
            justify-items: center;
            align-content: center;
        }
        .image-card img{
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
            border-color:rgb(255, 255, 255);
        }

        .btn-primary {
            background:rgb(255, 255, 255);
            border: none;
            color: #1C355E;
        }

        .btn-primary:hover {
            background:rgb(12, 23, 41);
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
        <h2 class="text-center mb-4">Welcome Back</h2>
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 position-relative">
                <label for="role" class="form-label">Login As</label>
                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="alumni" {{ old('role') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 position-relative">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}"
    class="form-control @error('email') is-invalid @enderror" 
    id="email" required data-bs-toggle="tooltip" title="Please enter a valid email.">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" @error('password') is-invalid @enderror
                    id="password" required>
                <span class="toggle-password" id="togglePassword"><i class="fa-solid fa-eye" style="color: #1C355E;"></i></span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script>
    // Enable all tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Validation script
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        let formIsValid = true;

        // Get inputs
        const role = document.getElementById('role');
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        // Role check
        if (role.value === '') {
            role.classList.add('is-invalid');
            role.setAttribute('title', 'Please select a role.');
            bootstrap.Tooltip.getInstance(role).show();
            formIsValid = false;
        } else {
            role.classList.remove('is-invalid');
        }

        // Email check
        const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if (!emailPattern.test(email.value)) {
            email.classList.add('is-invalid');
            email.setAttribute('title', 'Enter a valid email address.');
            bootstrap.Tooltip.getInstance(email).show();
            formIsValid = false;
        } else {
            email.classList.remove('is-invalid');
        }

        // Password check
        if (password.value.length < 6) {
            password.classList.add('is-invalid');
            password.setAttribute('title', 'Password must be at least 6 characters.');
            bootstrap.Tooltip.getInstance(password).show();
            formIsValid = false;
        } else {
            password.classList.remove('is-invalid');
        }

        if (!formIsValid) {
            event.preventDefault(); // Stop form submission
        }
    });
</script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');

        const fields = {
            role: {
                element: document.getElementById('role'),
                message: 'Please select a role.'
            },
            email: {
                element: document.getElementById('email'),
                message: 'Valid email is required.'
            },
            password: {
                element: document.getElementById('password'),
                message: 'Password is required and must be at least 6 characters.'
            }
        };

        Object.keys(fields).forEach(key => {
            const field = fields[key];

            field.element.addEventListener('blur', function() {
                validateField(key);
            });
        });

        form.addEventListener('submit', function(event) {
            let isValid = true;

            Object.keys(fields).forEach(key => {
                if (!validateField(key)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
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
                    field.element.placeholder = 'Invalid email format. Example: user@example.com';
                }
                if (key === 'password' && value.length < 6) {
                    isValid = false;
                    field.element.placeholder = 'Password must be at least 6 characters.';
                }
            }

            if (!isValid) {
                field.element.classList.add('is-invalid');
                field.element.style.backgroundColor = '#f8d7da'; // Light red background
            } else {
                field.element.classList.remove('is-invalid');
                field.element.style.backgroundColor = ''; // Reset background color
            }

            return isValid;
        }
    });
</script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' ? '<i class="fa-solid fa-eye" style="color: #1C355E;"></i>' : '<i class="fa-solid fa-eye-slash" style="color: #1C355E;"></i>';
        });



    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
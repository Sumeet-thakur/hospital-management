<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Portal - Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a3a 0%, #0f1a24 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            background: #0d6efd;
            padding: 25px 20px;
            text-align: center;
            color: white;
        }
        
        .login-header i {
            font-size: 2.2rem;
            margin-bottom: 8px;
        }
        
        .login-header h3 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }
        
        .login-header p {
            margin: 4px 0 0;
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 25px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            font-weight: 500;
            margin-bottom: 6px;
            color: #2c3e50;
            display: block;
            font-size: 0.85rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13,110,253,0.1);
        }
        
        .checkbox-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
        }
        
        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0;
            font-size: 0.8rem;
            color: #4a5568;
        }
        
        .btn-login {
            width: 100%;
            padding: 10px;
            background: #0d6efd;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: #0b5ed7;
        }
        
        .forgot-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .forgot-link a {
            color: #0d6efd;
            text-decoration: none;
            font-size: 0.75rem;
        }
        
        .forgot-link a:hover {
            text-decoration: underline;
        }
        
        .demo-box {
            margin-top: 20px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .demo-box p {
            margin: 0;
            font-size: 0.7rem;
            color: #6c757d;
            text-align: center;
        }
        
        .demo-box strong {
            color: #0d6efd;
        }
        
        .alert-danger {
            background: #f8d7da;
            border: none;
            border-radius: 8px;
            color: #842029;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-hospital"></i>
            <h3>HMS Portal</h3>
            <p>Hospital Management System</p>
        </div>
        
        <div class="login-body">
            @if($errors->any())
                <div class="alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> Invalid credentials
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
                
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
                
                <div class="forgot-link">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
                
                <div class="demo-box">
                    <p><i class="fas fa-info-circle me-1"></i> Demo Credentials:</p>
                    <p class="mt-1">
                        <strong>Admin:</strong> admin@hospital.com / password<br>
                        <strong>Doctor:</strong> rajesh@hospital.com / password<br>
                        <strong>Patient:</strong> rahul@patient.com / password
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
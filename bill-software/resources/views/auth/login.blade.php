<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math-Themed Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0C1A2A;
            --secondary-color: #1E3A5F;
            --accent-color: #4A90E2;
            --light-color: #E8F1FF;
        }
        
        body {
            background-color: var(--primary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: white;
        }
        
        .login-container {
            min-height: 100vh;
        }
        
        .left-panel, .right-panel {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .left-panel {
            background-color: var(--secondary-color);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .right-panel {
            background-color: var(--secondary-color);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .center-panel {
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background-color: var(--secondary-color);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: white;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: var(--light-color);
            opacity: 0.8;
        }
        
        .form-label {
            color: white;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
            color: white;
        }
        
        .input-group-text {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.7);
        }
        
        .btn-login {
            background-color: var(--accent-color);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: #3a7bc8;
            transform: translateY(-2px);
        }
        
        .forgot-password {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        .forgot-password:hover {
            color: #3a7bc8;
            text-decoration: underline;
        }
        
        .register-link {
            color: var(--accent-color);
            font-weight: 600;
            text-decoration: none;
        }
        
        .register-link:hover {
            color: #3a7bc8;
            text-decoration: underline;
        }
        
        .math-display {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-family: 'Courier New', monospace;
        }
        
        .math-equation {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: white;
        }
        
        .math-steps {
            font-size: 1.1rem;
            color: var(--light-color);
            opacity: 0.9;
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon {
            background-color: var(--accent-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .feature-content h4 {
            color: white;
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
        }
        
        .feature-content p {
            color: var(--light-color);
            opacity: 0.8;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .stats-container {
            display: flex;
            justify-content: space-around;
            text-align: center;
            margin-top: 2rem;
        }
        
        .stat-item h3 {
            color: var(--accent-color);
            font-weight: 700;
            margin-bottom: 0.2rem;
        }
        
        .stat-item p {
            color: var(--light-color);
            opacity: 0.8;
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        @media (max-width: 992px) {
            .left-panel, .right-panel {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row h-100">
            <!-- Left Panel -->
            <div class="col-lg-4 left-panel">
                <div class="math-display">
                    <div class="math-equation">1.2 × 0.5 = 0.48</div>
                    <div class="math-steps">
                        1.2<br>
                        × 0.5<br>
                        -----<br>
                        0.48
                    </div>
                </div>
                
                <h3 class="mb-4">Why Choose Our Platform?</h3>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Advanced Calculations</h4>
                        <p>Perform complex mathematical operations with our intuitive tools and get accurate results instantly.</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Data Visualization</h4>
                        <p>Transform your data into meaningful insights with our powerful visualization capabilities.</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Collaborative Workspace</h4>
                        <p>Work together with your team in real-time on projects and share your findings seamlessly.</p>
                    </div>
                </div>
                
                <div class="stats-container">
                    <div class="stat-item">
                        <h3>10K+</h3>
                        <p>Active Users</p>
                    </div>
                    <div class="stat-item">
                        <h3>95%</h3>
                        <p>Satisfaction Rate</p>
                    </div>
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p>Support</p>
                    </div>
                </div>
            </div>
            
            <!-- Center Panel - Login Form -->
            <div class="col-lg-4 center-panel">
                <div class="login-card">
                    <div class="login-header">
                        <h2>Welcome Back</h2>
                        <p>Sign in to your account to continue</p>
                    </div>
                    
                    <form method="POST" action="/login">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Username or Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Enter your username or email" required>
                            </div>
                            @error('username')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Remember me
                                </label>
                            </div>
                            <a href="/forgot-password" class="forgot-password">Forgot password?</a>
                        </div>
                        
                        <button class="btn btn-login w-100 mb-3">Sign In</button>
                        
                        <div class="text-center">
                            <span class="text-light">Don't have an account? <a href="/register" class="register-link">Create one now</a></span>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Right Panel -->
            <div class="col-lg-4 right-panel">
                <h3 class="mb-4">What Our Users Say</h3>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Sarah Johnson</h4>
                        <p>"This platform has revolutionized how I approach complex calculations. The interface is intuitive and the results are always accurate."</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Michael Chen</h4>
                        <p>"As a data scientist, I rely on precise calculations daily. This tool has become an indispensable part of my workflow."</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Emily Rodriguez</h4>
                        <p>"The collaborative features have made team projects so much easier. We can now work together in real-time from anywhere."</p>
                    </div>
                </div>
                
                <div class="math-display mt-4">
                    <div class="math-equation">Try Our Software</div>
                    <div class="math-steps">
                        Experience the power of our advanced calculation engine with a simple, intuitive interface.
                    </div>
                    <button class="btn btn-login mt-3">Try Software</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
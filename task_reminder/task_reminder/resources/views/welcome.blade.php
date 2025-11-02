<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskReminder - Simple Task Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #7f8396ff 0%, #a39aacff 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .brand {
            color: #3b82f6;
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .tagline {
            color: #64748b;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #3b82f6;
            margin-bottom: 1rem;
        }

        .btn-hero {
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="hero-section text-center">
                    <h1 class="brand">
                        <i class="fas fa-bell me-3"></i>TaskReminder
                    </h1>
                    <p class="tagline">Simple and effective task management with reminders</p>
                    
                    <div class="row mb-5">
                        <div class="col-md-4 mb-4">
                            <div class="feature-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <h5>Create Tasks</h5>
                            <p class="text-muted">Quickly add tasks with reminders</p>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="feature-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <h5>Set Reminders</h5>
                            <p class="text-muted">Never forget important tasks</p>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h5>Track Progress</h5>
                            <p class="text-muted">Monitor your task completion</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-hero">
                            <i class="fas fa-rocket me-2"></i>Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-hero">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        @else
                         <a href="{{ route('dashboard') }}" class="btn btn-primary btn-hero">
                        <i class="fas fa-tachometer-alt me-2"></i> Go to Dashboard
                    </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Comments CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .comment-log {
            font-size: 0.9em;
            padding: 10px;
            margin: 5px 0;
            background: #f8f9fa;
            border-radius: 4px;
        }

        /* Pagination Styles */
        .pagination {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .pagination .page-item .page-link {
            padding: 8px 16px;
            color: #0d6efd;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Bigger arrows for Previous/Next */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-size: 20px;
            padding: 4px 16px;
            font-weight: bold;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        .pagination .page-item .page-link:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            text-decoration: none;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

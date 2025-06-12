<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 15.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Session Expired</h1>
        <p class="text-gray-600 mb-6">
            Your session has expired for security reasons. This usually happens when:
        </p>
        
        <ul class="text-left text-gray-600 mb-6 space-y-2">
            <li class="flex items-start">
                <span class="text-red-500 mr-2">•</span>
                You've been inactive for too long
            </li>
            <li class="flex items-start">
                <span class="text-red-500 mr-2">•</span>
                Your browser cookies have been cleared
            </li>
            <li class="flex items-start">
                <span class="text-red-500 mr-2">•</span>
                The page has been open for an extended period
            </li>
        </ul>
        
        <div class="space-y-3">
            <button onclick="window.location.reload()" 
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                Refresh Page
            </button>
            
            <a href="{{ route('login') }}" 
               class="block w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                Go to Login
            </a>
            
            <a href="{{ url('/') }}" 
               class="block w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                Go to Home
            </a>
        </div>
        
        <div class="mt-6 text-sm text-gray-500">
            <p>Error Code: 419 - Page Expired</p>
        </div>
    </div>
    
    <script>
        // Auto refresh after 5 seconds if user doesn't interact
        setTimeout(function() {
            if (confirm('Would you like to refresh the page automatically?')) {
                window.location.reload();
            }
        }, 5000);
    </script>
</body>
</html>

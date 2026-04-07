<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SoundFlow - Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN (can remove if you have your own compiled CSS) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #000000;
            color: #ffffff;
        }

        .text-primary-custom {
            color: #ff531a !important;
        }

        .bg-primary-custom {
            background-color: #ff531a !important;
        }

        .bg-primary-custom:hover {
            background-color: #e64611 !important;
        }

        .border-primary-custom {
            border-color: #ff531a !important;
        }

        .btn-primary {
            background-color: #ff531a;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            background-color: #e64611;
        }

        .input-primary {
            background-color: #020617; /* slate-950 */
            border: 1px solid #27272a; /* zinc-800 */
            color: #e5e5e5;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            width: 100%;
        }

        .input-primary:focus {
            outline: none;
            border-color: #ff531a;
            box-shadow: 0 0 0 1px rgba(255, 83, 26, 0.3);
        }

        .form-error {
            color: #f97373;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

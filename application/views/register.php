<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SoundFlow – Register</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom Theme Variables -->
    <style>
        :root {
            --primary: #ff531a;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#0f0f0f] to-[hsl(263,40%,15%)] flex items-center justify-center px-4 text-white">

    <div class="w-full max-w-md">

        <!-- Logo + Heading -->
        <div class="text-center mb-8">
            <a href="<?php echo base_url(); ?>" class="inline-flex items-center gap-2 mb-4">
                <i data-lucide="music" class="w-10 h-10 text-[var(--primary)]"></i>
                <span class="text-3xl font-bold bg-gradient-to-r from-[var(--primary)] to-[hsl(220,70%,60%)] bg-clip-text text-transparent">
                    SoundFlow
                </span>
            </a>

            <h1 class="text-3xl font-bold mb-2">Start Your Journey</h1>
            <p class="text-gray-400">Create your artist account</p>
        </div>

        <!-- Register Box -->
        <div class="bg-[#111] border border-gray-800 rounded-lg p-8">

            <form action="<?php echo base_url('auth/register'); ?>" method="POST" class="space-y-6">

                <!-- Artist Name -->
                <div class="space-y-2">
                    <label class="text-sm font-medium">Artist Name</label>
                    <input 
                        type="text" 
                        name="artist_name" 
                        class="w-full bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                        placeholder="Your artist name"
                    >
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-sm font-medium">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="w-full bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                        placeholder="artist@example.com"
                    >
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-sm font-medium">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                    >
                </div>

                <!-- Submit -->
                <button 
                    type="submit"
                    class="w-full py-3 rounded-lg text-white font-semibold bg-gradient-to-r from-[var(--primary)] to-[hsl(220,70%,60%)] hover:opacity-90 transition"
                >
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center text-sm">
                <p class="text-gray-400">
                    Already have an account?
                    <a href="<?php echo base_url('login'); ?>" class="text-[var(--primary)] hover:underline">
                        Sign in
                    </a>
                </p>
            </div>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>

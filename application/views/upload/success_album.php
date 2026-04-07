<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Album Uploaded — SoundFlow</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body class="min-h-screen bg-gradient-to-br from-background to-[hsl(263,40%,10%)] text-foreground">

    <!-- HEADER -->
    <header class="border-b border-border bg-black">
        <div class="container mx-auto px-6 h-16 flex items-center justify-between">
            <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" 
                     viewBox="0 0 24 24"><path d="M9 18V5l12-2v13"></path></svg>
                <span class="text-2xl font-bold">SoundFlow</span>
            </a>
        </div>
    </header>

    <!-- CONTENT -->
    <div class="container mx-auto px-6 py-20">
        <div class="max-w-3xl mx-auto bg-card border border-border rounded-xl p-12 text-center">

            <div class="w-20 h-20 rounded-full bg-green-600/20 border border-green-600 mx-auto mb-6 flex items-center justify-center">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2" 
                     viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h1 class="text-4xl font-bold mb-4">Album Submitted Successfully!</h1>

            <p class="text-muted-foreground text-lg mb-8 max-w-xl mx-auto">
                Your album has been saved and sent for processing.  
                We will review and deliver it to your selected stores.  
                You can now track the release status from your dashboard.
            </p>

            <!-- Album ID Display -->
            <div class="text-sm bg-black/40 border border-border rounded-lg px-4 py-2 inline-block mb-10">
                <strong>Album ID:</strong> <?= $album_id ?>
            </div>

            <!-- Actions -->
            <div class="flex flex-col md:flex-row justify-center gap-4 mt-6">
                <a href="<?= base_url('dashboard') ?>"
                   class="bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] px-8 py-4 rounded-full font-semibold hover:opacity-90 transition">
                    Go to Dashboard
                </a>

                <a href="<?= base_url('upload') ?>"
                   class="border border-white/20 px-8 py-4 rounded-full font-semibold hover:bg-white/10 transition">
                    Upload Another Release
                </a>
            </div>

            <!-- OPTIONAL: Social Share -->
            <div class="mt-12">
                <p class="text-muted-foreground mb-4">Share Your Upcoming Album</p>
                <div class="flex gap-4 justify-center">

                    <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 
                            1.2-3.1 3-3.1 .9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 
                            1.2V12h2.4l-.4 3h-2v7A10 10 0 0 0 22 12z" />
                        </svg>
                    </a>

<a href="#" class="w-10 h-10 bg-sky-500 rounded-full flex items-center justify-center hover:bg-sky-600">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 0 1-3.2 1.3 
                            4.48 4.48 0 0 0-7.7 4v1A10.66 10.66 
                            0 0 1 3 4s-4 9 5 13a11.64 11.64 0 
                            0 1-7 2c9 5 20 0 20-11.5 0-.28 
                            0-.56-.02-.83A7.72 7.72 0 
                            0 0 23 3z"/>
                        </svg>
                    </a>

                    <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 
                            2.1.4 2.8.8a5.6 5.6 0 
                            0 1 2 2c.4.7.7 1.6.8 2.8.1 
                            1.2.1 1.6.1 4.8s0 3.6-.1 
                            4.8c-.1 1.2-.4 2.1-.8 
                            2.8a5.6 5.6 0 0 1-2 
                            2c-.7.4-1.6.7-2.8.8-1.2.1-1.6.1-4.8.1s-3.6 
                            0-4.8-.1c-1.2-.1-2.1-.4-2.8-.8a5.6 
                            5.6 0 0 1-2-2c-.4-.7-.7-1.6-.8-2.8C2.2 
                            15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c.1-1.2.4-2.1.8-2.8a5.6 
                            5.6 0 0 1 2-2c.7-.4 1.6-.7 2.8-.8C8.4 
                            2.2 8.8 2.2 12 2.2m0-2.2C8.7 
                            0 8.3 0 7.1.1A7.8 7.8 0 
                            0 0 4.2 1a7.9 7.9 0 0 0-2.9 
                            2.9A7.8 7.8 0 0 0 1.1 
                            7.1C1 8.3 1 8.7 1 12s0 
                            3.7.1 4.9a7.8 7.8 0 0 0 .8 
                            2.9 7.9 7.9 0 0 0 2.9 2.9 7.8 
                            7.8 0 0 0 2.9.8c1.2.1 1.6.1 
                            4.9.1s3.7 0 4.9-.1a7.8 7.8 0 
                            0 0 2.9-.8 7.9 7.9 0 
                            0 0 2.9-2.9 7.8 7.8 0 0 0 
                            .8-2.9c.1-1.2.1-1.6.1-4.9s0-3.7-.1-4.9a7.8 
                            7.8 0 0 0-.8-2.9 7.9 7.9 0 0 0-2.9-2.9 7.8 
                            7.8 0 0 0-2.9-.8C15.7 0 15.3 0 12 0z" />
                        </svg>
                    </a>

                </div>
            </div>

        </div>
    </div>

</body>
</html>

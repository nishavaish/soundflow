<div class="w-full max-w-md mx-auto">
    <div class="bg-white border border-zinc-800 rounded-2xl shadow-xl p-8">
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-custom/10 mb-3">
                <!-- Music Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18V5l12-2v13" />
                    <circle cx="6" cy="18" r="3" />
                    <circle cx="18" cy="16" r="3" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold mb-1 text-black">Welcome back</h1>
            <p class="text-sm text-gray-400">Login to continue to <span class="text-primary-custom font-semibold">SoundFlow</span></p>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-4 rounded-lg bg-red-950/40 border border-red-500/40 text-red-200 text-sm px-4 py-3">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="mb-4 rounded-lg bg-emerald-950/40 border border-emerald-500/40 text-emerald-200 text-sm px-4 py-3">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php echo form_open('login'); ?>

        <div class="mb-4">
            <label class="block text-sm mb-1 text-black" for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo set_value('email'); ?>"
                class="input-primary"
                placeholder="you@example.com"
            >
            <?php echo form_error('email', '<p class="form-error">', '</p>'); ?>
        </div>

        <div class="mb-6">
            <label class="block text-sm mb-1 text-black" for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="input-primary"
                placeholder="••••••••"
            >
            <?php echo form_error('password', '<p class="form-error">', '</p>'); ?>
        </div>

        <div class="mb-6 flex items-center justify-between text-xs text-gray-400">
            <div>
                <!-- Implement remember me later if needed -->
                <!--
                <label class="inline-flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" class="rounded border-zinc-700 bg-zinc-900 text-primary-custom focus:ring-0">
                    <span>Remember me</span>
                </label>
                -->
            </div>
            <a href="#" class="hover:text-primary-custom transition-colors">Forgot password?</a>
        </div>

        <button type="submit" class="btn-primary w-full justify-center">
            Login
        </button>

        <?php echo form_close(); ?>

        <p class="mt-6 text-center text-sm text-gray-400">
            Don't have an account?
            <a href="<?php echo site_url('register'); ?>" class="text-primary-custom hover:underline">
                Create one
            </a>
        </p>
    </div>
</div>

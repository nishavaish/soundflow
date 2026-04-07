<div class="w-full max-w-md mx-auto">
    <div class="bg-zinc-900/80 border border-zinc-800 rounded-2xl shadow-xl p-8">
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-custom/10 mb-3">
                <!-- Plus / User Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4z" />
                    <path d="M6 20a6 6 0 0 1 12 0" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold mb-1">Create your account</h1>
            <p class="text-sm text-gray-400">Join <span class="text-primary-custom font-semibold">SoundFlow</span> &amp; start distributing your music.</p>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-4 rounded-lg bg-red-950/40 border border-red-500/40 text-red-200 text-sm px-4 py-3">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php echo form_open('register'); ?>

        <div class="mb-4">
            <label class="block text-sm mb-1" for="name">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo set_value('name'); ?>"
                class="input-primary"
                placeholder="Your artist / full name"
            >
            <?php echo form_error('name', '<p class="form-error">', '</p>'); ?>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1" for="email">Email</label>
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

        <div class="mb-4">
            <label class="block text-sm mb-1" for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="input-primary"
                placeholder="at least 6 characters"
            >
            <?php echo form_error('password', '<p class="form-error">', '</p>'); ?>
        </div>

        <div class="mb-6">
            <label class="block text-sm mb-1" for="password_confirm">Confirm Password</label>
            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                class="input-primary"
                placeholder="re-enter password"
            >
            <?php echo form_error('password_confirm', '<p class="form-error">', '</p>'); ?>
        </div>

        <button type="submit" class="btn-primary w-full justify-center">
            Create Account
        </button>

        <?php echo form_close(); ?>

        <p class="mt-6 text-center text-sm text-gray-400">
            Already have an account?
            <a href="<?php echo site_url('login'); ?>" class="text-primary-custom hover:underline">
                Login
            </a>
        </p>
    </div>
</div>

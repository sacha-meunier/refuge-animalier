<!-- resources/views/components/dev-quick-login.blade.php -->
@if(config('app.debug'))
    <div class="flex flex-col gap-2 p-3 bg-yellow-500/10 border border-yellow-500/50 rounded">
        <span class="text-xs font-semibold text-yellow-600 dark:text-yellow-400">🛠️ Dev Quick Login</span>
        <div class="flex gap-2">
            <button
                type="button"
                onclick="fillLoginForm('admin@admin.com', 'admin')"
                class="text-xs px-3 py-1 bg-yellow-500/20 hover:bg-yellow-500/30 rounded border border-yellow-500/50 transition"
            >
                Fill Admin
            </button>
            <button
                type="button"
                onclick="fillLoginForm('volunteer@volunteer.com', 'volunteer')"
                class="text-xs px-3 py-1 bg-yellow-500/20 hover:bg-yellow-500/30 rounded border border-yellow-500/50 transition"
            >
                Fill Volunteer
            </button>
        </div>
    </div>

    @once
        <script>
            function fillLoginForm(email, password) {
                document.querySelector('input[name="email"]').value = email;
                document.querySelector('input[name="password"]').value = password;
                document.querySelector('input[name="remember"]').checked = true;
            }
        </script>
    @endonce
@endif

@extends('admin.layouts.app')

@section('title', 'Edit User - Toko Obat Jaya Mulya')
@section('page-title', 'Edit User')

@section('content')
<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <div class="flex items-center space-x-4 mb-6">
        <a href="{{ route('user.index') }}"
           class="group inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 dark:from-gray-700 dark:to-gray-800 dark:hover:from-gray-600 dark:hover:to-gray-700 text-gray-600 dark:text-gray-300 transition-all duration-200 hover:shadow-lg transform hover:scale-110 hover:-translate-y-0.5 active:scale-95">
            <i data-lucide="arrow-left" class="h-5 w-5 sm:h-6 sm:w-6 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
        </a>
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Edit User</h1>
            <p class="text-sm sm:text-base text-muted-foreground">Edit akun pengguna</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 sm:p-8 !pt-2">
            <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-foreground border-b border-border pb-2">Informasi Personal</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="nama" class="block text-sm font-medium text-foreground mb-2">Nama</label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   value="{{ old('nama', $user->nama) }}"
                                   required
                                   class="{{ $errors->has('nama') ? 'border-red-500' : 'border-gray-500' }} w-full px-4 py-3 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                   placeholder="Masukkan nama">
                            @error('nama')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="text" class="block text-sm font-medium text-foreground mb-2">Username</label>
                            <input type="text"
                                   id="text"
                                   name="username"
                                   value="{{ old('username', $user->username) }}"
                                   required
                                   class="{{ $errors->has('username') ? 'border-red-500' : 'border-gray-500' }} w-full px-4 py-3 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                   placeholder="Masukkan username">
                            @error('username')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="password" class="block text-sm font-medium text-foreground mb-2">Password</label>
                            <div class="relative">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="{{ $errors->has('password') ? 'border-red-500' : 'border-gray-500' }} w-full px-4 py-3 pr-12 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                       placeholder="Masukkan password">
                                <button type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors duration-200 p-2 min-h-[44px] min-w-[44px] flex items-center justify-center active:scale-95">
                                    <i data-lucide="eye" id="eyeIcon" class="h-5 w-5"></i>
                                    <i data-lucide="eye-off" id="eyeOffIcon" class="h-5 w-5 hidden"></i>
                                </button>
                            </div>
                            <p class="text-xs text-muted-foreground mt-1">Minimal 8 karakter</p>
                            @error('password')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-foreground mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="{{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-500' }} w-full px-4 py-3 pr-12 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                       placeholder="Ulangi password">
                                <button type="button"
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors duration-200 p-2 min-h-[44px] min-w-[44px] flex items-center justify-center active:scale-95">
                                    <i data-lucide="eye" id="eyeIconConfirm" class="h-5 w-5"></i>
                                    <i data-lucide="eye-off" id="eyeOffIconConfirm" class="h-5 w-5 hidden"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-foreground mb-2">Role</label>
                    <select id="role"
                            name="role"
                            required
                            class="{{ $errors->has('role') ? 'border-red-500' : 'border-gray-500' }} w-full px-4 py-3 bg-muted border rounded-lg text-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]">
                        <option value="admin" {{ $user->role == 'admin' || old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ $user->role == 'kasir' || old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-border">
                    <button type="submit"
                            class="group flex-1 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 text-white px-8 py-3.5 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 flex items-center justify-center font-semibold text-base transform hover:-translate-y-0.5 min-h-[48px] active:scale-95">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <i data-lucide="user-plus" class="mr-2.5 h-5 w-5 transition-transform duration-300 group-hover:scale-110"></i>
                        <span class="relative z-10">Edit User</span>
                    </button>

                    <a href="{{ route('user.index') }}"
                       class="group flex-1 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 dark:from-gray-700 dark:to-gray-800 dark:hover:from-gray-600 dark:hover:to-gray-700 text-gray-700 dark:text-gray-300 px-8 py-3.5 rounded-xl transition-all duration-300 flex items-center justify-center font-semibold text-base transform hover:-translate-y-0.5 min-h-[48px] active:scale-95">
                        <i data-lucide="x" class="mr-2.5 h-5 w-5 transition-transform duration-300 group-hover:scale-110"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId === 'password' ? 'eyeIcon' : 'eyeIconConfirm');
    const eyeOffIcon = document.getElementById(fieldId === 'password' ? 'eyeOffIcon' : 'eyeOffIconConfirm');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeOffIcon.classList.remove('hidden');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeOffIcon.classList.add('hidden');
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    form.addEventListener('submit', function(e) {
        if (password.value !== passwordConfirmation.value && password.value !== '') {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            passwordConfirmation.focus();
        } else {
        }
        
        if(password.value == '') {

            document.querySelector('button[type=submit]').addEventListener('click', function() {
                setTimeout(() => {
                    this.disabled = true;
                    this.style.opacity = '0.5';
                    this.style.cursor = 'not-allowed';
                }, 1)
            })
        }
    });
    
});

</script>
@endsection

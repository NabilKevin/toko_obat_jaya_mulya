@extends('admin.layouts.app')

@section('title', 'Edit Obat - Toko Obat Jaya Mulya')
@section('page-title', 'Edit Obat')

@section('content')
<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <div class="flex items-center space-x-4 mb-6">
        <a href="{{ route('obat.index') }}"
           class="group inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 dark:from-gray-700 dark:to-gray-800 dark:hover:from-gray-600 dark:hover:to-gray-700 text-gray-600 dark:text-gray-300 transition-all duration-200 hover:shadow-lg transform hover:scale-110 hover:-translate-y-0.5 active:scale-95">
            <i data-lucide="arrow-left" class="h-5 w-5 sm:h-6 sm:w-6 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
        </a>
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Edit Obat</h1>
            <p class="text-sm sm:text-base text-muted-foreground">Edit obat yang sudah ada</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 sm:p-8 !pt-2">
            <form action="{{ route('obat.update', $obat->id) }}" method="POST" class="space-y-6">
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
                                    value="{{ old('nama', $obat->nama) }}"
                                    required
                                    class="{{ $errors->has('nama') ? 'border-red-500' : 'border-gray-500' }} w-full px-4 py-3 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                    placeholder="Masukkan nama">
                                @error('nama')
                                    <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="stok" class="block text-sm font-medium text-foreground mb-2">Stok</label>
                                <input type="number"
                                    id="stok"
                                    name="stok"
                                    value="{{ old('stok', $obat->stok) }}"
                                    required
                                    class="{{ $errors->has('stok') ? 'border-red-500' : 'border-gray-500' }} appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [moz-appearance:textfield] w-full px-4 py-3 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                    placeholder="Masukkan stok">
                                @error('stok')
                                    <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="tipe" class="block text-sm font-medium text-foreground mb-2">Tipe obat</label>
                            <select id="tipe"
                                    name="tipe"
                                    required
                                    value="{{ old('tipe') }}"
                                    class="{{ $errors->has('tipe') ? 'border-red-500' : 'border-gray-500' }} w-full px-4 py-3 bg-muted border rounded-lg text-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]">
                                <option 
                                    value="bebas"
                                    {{ $obat->tipe == 'bebas' || old('tipe') == 'bebas' ? 'selected' : '' }}
                                >
                                    Bebas
                                </option>
                                <option 
                                    value="bebas terbatas" 
                                    {{ $obat->tipe == 'bebas terbatas' || old('tipe') == 'bebas terbatas' ? 'selected' : '' }}
                                >
                                    Bebas Terbatas
                                </option>
                                <option 
                                    value="keras"          
                                    {{ $obat->tipe == 'keras' || old('tipe') == 'keras' ? 'selected' : '' }}
                                >
                                    Keras
                                </option>
                                <option 
                                    value="narkotika"      
                                    {{ $obat->tipe == 'narkotika' || old('tipe') == 'narkotika' ? 'selected' : '' }}
                                >
                                    Narkotika
                                </option>
                                <option 
                                    value="psikotropika"   
                                    {{ $obat->tipe == 'psikotropika' || old('tipe') == 'psikotropika' ? 'selected' : '' }}
                                >
                                    Psikotropika
                                </option>
                            </select>
                            @error('tipe')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="harga_modal" class="block text-sm font-medium text-foreground mb-2">Harga modal</label>
                            <input type="number"
                                   id="harga_modal"
                                   name="harga_modal"
                                   value="{{ old('harga_modal', $obat->harga_modal) }}"
                                   required
                                   class="{{ $errors->has('harga_modal') ? 'border-red-500' : 'border-gray-500' }} appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [moz-appearance:textfield] w-full px-4 py-3 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                   placeholder="Masukkan Harga Modal">
                            @error('harga_modal')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="harga_jual" class="block text-sm font-medium text-foreground mb-2">Harga jual</label>
                            <input type="number"
                                   id="harga_jual"
                                   name="harga_jual"
                                   value="{{ old('harga_jual', $obat->harga_jual) }}"
                                   required
                                   class="{{ $errors->has('harga_jual') ? 'border-red-500' : 'border-gray-500' }} appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [moz-appearance:textfield] w-full px-4 py-3 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                   placeholder="Masukkan Harga Jual">
                            @error('harga_jual')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="expired_at" class="block text-sm font-medium text-foreground mb-2">Expired</label>
                            <input type="date"
                                   id="expired_at"
                                   name="expired_at"
                                   value="{{ old('expired_at', \Carbon\Carbon::parse($obat->expired_at)->format('Y-m-d')) }}"
                                   required
                                   class="{{ $errors->has('expired_at') ? 'border-red-500' : 'border-gray-500' }} appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [moz-appearance:textfield] w-full px-4 py-3 bg-muted border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base min-h-[48px]"
                                   placeholder="Masukkan tanggal expired">
                            @error('expired_at')
                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-border">
                    <button type="submit"
                            class="group flex-1 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 text-white px-8 py-3.5 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 flex items-center justify-center font-semibold text-base transform hover:-translate-y-0.5 min-h-[48px] active:scale-95">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <i data-lucide="obat-plus" class="mr-2.5 h-5 w-5 transition-transform duration-300 group-hover:scale-110"></i>
                        <span class="relative z-10">Buat Obat</span>
                    </button>

                    <a href="{{ route('obat.index') }}"
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

document.querySelector('button[type=submit]').addEventListener('click', function() {
    setTimeout(() => {
        this.disabled = true;
        this.style.opacity = '0.5';
        this.style.cursor = 'not-allowed';
    }, 1)
})

</script>
@endsection

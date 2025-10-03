@extends('admin.layouts.app')

@section('title', 'Tambah Obat - Toko Obat Jaya Mulya')
@section('page-title', 'Tambah Obat')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-background via-secondary to-muted">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
         {{-- Enhanced header with better visual hierarchy --}}
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <a href="{{ route('admin.obat') }}"
                   class="group inline-flex items-center justify-center w-12 h-12 rounded-2xl shadow-soft hover:shadow-medium text-muted-foreground hover:text-primary transition-all duration-300 hover:scale-105 active:scale-95">
                    <i data-lucide="arrow-left" class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
                </a>
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-foreground mb-2">Tambah Obat Baru</h1>
                    <p class="text-muted-foreground text-lg">Buat obat baru</p>
                </div>
            </div>
        </div>

         {{-- Enhanced form card with sophisticated design --}}
        <div class="rounded-3xl shadow-large border border-border overflow-hidden">
             {{-- Form header --}}
            <div class="bg-gradient-to-r from-primary/5 to-accent/5 px-8 py-6 border-b border-border">
                <div class="flex items-center space-x-3">
                    <div>
                        <h2 class="text-xl font-semibold text-foreground">Informasi Obat</h2>
                        <p class="text-sm text-muted-foreground">Lengkapi data untuk membuat obat baru</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.obat.store') }}" method="POST">
                    @csrf

                     {{-- Enhanced personal information section --}}
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 pb-4 border-b border-border">
                            <h3 class="text-lg font-semibold text-foreground">Informasi Obat</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="lg:col-span-2">
                                <div class="relative group">
                                    <input type="text"
                                           id="kode_barcode"
                                           name="kode_barcode"
                                           required
                                           value="{{ old('kode_barcode') }}"
                                           class="{{ $errors->has('kode_barcode') ? 'border-red-500' : 'border-gray-500' }} peer w-full px-4 pt-6 pb-2 bg-muted border-2 border-border rounded-2xl text-foreground placeholder-transparent focus:outline-none focus:ring-0 focus:border-primary transition-all duration-300 text-base min-h-[64px] hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 focus:shadow-xl focus:shadow-primary/10"
                                           placeholder="Masukkan Kode Barcode">
                                    <label for="kode_barcode"
                                           class="absolute left-4 top-2 text-xs font-medium text-muted-foreground transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                        Kode Barcode
                                    </label>
                                    <button type="button"
                                            id="openScannerBtn"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl transition-all duration-200 text-sm font-medium shadow-sm hover:shadow-md active:scale-95">
                                        <i data-lucide="scan" class="h-4 w-4"></i>
                                        <span>Scan</span>
                                    </button>
                                    @error('kode_barcode')
                                        <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                    @enderror
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-primary/5 to-accent/5 opacity-0 peer-focus:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="relative group">
                                    <input type="text"
                                           id="nama"
                                           name="nama"
                                           required
                                           value="{{ old('nama') }}"
                                           class="{{ $errors->has('nama') ? 'border-red-500' : 'border-gray-500' }} peer w-full px-4 pt-6 pb-2 bg-muted border-2 border-border rounded-2xl text-foreground placeholder-transparent focus:outline-none focus:ring-0 focus:border-primary transition-all duration-300 text-base min-h-[64px] hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 focus:shadow-xl focus:shadow-primary/10"
                                           placeholder="Masukkan nama">
                                    <label for="nama"
                                           class="absolute left-4 top-2 text-xs font-medium text-muted-foreground transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                        Nama
                                    </label>
                                    @error('nama')
                                        <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                    @enderror
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-primary/5 to-accent/5 opacity-0 peer-focus:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="relative group">
                                    <input type="number"
                                           id="stok"
                                           name="stok"
                                           required
                                           value="{{ old('stok') }}"
                                           class="{{ $errors->has('stok') ? 'border-red-500' : 'border-gray-500' }} appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [moz-appearance:textfield] peer w-full px-4 pt-6 pb-2 bg-muted border-2 border-border rounded-2xl text-foreground placeholder-transparent focus:outline-none focus:ring-0 focus:border-primary transition-all duration-300 text-base min-h-[64px] hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 focus:shadow-xl focus:shadow-primary/10"
                                           placeholder="stok">
                                    <label for="stok"
                                           class="absolute left-4 top-2 text-xs font-medium text-muted-foreground transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                        Stok
                                    </label>
                                    @error('stok')
                                      <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                    @enderror
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-primary/5 to-accent/5 opacity-0 peer-focus:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            </div>

                            <div class="space-y-6 lg:col-span-2	">

                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        {{-- Enhanced select field with floating label effect --}}
                                        <div class="relative group">
                                            <select id="tipe_id"
                                                    name="tipe_id"
                                                    required
                                                    class="{{ $errors->has('tipe_id') ? 'border-red-500' : 'border-gray-500' }} peer w-full px-4 pt-6 pb-2 bg-muted border-2 border-border rounded-2xl text-foreground focus:outline-none focus:ring-0 focus:border-primary transition-all duration-300 text-base min-h-[64px] hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 focus:shadow-xl focus:shadow-primary/10 appearance-none cursor-pointer">
                                                <option value="" class="text-muted-foreground">Pilih Tipe Obat</option>
                                                @foreach ($tipeobat as $tipe)
                                                    <option value="{{ $tipe->id }}" class="text-foreground" {{ old('tipe_id') == $tipe->id ? 'selected' : '' }}>{{ $tipe->nama }}</option>
                                                @endforeach
                                            </select>
                                            <label for="tipe_id"
                                                class="absolute left-4 top-2 text-xs font-medium text-muted-foreground transition-all duration-200 peer-focus:text-primary">
                                                Tipe obat
                                            </label>
                                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                                    <i data-lucide="chevron-down" class="h-5 w-5 text-muted-foreground transition-transform duration-200 peer-focus:rotate-180"></i>
                                            </div>
                                            @error('tipe_id')
                                                <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                            @enderror
                                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-primary/5 to-accent/5 opacity-0 peer-focus:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-1">
                                <div class="relative group">
                                    <input type="text"
                                           id="harga_modal"
                                           required
                                           value="{{ old('harga_modal') }}"
                                           class="{{ $errors->has('harga_modal') ? 'border-red-500' : 'border-gray-500' }} peer w-full px-4 pt-6 pb-2 pr-16 bg-muted border-2 border-border rounded-2xl text-foreground placeholder-transparent focus:outline-none focus:ring-0 focus:border-primary transition-all duration-300 text-base min-h-[64px] hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 focus:shadow-xl focus:shadow-primary/10"
                                           placeholder="Masukkan harga_modal">
                                        <input type="hidden"
                                           id="harga_modal_hidden"
                                           name="harga_modal"
                                           required>
                                    <label for="harga_modal"
                                           class="absolute left-4 top-2 text-xs font-medium text-muted-foreground transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                        Harga Modal
                                    </label>
                                    @error('harga_modal')
                                      <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                    @enderror
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-primary/5 to-accent/5 opacity-0 peer-focus:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            </div>

                            <div class="lg:col-span-1">
                                <div class="relative group">
                                    <input type="text"
                                           id="harga_jual"
                                           required
                                           value="{{ old('harga_jual') }}"
                                           class="{{ $errors->has('harga_jual') ? 'border-red-500' : 'border-gray-500' }} peer w-full px-4 pt-6 pb-2 pr-16 bg-muted border-2 border-border rounded-2xl text-foreground placeholder-transparent focus:outline-none focus:ring-0 focus:border-primary transition-all duration-300 text-base min-h-[64px] hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 focus:shadow-xl focus:shadow-primary/10"
                                           placeholder="Harga jual">
                                    <input type="hidden"
                                           id="harga_jual_hidden"
                                           name="harga_jual"
                                           required>
                                    <label for="harga_jual"
                                           class="absolute left-4 top-2 text-xs font-medium text-muted-foreground transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                        Harga Jual
                                    </label>
                                    @error('harga_jual')
                                      <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                    @enderror
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-primary/5 to-accent/5 opacity-0 peer-focus:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="relative group">
                                    <input type="date"
                                           id="expired_at"
                                           name="expired_at"
                                           required
                                           value="{{ old('expired_at') }}"
                                           class="{{ $errors->has('expired_at') ? 'border-red-500' : 'border-gray-500' }} peer w-full px-4 pt-6 pb-2 bg-muted border-2 border-border rounded-2xl text-foreground placeholder-transparent focus:outline-none focus:ring-0 focus:border-primary transition-all duration-300 text-base min-h-[64px] hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 focus:shadow-xl focus:shadow-primary/10"
                                           placeholder="expired_at">
                                    <label for="expired_at"
                                           class="absolute left-4 top-2 text-xs font-medium text-muted-foreground transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                        Expired
                                    </label>
                                    @error('expired_at')
                                      <p class="text-red-500 text-xs font-medium italic mt-2 mb-0">{{ $message }}</p>
                                    @enderror
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-primary/5 to-accent/5 opacity-0 peer-focus:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                     {{-- Enhanced action buttons --}}
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-border">
                        <button type="submit"
                                class="group flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-2xl shadow-medium hover:shadow-large ring-1 ring-primary/20 transition-all duration-300 flex items-center justify-center font-semibold text-base transform hover:scale-[1.02] hover:-translate-y-0.5 min-h-[56px] active:scale-[0.98]">
                            <span class="relative z-10">Buat Obat Baru</span>
                        </button>

                        <a href="{{ route('admin.obat') }}"
                           class="group flex-1 bg-muted hover:bg-muted/80 border-2 border-border text-foreground px-8 py-4 rounded-2xl transition-all duration-300 flex items-center justify-center font-semibold text-base transform hover:scale-[1.02] hover:-translate-y-0.5 min-h-[56px] active:scale-[0.98] shadow-soft hover:shadow-medium">
                            <span>Batal</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 {{-- Enhanced form card with sophisticated design --}}
<div id="scannerModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-neutral-900 rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden">
        {{-- Modal header --}}
        <div class="flex items-center justify-between p-6 border-b border-border">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center">
                    <i data-lucide="scan" class="h-5 w-5 text-primary"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-foreground">Scan Barcode</h3>
                    <p class="text-sm text-muted-foreground">Arahkan kamera ke barcode produk</p>
                </div>
            </div>
            <button type="button"
                    id="closeScannerBtn"
                    class="w-10 h-10 rounded-xl hover:bg-muted flex items-center justify-center transition-colors"
                    aria-label="Tutup scanner">
                <i data-lucide="x" class="h-5 w-5 text-muted-foreground"></i>
            </button>
        </div>

        {{-- Camera preview --}}
        <div class="relative bg-black aspect-video">
            <video id="scannerVideo"
                   class="w-full h-full object-cover"
                   autoplay
                   playsinline>
            </video>
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-64 h-40 border-4 border-primary rounded-2xl shadow-lg shadow-primary/50 animate-pulse"></div>
                </div>
            </div>
            {{-- Status overlay --}}
            <div id="scannerStatus" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-3 bg-black/80 backdrop-blur-md rounded-full text-white text-sm font-medium shadow-xl hidden">
                <i data-lucide="loader-2" class="inline h-4 w-4 animate-spin mr-2"></i>
                <span>Memindai...</span>
            </div>
        </div>

        {{-- Result display --}}
        <div id="scanResult" class="hidden p-6 border-t border-border bg-gradient-to-br from-success/5 to-primary/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-success/20 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="check-circle" class="h-5 w-5 text-success"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-muted-foreground">Barcode Terdeteksi</p>
                    <p id="scanResultText" class="text-lg font-bold text-foreground truncate"></p>
                </div>
            </div>
        </div>

        {{-- Error display --}}
        <div id="scanError" class="hidden p-6 border-t border-border bg-red-500/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="alert-circle" class="h-5 w-5 text-red-500"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-red-600 dark:text-red-400" id="scanErrorText"></p>
                </div>
            </div>
        </div>
    </div>
</div>

 {{-- JavaScript for password toggle functionality --}}
<script src="{{ asset('js/admin/obat/form.js') }}"></script>

<script src="{{ asset('js/cam.js') }}"></script>

@endsection

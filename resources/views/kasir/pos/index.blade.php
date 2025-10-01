@extends('kasir.layouts.app')

@section('title', 'POS - Kasir')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <section class="lg:col-span-2">
      <div class="rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-3">
        <form action="#" method="GET" class="flex gap-2">
          <input name="q" placeholder="Scan / ketik nama obat..." class="flex-1 h-10 rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 px-3 text-sm focus:ring-2 focus:ring-primary" />
          <button type="button" id="btn-open-scanner" class="h-10 px-4 rounded-md border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800">Scan Kamera</button>
          <button type="submit" class="h-10 px-4 rounded-md text-primary-foreground bg-gradient-to-r from-blue-600 to-blue-700 hover:scale-105 transition-all active:scale-95">Cari</button>
        </form>
      </div>

      <div class="mt-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 overflow-hidden">
        <div class="px-4 py-2 text-sm font-medium">Katalog</div>
        <div class="divide-y divide-neutral-100 dark:divide-neutral-800 max-h-80 overflow-auto">
          <div class="flex items-center justify-between px-4 py-2">
            <div>
              <div class="font-medium">Contoh Obat</div>
              <div class="text-xs text-neutral-500">Stok: 0</div>
            </div>
            <button class="text-sm px-3 py-1.5 rounded-md border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800">Tambah</button>
          </div>
        </div>
      </div>
    </section>

    <aside class="lg:col-span-1">
      <div class="rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950">
        <div class="px-4 py-3 border-b border-neutral-200 dark:border-neutral-800 font-medium">Keranjang</div>
        <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
          <div class="px-4 py-3 text-sm text-neutral-500">Belum ada item</div>
        </div>
        <div class="p-4 space-y-1 text-sm">
          <div class="flex justify-between"><span>Subtotal</span><span>Rp 0</span></div>
          <div class="flex justify-between"><span>PPN 11%</span><span>Rp 0</span></div>
          <div class="flex justify-between font-semibold"><span>Total</span><span>Rp 0</span></div>
        </div>
        <div class="p-4 pt-0">
          <button class="w-full h-10 rounded-md text-primary-foreground bg-gradient-to-r from-blue-600 to-blue-700 transition-all active:scale-95">Bayar</button>
        </div>
      </div>
    </aside>
  </div>

  <div id="scanner-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true" role="dialog" aria-labelledby="scanner-title">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative mx-auto my-8 max-w-lg rounded-lg border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 shadow-lg">
      <div class="flex items-center justify-between px-4 py-3 border-b border-neutral-200 dark:border-neutral-800">
        <h2 id="scanner-title" class="text-sm font-medium">Pindai Barcode</h2>
        <button id="btn-close-scanner" type="button" aria-label="Tutup" class="text-sm px-3 py-1.5 rounded-md border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800">
          Tutup
        </button>
      </div>
      <div class="p-4">
        <video id="scanner-video" class="w-full rounded-md bg-neutral-900 aspect-video" autoplay playsinline></video>
        <p id="scanner-status" class="mt-2 text-xs text-neutral-500">Arahkan kamera ke barcode. Pastikan pencahayaan cukup.</p>
      </div>
    </div>
  </div>

  <script>
    (() => {
      const openBtn = document.getElementById('btn-open-scanner');
      const modal = document.getElementById('scanner-modal');
      const closeBtn = document.getElementById('btn-close-scanner');
      const video = document.getElementById('scanner-video');
      const statusEl = document.getElementById('scanner-status');
      const searchInput = document.querySelector('input[name="q"]');

      let stream = null;
      let rafId = null;
      let detector = null;
      let canvas = null;
      let ctx = null;

      function showModal() {
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        startScanner();
      }

      function hideModal() {
        stopScanner();
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
      }

      async function startScanner() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
          statusEl.textContent = 'Perangkat tidak mendukung kamera.';
          return;
        }
        if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
          statusEl.textContent = 'Pemindaian kamera memerlukan HTTPS.';
          return;
        }

        statusEl.textContent = 'Meminta izin kamera...';
        try {
          stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' },
            audio: false
          });
          video.srcObject = stream;
          await video.play();

          canvas = document.createElement('canvas');
          ctx = canvas.getContext('2d');

          if ('BarcodeDetector' in window) {
            const formats = ['ean_13', 'ean_8', 'code_128', 'upc_a', 'upc_e'];
            detector = new window.BarcodeDetector({ formats });
            statusEl.textContent = 'Memindai...';
            scanFrame();
          } else {
            statusEl.textContent = 'Browser tidak mendukung pemindaian barcode. Silakan ketik manual.';
          }
        } catch (err) {
          statusEl.textContent = 'Gagal mengakses kamera: ' + (err && err.message ? err.message : err);
        }
      }

      function stopScanner() {
        if (rafId) cancelAnimationFrame(rafId);
        rafId = null;
        if (video) video.pause();
        if (stream) {
          stream.getTracks().forEach(t => t.stop());
          stream = null;
        }
      }

      async function scanFrame() {
        if (!detector || video.readyState < 2) {
          rafId = requestAnimationFrame(scanFrame);
          return;
        }
        const w = video.videoWidth;
        const h = video.videoHeight;
        if (!w || !h) {
          rafId = requestAnimationFrame(scanFrame);
          return;
        }

        canvas.width = w;
        canvas.height = h;
        ctx.drawImage(video, 0, 0, w, h);

        try {
          const bitmap = await createImageBitmap(canvas);
          const codes = await detector.detect(bitmap);
          if (codes && codes.length) {
            const code = codes[0].rawValue || codes[0].raw || '';
            if (code) {
              statusEl.textContent = 'Terdeteksi: ' + code;
              if (searchInput) {
                searchInput.value = code;
                // memicu event input agar listener lain bereaksi
                searchInput.dispatchEvent(new Event('input', { bubbles: true }));
              }
              // pancarkan event global agar logic POS dapat merespons
              window.dispatchEvent(new CustomEvent('barcode:scanned', { detail: { code } }));
              hideModal();
              return;
            }
          }
        } catch (e) {
          // abaikan kesalahan frame tunggal
        }
        rafId = requestAnimationFrame(scanFrame);
      }

      openBtn?.addEventListener('click', showModal);
      closeBtn?.addEventListener('click', hideModal);
      window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') hideModal();
      });
    })();
  </script>
@endsection

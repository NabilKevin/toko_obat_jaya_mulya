document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('scannerModal');
    const openBtn = document.getElementById('openScannerBtn');
    const closeBtn = document.getElementById('closeScannerBtn');
    const video = document.getElementById('scannerVideo');
    const barcodeInput = document.getElementById('barcode');
    const scanResult = document.getElementById('scanResult');
    const scanResultText = document.getElementById('scanResultText');
    const scanError = document.getElementById('scanError');
    const scanErrorText = document.getElementById('scanErrorText');
    const scannerStatus = document.getElementById('scannerStatus');
    
    let stream = null;
    let barcodeDetector = null;
    let scanning = false;
    
    // Check BarcodeDetector support
    const barcodeDetectorSupported = 'BarcodeDetector' in window;
    
    openBtn.addEventListener('click', async () => {
        console.log('akjkdajs')
        if (!barcodeDetectorSupported) {
            showError('Browser tidak mendukung pemindai barcode. Silakan gunakan Chrome atau Edge.');
            return;
        }
        
        modal.classList.remove('hidden');
        scanResult.classList.add('hidden');
        scanError.classList.add('hidden');
        
        try {
            // Request camera permission
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'environment' } 
            });
            video.srcObject = stream;
            
            // Initialize BarcodeDetector
            barcodeDetector = new BarcodeDetector({
                formats: ['ean_13', 'ean_8', 'code_128', 'code_39', 'upc_a', 'upc_e']
            });
            
            scannerStatus.classList.remove('hidden');
            scanning = true;
            scanBarcodes();
            
        } catch (error) {
            console.error('[v0] Camera error:', error);
            showError('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.');
        }
    });
    
    async function scanBarcodes() {
        if (!scanning || !barcodeDetector) return;
        
        try {
            const barcodes = await barcodeDetector.detect(video);
            
            if (barcodes.length > 0) {
                const barcode = barcodes[0];
                console.log('[v0] Barcode detected:', barcode.rawValue);
                
                // Fill input
                barcodeInput.value = barcode.rawValue;
                
                // Show result
                scanResultText.textContent = barcode.rawValue;
                scanResult.classList.remove('hidden');
                scannerStatus.classList.add('hidden');
                
                // Dispatch custom event
                barcodeInput.dispatchEvent(new CustomEvent('barcode:scanned', {
                    detail: { barcode: barcode.rawValue }
                }));
                
                // Close after 1.5 seconds
                setTimeout(() => {
                    closeScanner();
                }, 1500);
                
                return;
            }
            
            // Continue scanning
            requestAnimationFrame(scanBarcodes);
            
        } catch (error) {
            console.error('[v0] Scan error:', error);
            requestAnimationFrame(scanBarcodes);
        }
    }
    
    function showError(message) {
        scanErrorText.textContent = message;
        scanError.classList.remove('hidden');
        scanResult.classList.add('hidden');
        scannerStatus.classList.add('hidden');
    }
    
    function closeScanner() {
        scanning = false;
        
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        
        video.srcObject = null;
        modal.classList.add('hidden');
        scanResult.classList.add('hidden');
        scanError.classList.add('hidden');
        scannerStatus.classList.add('hidden');
    }
    
    closeBtn.addEventListener('click', closeScanner);
    
    // Close on Esc key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeScanner();
        }
    });
    
    // Close on backdrop click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeScanner();
        }
    });
});
const afterScan = (decodedText) => {
  document.querySelector('input#kode_barcode, input.kode_barcode').value = decodedText
}
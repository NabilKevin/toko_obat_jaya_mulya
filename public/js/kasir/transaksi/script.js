const modal = document.getElementById('trx-modal');
const tableTransaksiModal = document.getElementById('transaksiTableModal');
const trxTotal = document.getElementById('trxTotal');
const trxTotalBayar = document.getElementById('trxTotalBayar');
const trxTotalKembalian = document.getElementById('trxTotalKembalian');
const trxKode = document.getElementById('trxKode');
const trxWaktu = document.getElementById('trxWaktu');
const buttons = document.querySelectorAll('.btn-detail');

const openModalTransaksi = e => {
  modal.classList.toggle('hidden')
  
  let content = ''
  const id = e.target.dataset.id
  const transaksi = transaksis.find(a => a.id == id)

  transaksi?.items?.forEach(item => {
    content += `
    <tr>
      <td class="px-3 py-2">${item.obat.nama}</td>
      <td class="px-3 py-2 text-center">${item.qty}</td>
      <td class="px-3 py-2 text-right">Rp ${formatNumber(item.harga_jual)}</td>
      <td class="px-3 py-2 text-right">Rp ${formatNumber(item.harga_jual * item.qty)}</td>
    </tr>
    `
  })
  
  tableTransaksiModal.querySelector('tbody').innerHTML = content

  trxTotal.textContent = `Rp ${formatNumber(transaksi.total_transaksi)}`
  trxTotalBayar.textContent = `Rp ${formatNumber(transaksi.total_dibayar)}`
  trxTotalKembalian.textContent = `Rp ${formatNumber(transaksi.total_kembalian)}`
  trxKode.textContent = transaksi.kode
  trxWaktu.textContent = transaksi.created_at

}

const closeModalTransaksi = () => {
  modal.classList.toggle('hidden')
}

modal.addEventListener('click', e => {
  if(e.target.tagName.toLowerCase() === 'button' || e.target.classList.contains('absolute')) {
    closeModalTransaksi()
  }
})

buttons.forEach(button => {
  button.addEventListener('click', openModalTransaksi)
})
const btnPrint = document.getElementById('trx-print');
btnPrint.addEventListener('click', () => {
  const id = document.getElementById('trxKode').textContent;
  window.open(`${BASE_URL}kasir/struk/${id}`, '_blank');
});
const carts = document.querySelector('#carts tbody')
const textAlert = document.querySelector('.alert-text-table')

const textTotal = document.querySelector('#textTotal')
const textTotalBayar = document.querySelector('#textTotalBayar')
const textTotalKembalian = document.querySelector('#textTotalKembalian')

const inputTotalBayar = document.querySelector('#inputTotalBayar')

const tableObats = document.getElementById('tableObats')
const data = []

const updateTextHarga = () => {
  let total = 0
  data.forEach(d => {
    total += d.harga * d.qty
  })

  textTotal.textContent = formatNumber(total)

  const valueTotalBayar = parseNumber(inputTotalBayar.value)

  textTotalBayar.textContent = inputTotalBayar.value !== '' ? inputTotalBayar.value : 0 
  textTotalKembalian.textContent = formatNumber(parseInt(valueTotalBayar === '' ? 0 : valueTotalBayar) - parseInt(total))
}

function updateTable() {
  carts.innerHTML = data.map(a => `
    <tr>
      <td class="py-2 px-2">${a.nama}</td>
      <td class="py-2 px-2 text-center">
        <div class="flex items-center justify-center gap-2">
          <button class="px-2 py-1 border rounded btn-minus" data-id="${a.id}">-</button>
          <input 
            type="number" 
            value="${a.qty}" 
            min="1" 
            class="w-12 text-center border rounded qty-input border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-sm focus:ring-2 focus:ring-primary py-1.5" 
            data-id="${a.id}">
          <button class="px-2 py-1 border rounded btn-plus" data-id="${a.id}">+</button>
        </div>
      </td>
      <td class="py-2 px-2 text-center">Rp ${formatNumber(a.harga)}</td>
      <td class="py-2 px-2 text-center font-medium">Rp ${formatNumber(a.harga * a.qty)}</td>
      <td class="py-2 px-2 text-center">
        <button class="text-xs px-2 py-1 rounded-md border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800 btn-remove" data-id="${a.id}">Hapus</button>
      </td>
    </tr>
  `).join('')

  bindEvents()
}

function bindEvents() {
  document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id
      const item = data.find(a => a.id == id)
      if (item) { item.qty++; updateTable(); updateTextHarga() }
    })
  })

  document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id
      const item = data.find(a => a.id == id)
      if (item && item.qty > 1) { item.qty--; updateTable(); updateTextHarga() }
    })
  })

  document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', () => {
      const id = input.dataset.id
      const item = data.find(a => a.id == id)
      if (item) {
        item.qty = Math.max(1, parseInt(input.value) || 1)
        updateTable()
        updateTextHarga()
      }
    })
  })

  document.querySelectorAll('.btn-remove').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id
      const idx = data.findIndex(a => a.id == id)
      if (idx > -1) { data.splice(idx, 1); updateTable(); updateTextHarga() }
      if(data.length === 0) {
        textAlert.classList.remove('hidden')
      }
    })
  })
}

const addToCart = (obat) => {
  if(data.length === 0) {
    textAlert.classList.add('hidden')
  }
  const existing = data.find(a => a.id == obat.id)
  if (existing) {
    existing.qty++
  } else {
    data.push({ ...obat, qty: 1 })
  }
  updateTable()
  updateTextHarga()
}

// contoh tambah item
function tambahData(id) {
  const obat = obats.find(a => a.id == id)
  if(obat) {
    addToCart(obat)
  } else {
    alert('Obat tidak ditemukan!')
  }
}

tableObats.addEventListener('click', e => {
  if(e.target.classList.contains('btn-tambah')) {
    const id = e.target.dataset.id
    tambahData(id)
  }
})

inputTotalBayar.addEventListener('input', function() {
  let raw = this.value.replace(/\D/g, "");
  if(raw === "") {
    this.value = 0;
    textTotalBayar.textContent = 0
    updateTextHarga()
    return;
  }
  const value = formatNumber(parseInt(parseNumber(this.value)))
  
  this.value = value
  textTotalBayar.textContent = value
  updateTextHarga()
})
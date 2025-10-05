const btnBayar = document.getElementById('btnBayar')
let isBayar = false

const disableButton = e => {
  e.target.disabled = true
  e.target.style.cursor = 'not-allowed'
  e.target.style.opacity = '0.75'
  e.target.classList.remove('active:scale-95')
}
const resetButton = e => {
  e.target.disabled = false
  e.target.style.cursor = 'pointer'
  e.target.style.opacity = '1'
  e.target.classList.add('active:scale-95')
}

const toggleAlert = (alert) => {
  alert.classList.toggle('hidden')
  alert.classList.toggle('alertAnimate')
}

const bayar = async e => {
  e.preventDefault()
  if(data.length === 0) {
    alert('Keranjang kosong!')
  } else if (parseNumber(textTotalKembalian.textContent) < 0) {
    alert('Uang kurang!')
  } else {
  if(!isBayar) {
    isBayar = true;
    disableButton(e)
    try {
      fetch(`${BASE_URL}pos`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          cart: [...data],
          totalTransaction: parseNumber(textTotal.textContent),
          totalPaid: parseNumber(textTotalBayar.textContent),
          totalChange: parseNumber(textTotalKembalian.textContent)
        })
      })
      .then(res => res.json())
      .then(d => {
        const alert = document.getElementById('alert')
        alert.textContent = d?.message
        toggleAlert(alert)
        setTimeout(() => {
          toggleAlert(alert)
        }, 3100)

        inputTotalBayar.value = ''

        resetButton(e)
        data.length = 0

        updateTable()
        updateTextHarga()
        getDataObat()

        isBayar = false;
      })
    } catch(err) {
      console.error(err); 
    }
  }
  }
}

btnBayar.addEventListener('click', bayar)


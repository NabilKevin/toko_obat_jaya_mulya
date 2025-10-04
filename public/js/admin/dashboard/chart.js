const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line', // bisa 'bar', 'line', 'pie', dll.
    data: {
        labels: chartLabels, // tanggal
        datasets: [{
            label: 'Total Penjualan',
            data: chartTotals, // total penjualan per tanggal
            borderColor: '#FACC15',   // kuning keemasan
            backgroundColor: 'rgba(250, 204, 21, 0.3)', // transparan
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let value = context.raw;
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
const paymentChartCanvas = document.getElementById('paymentChart');
const invoicePieChartCanvas = document.getElementById('invoicePieChart');

const paymentData = <?= $paymentChartData ?>;
const invoiceData = {
    labels: ['Paid', 'Pending'],
    datasets: [{
        data: [<?= $totalPaidAmount ?>, <?= $totalPendingAmount ?>],
        backgroundColor: ['#68D391', '#FC8181'],
        hoverBackgroundColor: ['#4CAF50', '#FF6384'],
    }]
};

const paymentChart = new Chart(paymentChartCanvas, {
    type: 'line',
    data: {
        labels: paymentData.labels,
        datasets: [{
            label: 'Payments',
            data: paymentData.data,
            borderColor: '#63B3ED',
            fill: false,
        }]
    },
    options: {
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                },
            },
            y: {
                beginAtZero: true,
            },
        },
    },
});

const invoicePieChart = new Chart(invoicePieChartCanvas, {
    type: 'doughnut',
    data: invoiceData,
});

(function() {
    createUsersChart();
    createConfirmedChart();

    const messages = document.querySelectorAll('.admin-messages__item');

    if (messages) {
        messages.forEach(message => {
            message.addEventListener('click', () => {
                const id = message.getAttribute('data-id');
                window.open(`/admin/message/view?id=${id}`, '_blank');
            });
        });
    }
})();

function createUsersChart() {
    const ctx = document.getElementById('users-registered').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height); // Usa la altura real del canvas
    gradient.addColorStop(0, 'rgba(255, 81, 0, 0.4)');  // 40% opacidad arriba
    gradient.addColorStop(0.5, 'rgba(255, 81, 0, 0.15)'); // Transición media
    //gradient.addColorStop(0.75, 'rgba(255, 81, 0, 0.1)'); // Transición media
    gradient.addColorStop(1, 'rgba(255, 81, 0, 0)');    // Totalmente transparente abajo

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jul', 'Jun', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May'],
        datasets: [{
            label: 'Usuarios registrados',
            data: [1200, 1900, 1500, 1900, 1800, 1200, 1900, 1500, 1900, 1800, 1200, 1900],
            borderColor: '#FF5100', // Color de la línea
            tension: 0.4, // Suaviza la curva
            borderWidth: 3, // Grosor de la línea
            pointBackgroundColor: '#FF5100', // Color de los puntos
            pointRadius: 3, // Tamaño de los puntos
            pointHoverRadius: 5, // Tamaño al pasar el mouse
            fill: true,
            backgroundColor: gradient // Área semi-transparente
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false // Oculta la leyenda si no es necesaria
            }
        },
        scales: {
            x: {
                grid: {
                    display: false // Elimina la cuadrícula vertical
                },
                ticks: {
                    color: '#666' // Color de las etiquetas del eje X
                }
            },
            y: {
                display: false,
                beginAtZero: true,
                grace: '0%',
            }
        }
    }
});
}

function createConfirmedChart() {
    const porcentaje = document.getElementById('users-confirmed').getAttribute('data-percentage');
    const users = document.getElementById('users-confirmed').getAttribute('data-users');
    const confirmed = document.getElementById('users-confirmed').getAttribute('data-confirmed');

    const ctx = document.getElementById('users-confirmed').getContext('2d');

    const centerTextPlugin = {
        id: 'centerText',
        beforeDraw(chart) {
            const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;
            ctx.restore();
            
            const fontSize = 18;
            ctx.font = `bold ${fontSize}px 'Poppins', sans-serif`;
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'center';

            const text = porcentaje + '%';
            const textX = left + width / 2;
            const textY = top + height / 2;

            ctx.fillStyle = '#333333';
            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    };

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Usuarios Confirmados', 'Usuarios no Confirmados'],
            datasets: [{
                data: [confirmed, users - confirmed], 
                backgroundColor: ['#FF5100', 'transparent'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '85%', // Más grueso
            circumference: 270, // Medio círculo (270 grados)
            rotation: -135, // Rotación para empezar desde la izquierda
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        },
        plugins: [centerTextPlugin]
    });
}
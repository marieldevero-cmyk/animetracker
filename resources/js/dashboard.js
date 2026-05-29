import { Chart, ArcElement, Tooltip, Legend, PieController } from 'chart.js';

Chart.register(PieController, ArcElement, Tooltip, Legend);

export function initCharts() {
    const statusCanvas = document.getElementById('animeStatusChart');
    const usersCanvas = document.getElementById('usersChart');

    if (statusCanvas) {
        const labels = JSON.parse(statusCanvas.dataset.labels);
        const counts = JSON.parse(statusCanvas.dataset.counts);

        if (counts.some(v => v > 0)) {
            new Chart(statusCanvas, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: ['#e8a87c', '#f3c26b', '#2ec4b6'],
                        borderWidth: 0,
                        hoverOffset: 10,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 16,
                                usePointStyle: true,
                                font: { family: 'Instrument Sans', size: 12 },
                                color: 'rgba(255,255,255,0.5)',
                            },
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15,14,23,0.95)',
                            titleFont: { family: 'Fredoka', size: 13 },
                            bodyFont: { family: 'Instrument Sans', size: 12 },
                            padding: 10,
                            cornerRadius: 10,
                        },
                    },
                },
            });
        }
    }

    if (usersCanvas) {
        const withAnime = parseInt(usersCanvas.dataset.withAnime, 10);
        const withoutAnime = parseInt(usersCanvas.dataset.withoutAnime, 10);

        new Chart(usersCanvas, {
            type: 'pie',
            data: {
                labels: ['With Anime', 'Without Anime'],
                datasets: [{
                    data: [withAnime, withoutAnime],
                    backgroundColor: ['#f3c26b', '#6c6a7a'],
                    borderWidth: 0,
                    hoverOffset: 10,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            font: { family: 'Instrument Sans', size: 12 },
                            color: 'rgba(255,255,255,0.5)',
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = withAnime + withoutAnime;
                                const pct = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + context.raw + ' (' + pct + '%)';
                            },
                        },
                        backgroundColor: 'rgba(15,14,23,0.95)',
                        titleFont: { family: 'Fredoka', size: 13 },
                        bodyFont: { family: 'Instrument Sans', size: 12 },
                        padding: 10,
                        cornerRadius: 10,
                    },
                },
            },
        });
    }
}

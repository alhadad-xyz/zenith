<x-layout title="Zenith - Analytics Dashboard">
    <x-slot name="styles">
        <style>
            /* Analytics specific styles */
            .header {
                margin-bottom: 3rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: rgba(255, 255, 255, 0.4);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 24px;
                padding: 2rem 3rem;
            }

            .header-content {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .header-title {
                font-size: 2.5rem;
                font-weight: 800;
                color: #2d3e2e;
                letter-spacing: -0.03em;
            }

            .header-subtitle {
                font-size: 1.1rem;
                color: #6b7c6d;
                font-weight: 500;
            }

            .header-controls {
                display: flex;
                gap: 1rem;
                align-items: center;
            }

            .time-selector {
                background: rgba(255, 255, 255, 0.6);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 50px;
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
                font-weight: 600;
                color: #2d3e2e;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
                backdrop-filter: blur(10px);
            }

            .time-selector:hover,
            .time-selector.active {
                background: rgba(255, 107, 107, 0.9);
                color: white;
                transform: translateY(-2px);
            }

            /* Analytics Grid */
            .analytics-grid {
                display: grid;
                grid-template-columns: repeat(12, 1fr);
                grid-template-rows: repeat(8, 120px);
                gap: 1.5rem;
            }

            .analytics-card {
                backdrop-filter: blur(20px);
                background: rgba(255, 255, 255, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.4);
                border-radius: 24px;
                padding: 2rem;
                position: relative;
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
                display: flex;
                flex-direction: column;
            }

            .analytics-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .analytics-card:hover::before {
                opacity: 1;
            }

            .analytics-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 32px 64px rgba(45, 62, 46, 0.15);
                border-color: rgba(255, 255, 255, 0.6);
            }

            .card-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 2;
            }

            .card-title {
                font-size: 1.4rem;
                font-weight: 700;
                color: #2d3e2e;
                letter-spacing: -0.02em;
            }

            .card-value {
                font-size: 2.5rem;
                font-weight: 800;
                color: #2d3e2e;
                line-height: 1;
            }

            .card-change {
                font-size: 0.85rem;
                font-weight: 600;
                padding: 0.25rem 0.75rem;
                border-radius: 50px;
                margin-top: 0.5rem;
            }

            .card-change.positive {
                background: rgba(46, 125, 50, 0.1);
                color: #2e7d32;
            }

            .card-change.negative {
                background: rgba(255, 107, 107, 0.1);
                color: #ff6b6b;
            }

            .chart-container {
                flex: 1;
                position: relative;
                min-height: 0;
            }

            /* Individual Card Layouts */
            .total-applications {
                grid-column: 1 / 4;
                grid-row: 1 / 3;
                background: linear-gradient(135deg, rgba(240, 229, 224, 0.4) 0%, rgba(240, 229, 224, 0.6) 100%);
            }

            .response-rate {
                grid-column: 4 / 7;
                grid-row: 1 / 3;
                background: linear-gradient(135deg, rgba(232, 242, 232, 0.4) 0%, rgba(232, 242, 232, 0.6) 100%);
            }

            .interview-rate {
                grid-column: 7 / 10;
                grid-row: 1 / 3;
                background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(255, 107, 107, 0.2) 100%);
            }

            .avg-time {
                grid-column: 10 / 13;
                grid-row: 1 / 3;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.6) 100%);
            }

            .applications-chart {
                grid-column: 1 / 8;
                grid-row: 3 / 6;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.5) 100%);
            }

            .funnel-chart {
                grid-column: 8 / 13;
                grid-row: 3 / 6;
                background: linear-gradient(135deg, rgba(240, 229, 224, 0.3) 0%, rgba(240, 229, 224, 0.5) 100%);
            }

            /* Chart Specific Styles */
            .funnel-stage {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;
                padding: 0.75rem;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 12px;
                transition: all 0.2s ease;
            }

            .funnel-stage:hover {
                background: rgba(255, 255, 255, 0.6);
                transform: translateX(4px);
            }

            .funnel-bar {
                height: 8px;
                background: linear-gradient(90deg, #ff6b6b 0%, #ff5252 100%);
                border-radius: 4px;
                margin: 0 1rem;
                flex: 1;
                position: relative;
            }

            .funnel-label {
                font-size: 0.9rem;
                font-weight: 600;
                color: #2d3e2e;
                min-width: 100px;
            }

            .funnel-value {
                font-size: 0.9rem;
                font-weight: 700;
                color: #6b7c6d;
                min-width: 60px;
                text-align: right;
            }

            /* Responsive Design */
            @media (max-width: 1400px) {
                .analytics-grid {
                    grid-template-columns: repeat(8, 1fr);
                }
                
                .total-applications { grid-column: 1 / 3; grid-row: 1 / 3; }
                .response-rate { grid-column: 3 / 5; grid-row: 1 / 3; }
                .interview-rate { grid-column: 5 / 7; grid-row: 1 / 3; }
                .avg-time { grid-column: 7 / 9; grid-row: 1 / 3; }
                .applications-chart { grid-column: 1 / 5; grid-row: 3 / 6; }
                .funnel-chart { grid-column: 5 / 9; grid-row: 3 / 6; }
            }

            @media (max-width: 768px) {
                .header {
                    flex-direction: column;
                    gap: 1.5rem;
                    text-align: center;
                }
                
                .analytics-grid {
                    grid-template-columns: 1fr;
                    grid-template-rows: repeat(12, 80px);
                }
                
                .total-applications, .response-rate, .interview-rate, .avg-time {
                    grid-column: 1;
                    grid-row: span 2;
                }
                
                .applications-chart, .funnel-chart {
                    grid-column: 1;
                    grid-row: span 4;
                }
            }
        </style>
    </x-slot>

    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1 class="header-title">Analytics Dashboard</h1>
                <p class="header-subtitle">Insights into your job search performance and trends</p>
            </div>
            <div class="header-controls">
                <button class="time-selector active" onclick="setTimeRange('7d')">7 Days</button>
                <button class="time-selector" onclick="setTimeRange('30d')">30 Days</button>
                <button class="time-selector" onclick="setTimeRange('90d')">90 Days</button>
                <button class="time-selector" onclick="setTimeRange('1y')">1 Year</button>
            </div>
        </header>

        <!-- Analytics Grid -->
        <div class="analytics-grid">
            <!-- Key Metrics -->
            <div class="analytics-card total-applications">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Total Applications</h3>
                        <div class="card-value">{{ $analytics['total_applications'] ?? 1 }}</div>
                        <div class="card-change positive">
                            +33% this month
                        </div>
                    </div>
                </div>
            </div>

            <div class="analytics-card response-rate">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Response Rate</h3>
                        <div class="card-value">0%</div>
                        <div class="card-change positive">
                            +5% this month
                        </div>
                    </div>
                </div>
            </div>

            <div class="analytics-card interview-rate">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Interview Rate</h3>
                        <div class="card-value">0%</div>
                        <div class="card-change positive">
                            +8% this month
                        </div>
                    </div>
                </div>
            </div>

            <div class="analytics-card avg-time">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Avg Response Time</h3>
                        <div class="card-value">5.2d</div>
                        <div class="card-change negative">
                            -0.8d this month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Over Time Chart -->
            <div class="analytics-card applications-chart">
                <div class="card-header">
                    <h3 class="card-title">Applications Per Week</h3>
                </div>
                <div class="chart-container">
                    <canvas id="applicationsChart"></canvas>
                </div>
            </div>

            <!-- Conversion Funnel -->
            <div class="analytics-card funnel-chart">
                <div class="card-header">
                    <h3 class="card-title">Conversion Funnel</h3>
                </div>
                <div class="chart-container">
                    <div class="funnel-stage">
                        <span class="funnel-label">Applied</span>
                        <div class="funnel-bar" style="width: 100%;"></div>
                        <span class="funnel-value">1</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Response</span>
                        <div class="funnel-bar" style="width: 0%;"></div>
                        <span class="funnel-value">0</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Phone Screen</span>
                        <div class="funnel-bar" style="width: 0%;"></div>
                        <span class="funnel-value">0</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Interview</span>
                        <div class="funnel-bar" style="width: 0%;"></div>
                        <span class="funnel-value">0</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Final Round</span>
                        <div class="funnel-bar" style="width: 0%;"></div>
                        <span class="funnel-value">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
            // Chart.js default configuration
            Chart.defaults.font.family = 'Inter';
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#6b7c6d';

            // Applications Per Week Line Chart
            const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
            const applicationsChart = new Chart(applicationsCtx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
                    datasets: [{
                        label: 'Applications',
                        data: [3, 7, 5, 8, 6, 9, 4, 5],
                        borderColor: '#ff6b6b',
                        backgroundColor: 'rgba(255, 107, 107, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ff6b6b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: 600
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(107, 124, 109, 0.1)',
                                borderDash: [5, 5]
                            },
                            border: {
                                display: false
                            },
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    weight: 600
                                }
                            }
                        }
                    }
                }
            });

            // Time range selector
            function setTimeRange(range) {
                // Remove active class from all buttons
                document.querySelectorAll('.time-selector').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                event.target.classList.add('active');
            }

            // Initialize animations on load
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.analytics-card');
                
                cards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    
                    setTimeout(() => {
                        card.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            });
        </script>
    </x-slot>
</x-layout>
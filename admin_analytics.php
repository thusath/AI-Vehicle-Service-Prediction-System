<?php
require_once 'db.php';
require_admin();

/**
 * Convert a MySQL result into separate label and value arrays
 * for use with Chart.js.
 */
function fetch_chart_pairs(
    mysqli_result $result,
    string $labelKey,
    string $valueKey
): array {
    $labels = [];
    $values = [];

    while ($row = $result->fetch_assoc()) {
        $labels[] = $row[$labelKey];
        $values[] = (float) $row[$valueKey];
    }

    return [$labels, $values];
}


/*
|--------------------------------------------------------------------------
| Vehicle Brand Statistics
|--------------------------------------------------------------------------
*/

$brandResult = $conn->query(
    "
        SELECT
            vehicle_brand AS label,
            COUNT(*) AS value
        FROM predictions
        WHERE is_deleted_by_admin = 0
        GROUP BY vehicle_brand
        ORDER BY value DESC
    "
);

[$brandLabels, $brandValues] = fetch_chart_pairs(
    $brandResult,
    'label',
    'value'
);


/*
|--------------------------------------------------------------------------
| Service Type Statistics
|--------------------------------------------------------------------------
*/

$serviceResult = $conn->query(
    "
        SELECT
            service_type AS label,
            COUNT(*) AS value
        FROM predictions
        WHERE is_deleted_by_admin = 0
        GROUP BY service_type
        ORDER BY value DESC
    "
);

[$serviceLabels, $serviceValues] = fetch_chart_pairs(
    $serviceResult,
    'label',
    'value'
);


/*
|--------------------------------------------------------------------------
| Monthly Prediction Statistics
|--------------------------------------------------------------------------
*/

$monthResult = $conn->query(
    "
        SELECT
            DATE_FORMAT(prediction_date, '%Y-%m') AS label,
            COUNT(*) AS value
        FROM predictions
        WHERE is_deleted_by_admin = 0
        GROUP BY DATE_FORMAT(prediction_date, '%Y-%m')
        ORDER BY label ASC
    "
);

[$monthLabels, $monthValues] = fetch_chart_pairs(
    $monthResult,
    'label',
    'value'
);


/*
|--------------------------------------------------------------------------
| KPI Summary
|--------------------------------------------------------------------------
*/

$summaryResult = $conn->query(
    "
        SELECT
            COUNT(*) AS total,
            AVG(predicted_cost) AS cost,
            AVG(predicted_duration_hours) AS duration,
            AVG(predicted_delay_probability) AS delay
        FROM predictions
        WHERE is_deleted_by_admin = 0
    "
);

$summary = $summaryResult->fetch_assoc();


include 'header.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /*
    |--------------------------------------------------------------------------
    | Analytics Page
    |--------------------------------------------------------------------------
    */

    .analytics-page {
        overflow-x: hidden;
    }

    .analytics-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .analytics-stat-card {
        min-width: 0;
        padding: 24px 20px;
        text-align: center;
    }

    .analytics-stat-card .count {
        font-size: clamp(1.65rem, 2.4vw, 2.35rem);
        font-weight: 800;
        line-height: 1.15;
        color: #e6c878;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .analytics-stat-card .stat-money {
        font-size: clamp(1.35rem, 2vw, 2rem);
    }

    .analytics-stat-card .label {
        margin-top: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #9aa7b8;
    }


    /*
    |--------------------------------------------------------------------------
    | Chart Cards
    |--------------------------------------------------------------------------
    */

    .analytics-chart-card {
        width: 100%;
        min-width: 0;
        height: 100%;
        padding: 24px;
        overflow: hidden;
    }

    .analytics-chart-card .section-title {
        margin: 0 0 22px;
        font-size: clamp(1.05rem, 1.6vw, 1.35rem);
        line-height: 1.3;
    }

    /*
     * IMPORTANT:
     * Chart.js uses the dimensions of the parent container when
     * maintainAspectRatio is false.
     *
     * Giving the canvas a dedicated fixed-height wrapper prevents
     * the chart from continuously increasing its height.
     */

    .chart-canvas-wrap {
        position: relative;
        width: 100%;
        height: 330px;
        min-height: 330px;
        max-height: 330px;
        overflow: hidden;
    }

    .chart-canvas-wrap.chart-wide {
        height: 360px;
        min-height: 360px;
        max-height: 360px;
    }

    .chart-canvas-wrap canvas {
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1199.98px) {
        .analytics-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .chart-canvas-wrap {
            height: 310px;
            min-height: 310px;
            max-height: 310px;
        }

        .chart-canvas-wrap.chart-wide {
            height: 330px;
            min-height: 330px;
            max-height: 330px;
        }
    }

    @media (max-width: 767.98px) {
        .analytics-stats {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .analytics-stat-card {
            padding: 20px 16px;
        }

        .analytics-chart-card {
            padding: 18px;
        }

        .chart-canvas-wrap {
            height: 280px;
            min-height: 280px;
            max-height: 280px;
        }

        .chart-canvas-wrap.chart-wide {
            height: 300px;
            min-height: 300px;
            max-height: 300px;
        }
    }

    @media (max-width: 430px) {
        .analytics-chart-card {
            padding: 16px 12px;
        }

        .analytics-chart-card .section-title {
            margin-bottom: 16px;
            font-size: 1rem;
        }

        .chart-canvas-wrap {
            height: 250px;
            min-height: 250px;
            max-height: 250px;
        }

        .chart-canvas-wrap.chart-wide {
            height: 270px;
            min-height: 270px;
            max-height: 270px;
        }
    }
</style>


<main class="analytics-page">

    <!-- ================================================================
         PAGE INTRODUCTION
         ================================================================ -->

    <section class="hero-strip">
        <div class="container">

            <div class="kicker">
                System Intelligence
            </div>

            <h1>
                Analytics
                <span class="gold">
                    Dashboard
                </span>
            </h1>

            <p>
                Interactive prediction analytics for vehicle brands,
                service demand, cost, duration and monthly system usage.
            </p>

        </div>
    </section>


    <!-- ================================================================
         ANALYTICS CONTENT
         ================================================================ -->

    <section class="section">
        <div class="container">


            <!-- ========================================================
                 KPI CARDS
                 ======================================================== -->

            <div class="analytics-stats">

                <div class="stat-card analytics-stat-card reveal">

                    <div class="count stat-money">
                        Rs.
                        <?= number_format(
                            (float) ($summary['cost'] ?? 0),
                            0
                        ) ?>
                    </div>

                    <div class="label">
                        Average Cost
                    </div>

                </div>


                <div class="stat-card analytics-stat-card reveal">

                    <div class="count">
                        <?= number_format(
                            (float) ($summary['duration'] ?? 0),
                            1
                        ) ?>h
                    </div>

                    <div class="label">
                        Average Duration
                    </div>

                </div>


                <div class="stat-card analytics-stat-card reveal">

                    <div class="count">
                        <?= number_format(
                            (float) ($summary['delay'] ?? 0),
                            1
                        ) ?>%
                    </div>

                    <div class="label">
                        Average Delay
                    </div>

                </div>


                <div class="stat-card analytics-stat-card reveal">

                    <div
                        class="count"
                        data-count="<?= (int) ($summary['total'] ?? 0) ?>"
                    >
                        0
                    </div>

                    <div class="label">
                        Total Predictions
                    </div>

                </div>

            </div>


            <!-- ========================================================
                 CHARTS
                 ======================================================== -->

            <div class="row g-4">


                <!-- Vehicle Brand Chart -->

                <div class="col-lg-6">

                    <div class="chart-card analytics-chart-card reveal">

                        <h2 class="section-title">
                            Most Predicted Vehicle Brand
                        </h2>

                        <div class="chart-canvas-wrap">
                            <canvas
                                id="brandChart"
                                aria-label="Vehicle brand prediction chart"
                                role="img"
                            ></canvas>
                        </div>

                    </div>

                </div>


                <!-- Service Type Chart -->

                <div class="col-lg-6">

                    <div class="chart-card analytics-chart-card reveal">

                        <h2 class="section-title">
                            Most Common Service Type
                        </h2>

                        <div class="chart-canvas-wrap">
                            <canvas
                                id="serviceChart"
                                aria-label="Service type prediction chart"
                                role="img"
                            ></canvas>
                        </div>

                    </div>

                </div>


                <!-- Monthly Trend Chart -->

                <div class="col-12">

                    <div class="chart-card analytics-chart-card reveal">

                        <h2 class="section-title">
                            Monthly Prediction Statistics &amp; Trends
                        </h2>

                        <div class="chart-canvas-wrap chart-wide">
                            <canvas
                                id="monthChart"
                                aria-label="Monthly prediction trend chart"
                                role="img"
                            ></canvas>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

</main>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Check Chart.js
        |--------------------------------------------------------------------------
        */

        if (typeof Chart === 'undefined') {
            console.error('Chart.js failed to load.');
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Global Chart Settings
        |--------------------------------------------------------------------------
        */

        Chart.defaults.color = '#d8dee9';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.08)';
        Chart.defaults.font.family = 'inherit';


        /*
        |--------------------------------------------------------------------------
        | Data from PHP
        |--------------------------------------------------------------------------
        */

        const brandLabels =
            <?= json_encode(
                $brandLabels,
                JSON_HEX_TAG |
                JSON_HEX_AMP |
                JSON_HEX_APOS |
                JSON_HEX_QUOT
            ) ?>;

        const brandValues =
            <?= json_encode($brandValues) ?>;

        const serviceLabels =
            <?= json_encode(
                $serviceLabels,
                JSON_HEX_TAG |
                JSON_HEX_AMP |
                JSON_HEX_APOS |
                JSON_HEX_QUOT
            ) ?>;

        const serviceValues =
            <?= json_encode($serviceValues) ?>;

        const monthLabels =
            <?= json_encode(
                $monthLabels,
                JSON_HEX_TAG |
                JSON_HEX_AMP |
                JSON_HEX_APOS |
                JSON_HEX_QUOT
            ) ?>;

        const monthValues =
            <?= json_encode($monthValues) ?>;


        /*
        |--------------------------------------------------------------------------
        | Common Chart Options
        |--------------------------------------------------------------------------
        */

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            resizeDelay: 150,
            animation: {
                duration: 600
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        };


        /*
        |--------------------------------------------------------------------------
        | Vehicle Brand Chart
        |--------------------------------------------------------------------------
        */

        const brandCanvas = document.getElementById('brandChart');

        if (brandCanvas) {
            new Chart(brandCanvas, {
                type: 'bar',

                data: {
                    labels: brandLabels,

                    datasets: [
                        {
                            label: 'Predictions',
                            data: brandValues,
                            backgroundColor: 'rgba(201, 162, 77, 0.75)',
                            borderColor: '#e6c878',
                            borderWidth: 1,
                            borderRadius: 5,
                            maxBarThickness: 48
                        }
                    ]
                },

                options: {
                    ...commonOptions,

                    plugins: {
                        legend: {
                            display: false
                        },

                        tooltip: {
                            backgroundColor: '#07111f',
                            titleColor: '#e6c878',
                            bodyColor: '#d8dee9',
                            borderColor: 'rgba(201, 162, 77, 0.35)',
                            borderWidth: 1,
                            padding: 12
                        }
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            },

                            ticks: {
                                color: '#d8dee9',
                                maxRotation: 45,
                                minRotation: 0
                            }
                        },

                        y: {
                            beginAtZero: true,

                            grid: {
                                color: 'rgba(255, 255, 255, 0.06)'
                            },

                            ticks: {
                                color: '#9aa7b8',
                                precision: 0
                            }
                        }
                    }
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Service Type Chart
        |--------------------------------------------------------------------------
        */

        const serviceCanvas = document.getElementById('serviceChart');

        if (serviceCanvas) {
            new Chart(serviceCanvas, {
                type: 'doughnut',

                data: {
                    labels: serviceLabels,

                    datasets: [
                        {
                            data: serviceValues,

                            backgroundColor: [
                                '#c9a24d',
                                '#e6c878',
                                '#41698f',
                                '#5d7d9b',
                                '#7894ad',
                                '#8d7650',
                                '#4f7b70',
                                '#7c5f63'
                            ],

                            borderColor: '#0b1f3a',
                            borderWidth: 2,
                            hoverOffset: 5
                        }
                    ]
                },

                options: {
                    ...commonOptions,

                    cutout: '62%',

                    plugins: {
                        legend: {
                            position: 'bottom',

                            labels: {
                                color: '#d8dee9',
                                padding: 14,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 8,
                                boxHeight: 8
                            }
                        },

                        tooltip: {
                            backgroundColor: '#07111f',
                            titleColor: '#e6c878',
                            bodyColor: '#d8dee9',
                            borderColor: 'rgba(201, 162, 77, 0.35)',
                            borderWidth: 1,
                            padding: 12
                        }
                    }
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Monthly Prediction Trend
        |--------------------------------------------------------------------------
        */

        const monthCanvas = document.getElementById('monthChart');

        if (monthCanvas) {
            new Chart(monthCanvas, {
                type: 'line',

                data: {
                    labels: monthLabels,

                    datasets: [
                        {
                            label: 'Predictions',
                            data: monthValues,
                            borderColor: '#e6c878',
                            backgroundColor: 'rgba(201, 162, 77, 0.12)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#c9a24d',
                            pointBorderColor: '#e6c878',
                            pointBorderWidth: 1
                        }
                    ]
                },

                options: {
                    ...commonOptions,

                    plugins: {
                        legend: {
                            display: true,

                            labels: {
                                color: '#d8dee9',
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },

                        tooltip: {
                            backgroundColor: '#07111f',
                            titleColor: '#e6c878',
                            bodyColor: '#d8dee9',
                            borderColor: 'rgba(201, 162, 77, 0.35)',
                            borderWidth: 1,
                            padding: 12
                        }
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            },

                            ticks: {
                                color: '#9aa7b8'
                            }
                        },

                        y: {
                            beginAtZero: true,

                            grid: {
                                color: 'rgba(255, 255, 255, 0.06)'
                            },

                            ticks: {
                                color: '#9aa7b8',
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

    });
</script>

<?php include 'footer.php'; ?>
$(function () {
    'use strict'
    const action = "sales";
    $.ajax({
        url: 'chart.php',
        type: 'POST',
        data: {
            action
        },
        async: true,
        success: function (response) {
            if (response != 0) {
                var data = JSON.parse(response);
                try {
                    var ticksStyle = {
                        fontColor: '#6c757d', // Color más suave para los textos
                        fontStyle: 'bold'
                    }

                    var mode = 'index'
                    var intersect = true

                    var $salesChart = $('#sales-chart')
                    // eslint-disable-next-line no-unused-vars
                    var salesChart = new Chart($salesChart, {
                        type: 'bar',
                        data: {
                            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                            datasets: [
                                {
                                    backgroundColor: 'rgba(64, 158, 255, 0.8)', // Color con opacidad
                                    borderColor: 'rgba(64, 158, 255, 1)', // Color de borde más claro
                                    borderWidth: 2,
                                    data: [data.ene, data.feb, data.mar, data.abr, data.may, data.jun, data.jul, data.ago, data.sep, data.oct, data.nov, data.dic]
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true, // Asegura que el gráfico sea responsive
                            tooltips: {
                                mode: mode,
                                intersect: intersect,
                                backgroundColor: 'rgba(0, 0, 0, 0.7)', // Fondo oscuro para los tooltips
                                titleFontColor: '#fff', // Color blanco para el título del tooltip
                                bodyFontColor: '#fff', // Color blanco para el cuerpo del tooltip
                                footerFontColor: '#fff' // Color blanco para el pie del tooltip
                            },
                            hover: {
                                mode: mode,
                                intersect: intersect
                            },
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [{
                                    gridLines: {
                                        display: true,
                                        lineWidth: '2px',
                                        color: 'rgba(0, 0, 0, .1)', // Líneas más suaves
                                        zeroLineColor: 'transparent'
                                    },
                                    ticks: $.extend({
                                        beginAtZero: true,
                                        callback: function (value) {
                                            if (value >= 1000) {
                                                value /= 1000
                                                value += 'k'
                                            }
                                            return '$' + value
                                        }
                                    }, ticksStyle)
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: ticksStyle
                                }]
                            }
                        }
                    })
                } catch (error) {
                    console.log(error);
                }
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
})

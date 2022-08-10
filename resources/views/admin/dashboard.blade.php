@extends('admin.layout.layout')
@section('title','داشبورد')
@section('page')

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                                کل کاربران
                            </div>
                            <div class="visitors-nb text-gradient-02">
                                {!! $allUsers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                               کاربران امروز
                            </div>
                            <div class="visitors-nb text-gradient-02">
                                {!! $todayUsers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                                کاربران یک هفته اخیر
                            </div>
                            <div class="visitors-nb text-gradient-02">
                                {!! $oneWeekUsers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                                کل موقعیت های شغلی
                            </div>
                            <div class="visitors-nb text-gradient-02">
                                {!! $totalJobOffers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                                موقعیت های شغلی امروز
                            </div>
                            <div class="visitors-nb text-gradient-02">
                                {!! $todayJobOffers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                               کاربران 30 روز اخیر
                            </div>
                            <div class="visitors-nb text-gradient-02">
                                {!!$thirtyDaysUsers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                                اگهی های استخدام بانک ها
                            </div>
                            <div class="visitors-nb text-gradient-02" style="font-size: 4em;padding-top: 18px;">
                                {!! $bankJobOffers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="widget-36 widget has-shadow">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-xl-12 text-center mt-5 mb-5">
                            <div class="nb-visitors">
                                اگهی های استخدام موسسات دولتی
                            </div>
                            <div class="visitors-nb text-gradient-02" style="font-size: 4em;padding-top: 18px;">
                                {!!$governmentalJobOffers ?? 0 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="widget has-shadow">
        <div class="widget-header no-actions d-flex align-items-center">
            <h4>کاربران 30 روز اخیر</h4>
        </div>
        <div class="widget-body">
            <div class="chart">
                <canvas id="users-ten-days"></canvas>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets/admin/vendors/js/chart/chart.min.js"></script>
    <script>
        $(function () {
            var ctx = document.getElementById('users-ten-days').getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['{!! \App\Helpers\getDateByNum(30) !!}','{!! \App\Helpers\getDateByNum(29) !!}','{!! \App\Helpers\getDateByNum(28) !!}','{!! \App\Helpers\getDateByNum(27) !!}','{!! \App\Helpers\getDateByNum(26) !!}','{!! \App\Helpers\getDateByNum(25) !!}','{!! \App\Helpers\getDateByNum(24) !!}','{!! \App\Helpers\getDateByNum(23) !!}','{!! \App\Helpers\getDateByNum(22) !!}','{!! \App\Helpers\getDateByNum(21) !!}','{!! \App\Helpers\getDateByNum(20) !!}','{!! \App\Helpers\getDateByNum(19) !!}','{!! \App\Helpers\getDateByNum(18) !!}','{!! \App\Helpers\getDateByNum(17) !!}','{!! \App\Helpers\getDateByNum(16) !!}','{!! \App\Helpers\getDateByNum(15) !!}','{!! \App\Helpers\getDateByNum(14) !!}','{!! \App\Helpers\getDateByNum(13) !!}','{!! \App\Helpers\getDateByNum(12) !!}','{!! \App\Helpers\getDateByNum(11) !!}','{!! \App\Helpers\getDateByNum(10) !!}','{!! \App\Helpers\getDateByNum(9) !!}','{!! \App\Helpers\getDateByNum(8) !!}','{!! \App\Helpers\getDateByNum(7) !!}','{!! \App\Helpers\getDateByNum(6) !!}','{!! \App\Helpers\getDateByNum(5) !!}','{!! \App\Helpers\getDateByNum(4) !!}','{!! \App\Helpers\getDateByNum(3) !!}','{!! \App\Helpers\getDateByNum(2) !!}','{!! \App\Helpers\getDateByNum(1) !!}','{!! \App\Helpers\getDateByNum(0) !!}'],

                    datasets: [{
                        label: "کاربر",
                        borderColor: "#08a6c3",
                        pointBackgroundColor: "#08a6c3",
                        pointHoverBorderColor: "#08a6c3",
                        pointHoverBackgroundColor: "#08a6c3",
                        pointBorderColor: "#fff",
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        fill: true,
                        backgroundColor: "transparent",
                        borderWidth: 3,
                        data: ['{!! \App\Helpers\userCountByDay(-30) !!}','{!! \App\Helpers\userCountByDay(-29) !!}','{!! \App\Helpers\userCountByDay(-28) !!}','{!! \App\Helpers\userCountByDay(-27) !!}','{!! \App\Helpers\userCountByDay(-26) !!}','{!! \App\Helpers\userCountByDay(-25) !!}','{!! \App\Helpers\userCountByDay(-24) !!}','{!! \App\Helpers\userCountByDay(-23) !!}','{!! \App\Helpers\userCountByDay(-22) !!}','{!! \App\Helpers\userCountByDay(-21) !!}','{!! \App\Helpers\userCountByDay(-20) !!}','{!! \App\Helpers\userCountByDay(-19) !!}','{!! \App\Helpers\userCountByDay(-18) !!}','{!! \App\Helpers\userCountByDay(-17) !!}','{!! \App\Helpers\userCountByDay(-16) !!}','{!! \App\Helpers\userCountByDay(-15) !!}','{!! \App\Helpers\userCountByDay(-14) !!}','{!! \App\Helpers\userCountByDay(-13) !!}','{!! \App\Helpers\userCountByDay(-12) !!}','{!! \App\Helpers\userCountByDay(-11) !!}','{!! \App\Helpers\userCountByDay(-10) !!}','{!! \App\Helpers\userCountByDay(-9) !!}','{!! \App\Helpers\userCountByDay(-8) !!}','{!! \App\Helpers\userCountByDay(-7) !!}','{!! \App\Helpers\userCountByDay(-6) !!}','{!! \App\Helpers\userCountByDay(-5) !!}','{!! \App\Helpers\userCountByDay(-4) !!}','{!! \App\Helpers\userCountByDay(-3) !!}','{!! \App\Helpers\userCountByDay(-2) !!}','{!! \App\Helpers\userCountByDay(-1) !!}','{!! \App\Helpers\userCountByDay(0) !!}']

                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: 'rgba(47, 49, 66, 0.8)',
                        titleFontSize: 13,
                        titleFontColor: '#fff',
                        caretSize: 0,
                        cornerRadius: 4,
                        xPadding: 10,
                        displayColors: false,
                        yPadding: 10
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                display: true,
                                beginAtZero: true
                            },
                            gridLines: {
                                drawBorder: true,
                                display: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                drawBorder: true,
                                display: true
                            },
                            ticks: {
                                display: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
    <script>
        $(function () {
            'use strict';

            // ------------------------------------------------------- //
            // Delivered Orders
            // ------------------------------------------------------ //
            var randomScalingFactor = function () {
                return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
            };

            Chart.helpers.drawRoundedTopRectangle = function (ctx, x, y, width, height, radius) {
                ctx.beginPath();
                ctx.moveTo(x + radius, y);
                ctx.lineTo(x + width - radius, y);
                ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
                ctx.lineTo(x + width, y + height);
                ctx.lineTo(x, y + height);
                ctx.lineTo(x, y + radius);
                ctx.quadraticCurveTo(x, y, x + radius, y);
                ctx.closePath();
            };

            Chart.elements.RoundedTopRectangle = Chart.elements.Rectangle.extend({
                draw: function () {
                    var ctx = this._chart.ctx;
                    var vm = this._view;
                    var left, right, top, bottom, signX, signY, borderSkipped;
                    var borderWidth = vm.borderWidth;

                    if (!vm.horizontal) {
                        left = vm.x - vm.width / 2;
                        right = vm.x + vm.width / 2;
                        top = vm.y;
                        bottom = vm.base;
                        signX = 1;
                        signY = bottom > top ? 1 : -1;
                        borderSkipped = vm.borderSkipped || 'bottom';
                    } else {
                        left = vm.base;
                        right = vm.x;
                        top = vm.y - vm.height / 2;
                        bottom = vm.y + vm.height / 2;
                        signX = right > left ? 1 : -1;
                        signY = 1;
                        borderSkipped = vm.borderSkipped || 'left';
                    }

                    if (borderWidth) {
                        var barSize = Math.min(Math.abs(left - right), Math.abs(top - bottom));
                        borderWidth = borderWidth > barSize ? barSize : borderWidth;
                        var halfStroke = borderWidth / 2;
                        var borderLeft = left + (borderSkipped !== 'left' ? halfStroke * signX : 0);
                        var borderRight = right + (borderSkipped !== 'right' ? -halfStroke * signX : 0);
                        var borderTop = top + (borderSkipped !== 'top' ? halfStroke * signY : 0);
                        var borderBottom = bottom + (borderSkipped !== 'bottom' ? -halfStroke * signY : 0);
                        if (borderLeft !== borderRight) {
                            top = borderTop;
                            bottom = borderBottom;
                        }
                        if (borderTop !== borderBottom) {
                            left = borderLeft;
                            right = borderRight;
                        }
                    }

                    var barWidth = Math.abs(left - right);
                    var roundness = this._chart.config.options.barRoundness || 0.2;
                    var radius = barWidth * roundness * 0.2;

                    var prevTop = top;

                    top = prevTop + radius;
                    var barRadius = top - prevTop;

                    ctx.beginPath();
                    ctx.fillStyle = vm.backgroundColor;
                    ctx.strokeStyle = vm.borderColor;
                    ctx.lineWidth = borderWidth;

                    Chart.helpers.drawRoundedTopRectangle(ctx, left, (top - barRadius + 1), barWidth, bottom - prevTop, barRadius);

                    ctx.fill();
                    if (borderWidth) {
                        ctx.stroke();
                    }

                    top = prevTop;
                },
            });

            Chart.defaults.roundedBar = Chart.helpers.clone(Chart.defaults.bar);

            Chart.controllers.roundedBar = Chart.controllers.bar.extend({
                dataElementType: Chart.elements.RoundedTopRectangle
            });


            // ------------------------------------------------------- //
            // Circle Orders
            // ------------------------------------------------------ //
            $('.circle-orders').circleProgress({
                value: 0.43,
                size: 120,
                startAngle: -Math.PI / 2,
                thickness: 6,
                lineCap: 'round',
                emptyFill: '#e4e8f0',
                fill: {
                    gradient: ['#0087a4', '#08a6c3']
                }
            }).on('circle-animation-progress', function (event, progress) {
                $(this).find('.percent-orders').html(Math.round(43 * progress) + '<i>%</i>');
            });

            // ------------------------------------------------------- //
            // Top Author
            // ------------------------------------------------------ //
            var ctx = document.getElementById('sales-stats').getContext("2d");

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["02/10", "02/11", "02/12", "02/13", "02/14", "02/15"],
                    datasets: [{
                        label: "فروش ها",
                        borderColor: '#08a6c3',
                        pointRadius: 0,
                        pointHitRadius: 5,
                        pointHoverRadius: 3,
                        pointHoverBorderColor: "#08a6c3",
                        pointHoverBackgroundColor: "#08a6c3",
                        pointHoverBorderWidth: 3,
                        fill: true,
                        backgroundColor: '#fff',
                        borderWidth: 3,
                        data: [10, 6, 14, 8, 12, 10]
                    }]
                },
                options: {
                    tooltips: {
                        backgroundColor: 'rgba(47, 49, 66, 0.8)',
                        titleFontSize: 13,
                        titleFontColor: '#fff',
                        caretSize: 0,
                        cornerRadius: 4,
                        xPadding: 5,
                        displayColors: false,
                        yPadding: 5,
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                display: false,
                                beginAtZero: false,
                                maxTicksLimit: 2,
                            },
                            gridLines: {
                                drawBorder: false,
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display: false
                            },
                            ticks: {
                                display: false
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection

@extends('layouts.admin.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">Jumlah Paket Yang Belum Diambil</span>
                    <h3 class="card-title mb-2"><span class="counter" data-counter="{{ $paket_belum_diambil }}">0</span></h3>
                    <br/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">Jumlah Paket Yang Disita</span>
                    <h3 class="card-title mb-2"><span class="counter" data-counter="{{ $paket_disita }}">0</span></h3>
                    <br/>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header p-3 border-bottom">
                    <div class="fw-bold fs-5">Paket Masuk Per Kategori</div>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div id="chart-grafik-kategori-paket" class="px-2"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header p-3 border-bottom row align-items-center">
                    <div class="col-md-8">
                        <div class="fw-bold fs-5">Frekuensi Paket Masuk</div>
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-md-end">
                            <div class="col-auto order-2 order-md-1">
                                <div class="dropdown mb-2" id="dropdown-aksi">
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-cogs"></i> Mode</button>
                                    <ul class="dropdown-menu" id="toggle-chart-paket">
                                        <li>
                                            <button type="button" class="dropdown-item" data-mode="harian">
                                                Harian
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-mode="mingguan">
                                                Mingguan
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-mode="bulanan">
                                                Bulanan
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-mode="tahunan">
                                                Tahunan
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div id="chart-grafik-paket" class="px-2"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom row align-items-center">
                    <div class="col-md-8">
                        <div class="fw-bold fs-5">5 Daftar Paket Terbaru</div>
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-md-end">
                            <div class="col-auto order-2 order-md-1">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.paket.index') }}">Lihat Semua <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama</th>
                                    <th>Tanggal Terima</th>
                                    <th>Kategori</th>
                                    <th>Asrama</th>
                                    <th>Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paket_latest as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->tgl_diterima }}</td>
                                        <td>{{ $item->kategori->nama ?? '-' }}</td>
                                        <td>{{ $item->asrama->nama ?? '-' }}</td>
                                        <td>
                                            @if(GlobalHelper::isHaveAbility('mst_santri:read'))
                                                <a target="_blank" href="{{ route('admin.settings.santri.show', $item->penerima_id) }}">
                                                    <div class="py-1">{{ $item->penerima->nama ?? '-' }}</div>
                                                </a>
                                            @else
                                                {{ $item->penerima->nama ?? '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/template/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<script>
    const handleCounter = function(){
        const init = function(){
            $('.counter').each(function () {
                $(this).prop('Counter',0).animate({
                    Counter: $(this).data('counter')
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function (now) {
                        now = Number(Math.ceil(now)).toLocaleString('en');
                        $(this).text(now);
                    }
                });
            });
        }
        return {
            init: () => {
                init();
            }
        }
    }();

    const handleChart = function(){
        const initPaket = function(){
            let chart = null;

            const render = function(series){
                if(!chart){
                    const options = {
                        series: [{
                            name: "Desktops",
                            data: series
                        }],
                        chart: {
                            height: 350,
                            type: 'area',
                        },
                        dataLabels: {
                            enabled: false
                        },
                        markers: {
                            size: 0,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                inverseColors: false,
                                opacityFrom: 0.5,
                                opacityTo: 0,
                                stops: [0, 90, 100]
                            },
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                        },
                    };
                    console.log(options);
                    chart = new ApexCharts(document.querySelector("#chart-grafik-paket"), options);
                    
                    chart.render();
                }else{
                    chart.updateSeries([{
                        data: series
                    }]);
                }
            };

            $('#toggle-chart-paket').on('click', '[data-mode]', function(){
                const mode = $(this).data('mode');
                let url = "{{ route($route.'.get_chart_paket', ':mode') }}";
                url = url.replace(':mode', mode);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        if(response.is_success){
                            render(response.data);
                        }
                    }
                })
            });

            $('#toggle-chart-paket').find('[data-mode="harian"]').click();
        };

        const initKategoriPaket = function(){
            const data = @json($chart['kategori']);
            const options = {
                series: [{
                    data: data.series
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        borderRadiusApplication: 'end',
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: data.categories,
                }
            };

            const chart = new ApexCharts(document.querySelector("#chart-grafik-kategori-paket"), options);
            chart.render();
        };

        const init = function(){
            initPaket();
            initKategoriPaket()
        };

        return {
            init: () => init()
        }
    }();

    $(function(){
        handleCounter.init();
        handleChart.init();
    });
</script>
@endsection
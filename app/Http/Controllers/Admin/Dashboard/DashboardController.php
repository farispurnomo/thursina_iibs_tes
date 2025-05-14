<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\MstKategoriPaket;
use App\Models\TPaket;
use DateTime;
use Throwable;

class DashboardController extends Controller
{
    private $route              = 'admin.dashboard';
    private $namespace          = 'pages.admin.dashboard.';
    private $pagetitle          = 'Dashboard';
    private $permission         = 'dashboard:';

    public function index()
    {
        GlobalHelper::mustHaveAbility($this->permission . 'read');

        $data['route']                  = $this->route;
        $data['namespace']              = $this->namespace;
        $data['pagetitle']              = $this->pagetitle;

        $data['paket_belum_diambil']    = TPaket::where('status', TPaket::STATE_BELUM)->count();
        $data['paket_disita']           = TPaket::whereNotNull('isi_yg_disita')->orWhere('isi_yg_disita', '<>', '')->count();
        $data['paket_latest']           = TPaket::latest()->limit(5)->get();
        $data['chart']                  = array(
            'kategori'  => array(
                'categories'    => [],
                'series'        => [],
            )
        );

        $kategoris                      = MstKategoriPaket::orderBy('nama')->get();
        foreach ($kategoris as $kategori) {
            $data['chart']['kategori']['categories'][]  = $kategori->nama;
            $data['chart']['kategori']['series'][]      = TPaket::where('kategori_id', $kategori->id)->count();
        }

        return view($this->namespace . 'index', $data);
    }

    public function get_chart_paket($mode)
    {
        try {
            $result                 = array();

            if ($mode == 'harian') {
                $start = new DateTime('-1 month');
                $end = new DateTime();

                while ($start <= $end) {
                    $tanggal    = $start->format('Y-m-d');
                    $result[]   = array(
                        'x' => $tanggal,
                        'y' => TPaket::where('tgl_diterima', $tanggal)->count()
                    );

                    $start->modify('+1 day');
                }
            }

            if ($mode == 'mingguan') {
                $now = new DateTime('-10 week');
                $now->modify('monday this week');

                for ($i = 0; $i < 10; $i++) {
                    $start          = clone $now;
                    $end            = (clone $now)->modify('sunday this week');

                    $result[]   = array(
                        'x' => 'w-' . $start->format('W'),
                        'y' => TPaket::where('tgl_diterima', '>=', $start->format('Y-m-d'))
                            ->where('tgl_diterima', '<=', $end->format('Y-m-d'))
                            ->count()
                    );
                    $now->modify('+1 week');
                }
            }

            if ($mode == 'bulanan') {
                $now = new DateTime('-11 month');

                for ($i = 0; $i <= 12; $i++) {
                    $bulan = $now->format('m');
                    $tahun = $now->format('Y');

                    $result[]       = array(
                        'x' => "$bulan-$tahun",
                        'y' => TPaket::whereYear('tgl_diterima', $tahun)
                            ->whereMonth('tgl_diterima', $bulan)
                            ->count()
                    );

                    $now->modify('+1 month');
                }
            }

            if ($mode == 'tahunan') {
                $start  = date('Y', strtotime('-5 years'));
                $end    = date('Y');

                for ($i = $start; $i <= $end; $i++) {
                    $result[]       = array(
                        'x' => $i,
                        'y' => TPaket::whereYear('tgl_diterima', $i)->count()
                    );
                }
            }

            $datarow                = array();
            $datarow['is_success']  = true;
            $datarow['msg']         = 'sukses';
            $datarow['data']        = $result;
        } catch (Throwable $th) {
            $datarow                = array();
            $datarow['is_success']  = false;
            $datarow['msg']         = $th->getMessage();
        } finally {
            return response()->json($datarow);
        }
    }
}

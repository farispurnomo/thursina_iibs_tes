<?php

namespace App\Helpers;

use App\Models\AppSetting;
use App\Models\CoreMenu;
use App\Models\CorePrivilege;
use DateTime;
use Illuminate\Support\Facades\Auth;

class GlobalHelper
{
    public static function getSettingDefault(string $param)
    {
        return AppSetting::find($param)->value ?? '';
    }

    public static function getTreeMenuByChild(array $ids)
    {
        $user       = Auth::user();
        $menus      = [];

        $get_notif  = function ($menu) use ($user) {
            return $menu;
        };

        // untuk mencari parent teratas hanya dengan parent_id pertama
        $find_parent = function ($parent_id, $child) use (&$find_parent) {
            $menu           = CoreMenu::find($parent_id)->toArray();
            $menu['notif']  = array(
                'enabled'   => false,
                'value'     => 0
            );

            $menu['childs'][$child['id']] = $child;
            if ($menu['parent_id']) {
                $menu = $find_parent($menu['parent_id'], $menu);
            }

            return $menu;
        };

        // untuk menambahkan child ke array menus
        $append_menus = function ($parent, &$menus) use (&$append_menus) {
            foreach ($parent['childs'] as $key => $value) {
                if (isset($menus['childs'][$key])) {
                    if (isset($menus['childs'][$key])) {
                        $menus['childs'][$key] = $append_menus($value, $menus['childs'][$key]);
                    } else {
                        $menus['childs'][$key] = $value;
                    }
                } else {
                    $menus['childs'][$key] = $value;
                }
            }
            return $menus;
        };

        // 1. cari tree per menu
        // 2. tambahkan ke $menus 1 per 1
        // 3. reindex + reorder array $menus
        foreach ($ids as $id) {
            $menu = CoreMenu::find($id)->toArray();
            $menu['childs'] = [];
            $menu['notif']  = array(
                'enabled'   => false,
                'value'     => 0
            );

            $menu           = $get_notif($menu);

            if ($menu['parent_id']) {
                $parent = $find_parent($menu['parent_id'], $menu);
                if (isset($menus[$parent['id']])) {
                    $menus[$parent['id']] = $append_menus($parent, $menus[$parent['id']]);
                } else {
                    $menus[$parent['id']] = $parent;
                }
            } else {
                $menus[$menu['id']] = $menu;
            }
        }

        // untuk re-index + reorder key $menus
        $reIndexMenus = function ($menus) use (&$reIndexMenus) {
            $count = 0;
            $result = array();
            foreach ($menus as $menu) {
                $result[$count] = $menu;
                $result[$count]['childs'] = $reIndexMenus($menu['childs']);
                ++$count;
            }
            usort($result, function ($a, $b) {
                return $a['order'] <=> $b['order'];
            });
            return $result;
        };

        // return array_values($menus);
        // return $menus;
        return $reIndexMenus($menus);
    }

    public static function getMenuUserLogin()
    {
        $user       = Auth::user();
        $menuIds    = [];
        $abilities  = [];

        if (!$user) return [];
        $user->load('role.abilities.menu');

        // dd($user->role->abilities->toArray());
        foreach ($user->role->abilities as $ability) {
            if (!$ability->menu->is_show) continue;

            if (str_contains($ability->name, ':read')) { // hanya ability {menu}:read yang ditampilkan :)
                $menuIds[] = $ability->menu->id;
            }
            $abilities[] = "{$ability->menu->name}:{$ability->name}";
        }

        sort($abilities);
        unset($user->role->abilities);
        $menuIds = array_unique($menuIds);

        return GlobalHelper::getTreeMenuByChild($menuIds);
    }

    public static function isHaveAbility($ability = null): bool
    {
        $role_id = Auth::user()->role_id;
        return CorePrivilege::leftJoin('core_menu_abilities', 'core_menu_abilities.id', '=', 'core_privileges.ability_id')
            ->where('role_id', $role_id)
            ->where('core_menu_abilities.name', $ability)
            ->exists();
    }

    public static function mustHaveAbility($ability = null)
    {
        $isHaveAbility = GlobalHelper::isHaveAbility($ability);
        if (!$isHaveAbility) return abort(403);
    }

    public static function timeElapsedString($datetime, $full = false)
    {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second'
        );

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function numberToRoman($number)
    {
        $map = array(
            'M'     => 1000,
            'CM'    => 900,
            'D'     => 500,
            'CD'    => 400,
            'C'     => 100,
            'XC'    => 90,
            'L'     => 50,
            'XL'    => 40,
            'X'     => 10,
            'IX'    => 9,
            'V'     => 5,
            'IV'    => 4,
            'I'     => 1
        );

        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public static function terbilang($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = self::terbilang($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = self::terbilang($nilai / 10) . " puluh" . self::terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . self::terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = self::terbilang($nilai / 100) . " ratus" . self::terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . self::terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = self::terbilang($nilai / 1000) . " ribu" . self::terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = self::terbilang($nilai / 1000000) . " juta" . self::terbilang($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = self::terbilang($nilai / 1000000000) . " milyar" . self::terbilang(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = self::terbilang($nilai / 1000000000000) . " trilyun" . self::terbilang(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public static function numberFormatShort($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            // $suffix = 'K';
            $suffix = 'Rb';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            // $suffix = 'M';
            $suffix = 'Jt';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            // $suffix = 'B';
            $suffix = 'M';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        return $n_format . $suffix;
    }
}

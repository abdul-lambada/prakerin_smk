<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $keys = [
            'app_name',
            'app_logo',
            'app_short_name',
            'school_name',
            'school_address',
            'school_phone',
            'school_email',
            'theme_color_primary',
            'active_academic_year',
            'active_pkl_year',
            'pkl_start_date',
            'pkl_end_date',
            'pkl_min_presence_percent',
            'pkl_min_grade',
            'pkl_weight_nilai_du_di',
            'pkl_weight_nilai_sekolah',
            'max_students_per_industri',
            'max_pkl_places_per_student',
            'dashboard_info_banner',
            'maintenance_mode',
            'maintenance_message',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key);
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'app_name' => 'nullable|string|max:255',
            'app_short_name' => 'nullable|string|max:50',
            'school_name' => 'nullable|string|max:255',
            'school_address' => 'nullable|string',
            'school_phone' => 'nullable|string|max:50',
            'school_email' => 'nullable|email|max:255',
            'theme_color_primary' => 'nullable|string|max:50',
            'active_academic_year' => 'nullable|string|max:20',
            'active_pkl_year' => 'nullable|string|max:20',
            'pkl_start_date' => 'nullable|date',
            'pkl_end_date' => 'nullable|date',
            'pkl_min_presence_percent' => 'nullable|numeric|min:0|max:100',
            'pkl_min_grade' => 'nullable|numeric|min:0|max:100',
            'pkl_weight_nilai_du_di' => 'nullable|numeric|min:0|max:100',
            'pkl_weight_nilai_sekolah' => 'nullable|numeric|min:0|max:100',
            'max_students_per_industri' => 'nullable|integer|min:0',
            'max_pkl_places_per_student' => 'nullable|integer|min:0',
            'dashboard_info_banner' => 'nullable|string',
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        // Handle logo upload terpisah
        if ($request->hasFile('app_logo')) {
            $file = $request->file('app_logo');
            $path = $file->store('logos', 'public');
            // Simpan path relatif yang bisa dipanggil oleh asset()
            Setting::set('app_logo', 'storage/'.$path);
        }

        unset($data['app_logo']);

        foreach ($data as $key => $value) {
            if ($key === 'maintenance_mode') {
                $value = $request->has('maintenance_mode') ? '1' : '0';
            }

            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('status', 'Pengaturan berhasil disimpan.');
    }
}

<?php
namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use App\Models\SettingsModel;


class SystemSetting extends BaseController
{
protected $settingsModel;


public function __construct()
{
$this->settingsModel = new SettingsModel();
}


public function index()
{
    // ambil value dari key
    $data = [
        'title' => 'Pengaturan Pengiriman',
        'activeMenu' => 'settings', // biar sidebar tahu menu mana yang aktif
        'shipping_fee' => $this->settingsModel->getValue('shipping_fee', '0'),
        'free_shipping_min' => $this->settingsModel->getValue('free_shipping_min', '0'),
        'service_radius_km' => $this->settingsModel->getValue('service_radius_km', '0'),
    ];

    // Kembalikan view yang menggunakan extend('layout/admin_template')
    return view('admin/system_setting', $data);
}

public function save()
{
helper('form');
$post = $this->request->getPost();


// normalisasi angka: hapus non-digit
$shipping_fee = preg_replace('/[^0-9]/', '', $post['shipping_fee'] ?? '0');
$free_shipping_min = preg_replace('/[^0-9]/', '', $post['free_shipping_min'] ?? '0');
$service_radius_km = preg_replace('/[^0-9]/', '', $post['service_radius_km'] ?? '0');


// simpan ke settings (upsert)
$this->settingsModel->setValue('shipping_fee', $shipping_fee, 'Biaya pengiriman standar');
$this->settingsModel->setValue('free_shipping_min', $free_shipping_min, 'Minimal pesanan untuk gratis ongkir');
$this->settingsModel->setValue('service_radius_km', $service_radius_km, 'Radius layanan (km)');


// redirect kembali ke index dengan pesan success
return redirect()->to(base_url('admin/system-setting'))->with('success', 'Pengaturan berhasil disimpan');
}
}
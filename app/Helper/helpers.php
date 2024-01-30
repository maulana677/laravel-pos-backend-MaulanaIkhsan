<?php

function handleUpload($inputName, $model = null)
{
    try {
        if (request()->hasFile($inputName)) {
            if ($model && \File::exists(public_path($model->{$inputName}))) {
                \File::delete(public_path($model->{$inputName}));
            }

            $file = request()->file($inputName);
            $fileName = rand() . $file->getClientOriginalName();
            $file->move(public_path('public/products/'), $fileName);

            return $fileName;
        }
    } catch (\Exception $e) {
        throw $e;
    }
}

/** Hapus File */
function deleteFileIfExist($fileName)
{
    try {
        if (\File::exists(public_path($fileName))) {
            \File::delete(public_path($fileName));
        }
    } catch (\Exception $e) {
        throw $e;
    }
}

/** Pengaturan Aktif Sidebar  */

function setSidebarActive($route)
{
    if (is_array($route)) {
        foreach ($route as $r) {
            if (request()->routeIs($r)) {
                return 'active';
            }
        }
    }
}

if (!function_exists('currency_IDR')) {
    function currency_IDR($price): string
    {
        if ("Rp. " . number_format($price, 0, ',', '.')) {
            return "Rp. " . number_format($price, 0, ',', '.');
        } else {
            return $price . "Rp. " . number_format($price, 0, ',', '.');
        }
    }
}

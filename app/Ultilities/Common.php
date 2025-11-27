<?php

namespace App\Ultilities;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Common
{
    public static function uploadFile($file, $folder = 'products')
    {
        // Lấy tên file an toàn
        $file_name_original = $file->getClientOriginalName();
        $file_extension = $file->getClientOriginalExtension();

        $file_name_without_extension = Str::replaceLast('.' . $file_extension, '', $file_name_original);
        $file_name_without_extension = Str::slug($file_name_without_extension);

        $str_time_now = Carbon::now()->format('ymd_his');
        $file_name = $file_name_without_extension . '_' . uniqid() . '_' . $str_time_now . '.' . $file_extension;

        // Lưu vào storage/app/public/{folder}
        $path = $file->storeAs('public/' . $folder, $file_name);

        // Trả về đường dẫn public để hiển thị
        return 'storage/' . $folder . '/' . $file_name;
    }
}

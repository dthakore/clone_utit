<?php

namespace App\Helpers;

use App\Models\CbmUserLicenses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Puxeo;

class ServiceHelper {

    /**
     * Add to CBM User Licenses
     * If already present, modify if required
     * @return array
     */
    public static function modifyCBMUserLicenses($userId, $email, $totalLicenses, $availableLicenses)
    {

        $cbm_user_license = CbmUserLicenses::where('email', $email)->first();
        if (isset($cbm_user_license->email)) {
            if (($cbm_user_license->user_id == 0) || empty($cbm_user_license->user_id))
                $cbm_user_license->user_id = $userId;
            $cbm_user_license->total_licenses += $totalLicenses;
            $cbm_user_license->available_licenses += $availableLicenses;
            $cbm_user_license->updated_at = now();
            $cbm_user_license->save();
        } else {
            //Add to CBM User License
            $cbm_user_licenses = new CbmUserLicenses;
            $cbm_user_licenses->user_id = $userId;
            $cbm_user_licenses->email = $email;
            $cbm_user_licenses->total_licenses = $totalLicenses;
            $cbm_user_licenses->available_licenses = $availableLicenses;
            $cbm_user_licenses->created_at = now();
            $cbm_user_licenses->save();
        }
    }

    /**
     * Get User Theme Options
     * @return string
     */
    public static function getThemeOptions()
    {
//        $host = request()->getHttpHost();
//        $tenant = Puxeo::Where('domain', $host)->first();

        return [
            "app_name" =>'Fresh',
            "theme" => 'Fresh',
            "sidebar" => 'Fresh',
            "logo" => 'Fresh'
        ];
    }
}
?>

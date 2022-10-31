<?php

namespace App\Helpers;

use App\Models\User;

class BinaryTreeHelper {

    /**
     * Return parent trace
     * @return array
     */
    public static function GetParentTrace($userId, $noOfParents)
    {
        $search = $userId;
        $level = 1;
        $parents = [];
        for($level;$level <= $noOfParents;$level++) {
            $sponsor = User::find($search);
            if(!empty($sponsor)) {
                $parents[] = [
                    'level' => $level,
                    'userId' => $sponsor->sponsor_id
                ];
                $search = $sponsor->sponsor_id;
            }
        }
        return $parents;
    }
}
?>
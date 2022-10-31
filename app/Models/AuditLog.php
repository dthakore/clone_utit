<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public const CATEGORY_SELECT = [
        'Register' => 'Register',
        'Login/Logout' => 'Login/Logout',
        'Profile Update' => 'Profile Update',
        'Deposit/Withdrawal' => 'Deposit/Withdrawal',
        'Change Password' => 'Change Password',
        'Package Purchase' => 'Package Purchase',
        'Notification Clicked' => 'Notification Clicked',
        'Rank Update' => 'Rank Update',
    ];

    public $table = 'audit_logs';

    protected $fillable = [
        'description',
        'category',
        'subject_id',
        'subject_type',
        'model_name',
        'user_id',
        'user_email',
        'user_name',
        'action',
        'properties',
        'previous_properties',
        'host',
    ];

    protected $casts = [
        'properties' => 'collection',
        'previous_properties' => 'collection',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function insertLog($description, $category, $model, $action)
    {
        $old_model = [];
        if(!empty($model->getChanges())){
            foreach(array_keys($model->getChanges()) as $value){
                $old_model[$value] = $model->getOriginal($value);
            }
            $old_model['id'] = $model->id;
            $model->attributes = array_merge($model->getChanges(), ['id' => $model->id]);
        }
        $user = User::find(auth()->id());
        AuditLog::create([
            'description'             => $description,
            'category'                => $category,
            'subject_id'              => $model->id ?? null,
            'subject_type'            => sprintf('%s#%s', get_class($model), $model->id) ?? null,
            'model_name'              => substr(get_class($model), 11) ?? null,
            'user_id'                 => $user->id ?? null,
            'user_email'              => $user->email ?? null,
            'user_name'               => $user->name ?? null,
            'action'                  => $action,
            'properties'              => $model ?? null,
            'previous_properties'     => $old_model ?? null,
            'host'                    => request()->ip() ?? null,
        ]);
    }
}

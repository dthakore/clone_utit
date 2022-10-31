<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function (Model $model){
            if (session()->has('audit_log')) {
                $log = session()->get('audit_log');
                session()->forget('audit_log');
            }else{
                $log = "created";
            }

            self::audit($log, $model, null, 'created');
        });

        static::updated(function (Model $model){
            if (session()->has('audit_log')) {
                $log = session()->get('audit_log');
                session()->forget('audit_log');
            }else{
                if(request()->getRequestUri() == '/logout'){
                    $log = "User ".auth()->id()." logged out";
                }else{
                    $log = "updated";
                }
            }

            $old_model = [];
            foreach(array_keys($model->getChanges()) as $value){
                $old_model[$value] = $model->getOriginal($value);
            }
            $old_model['id'] = $model->id;
            $model->attributes = array_merge($model->getChanges(), ['id' => $model->id]);

            self::audit($log, $model, $old_model, 'updated');
        });

        static::deleted(function (Model $model){
            if (session()->has('audit_log')) {
                $log = session()->get('audit_log');
                session()->forget('audit_log');
            }else{
                $log = "deleted";
            }

            self::audit($log, $model, null, 'deleted');
        });
    }

    protected static function audit($description, $model, $old_model, $action)
    {
        $user = User::find(auth()->id());
        AuditLog::create([
            'description'             => $description ?? null,
            'subject_id'              => $model->id ?? null,
            'subject_type'            => sprintf('%s#%s', get_class($model), $model->id) ?? null,
            'model_name'              => substr(get_class($model), 11) ?? null,
            'user_id'                 => $user->id ?? null,
            'user_email'              => $user->email ?? null,
            'user_name'               => $user->name ?? null,
            'action'                  => $action ?? null,
            'properties'              => $model ?? null,
            'previous_properties'     => $old_model ?? null,
            'host'                    => request()->ip() ?? null,
        ]);
    }
}

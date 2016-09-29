<?php

namespace Mixdinternet\Maudit;

use Venturecraft\Revisionable\Revision as BaseRevision;

class Revision extends BaseRevision
{
    public function user()
    {
        $user_model = app('config')->get('auth.model');

        if (empty($user_model)) {
            $user_model = app('config')->get('auth.providers.users.model');
            if (empty($user_model)) {
                return false;
            }
        }

        if (!class_exists($user_model)) {
            return false;
        }

        return $user_model::withTrashed()->find($this->user_id);
    }

    public function scopeSort($query, $fields = [])
    {
        if (count($fields) <= 0) {
            $fields = [
                'created_at' => 'desc'
            ];
        }

        if (request()->has('field') && request()->has('sort')) {
            $fields = [request()->get('field') => request()->get('sort')];
        }

        foreach ($fields as $field => $order) {
            $query->orderBy($field, $order);
        }
    }
}

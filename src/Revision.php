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

}

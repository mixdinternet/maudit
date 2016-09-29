<?php

namespace Mixdinternet\Maudit\Http\Controllers;

use Mixdinternet\Admix\User;
use Illuminate\Http\Request;
use Mixdinternet\Admix\Http\Controllers\AdmixController;
use Mixdinternet\Maudit\Revision;
use Carbon\Carbon;

class MauditController extends AdmixController
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $query = Revision::sort();
        $search = [];
        $search['local'] = $request->input('local', '');
        $search['user_id'] = $request->input('user_id', '');
        $search['id'] = $request->input('id', '');
        $search['start_date'] = $request->input('start_date', '');
        $search['end_date'] = $request->input('end_date', '');

        ($search['local']) ? $query->where('revisionable_type', $search['local']) : '';
        ($search['user_id']) ? $query->where('user_id', $search['user_id']) : '';
        ($search['id']) ? $query->where('revisionable_id', $search['id']) : '';
        ($search['start_date']) ? $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y H:i', $search['start_date'])->format('Y-m-d H:i') . ':00') : '';
        ($search['end_date']) ? $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y H:i', $search['end_date'])->format('Y-m-d H:i') . ':59') : '';

        $revisions = $query->paginate(50);

        $view['search'] = $search;
        $view['revisions'] = $revisions;
        $view['alias'] = config('maudit.alias');
        $view['users'] = User::withTrashed()->get()->pluck('name', 'id')->toArray();

        return view('mixdinternet/maudit::index', $view);
    }
}

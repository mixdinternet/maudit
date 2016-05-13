@extends('admin.index')

@section('title')
    Ações dos usuários
@endsection

@section('search')
    {!! Form::model($search, ['route' => 'admin.maudit.index', 'method' => 'get', 'id' => 'form-search'
        , 'class' => '']) !!}

    <div class="row">
        <div class="col-md-4">
            {!! BootForm::select('local', 'Local', ['' => '-'] + $alias, null
                , ['class' => 'jq-select2']) !!}
        </div>
        <div class="col-md-4">
            {!! BootForm::select('user_id', 'Usuário', ['' => '-'] + $users, null
                , ['class' => 'jq-select2']) !!}
        </div>
        <div class="col-md-4">
            {!! BootForm::text('id', 'Registro') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            {!! BootForm::text('start_date', 'Data de início', null
                , ['class' => 'jq-datetimepicker', 'maxlength' => '16']) !!}
        </div>
        <div class="col-md-4">
            {!! BootForm::text('end_date', 'Date de término', null
                , ['class' => 'jq-datetimepicker', 'maxlength' => '16']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <a href="{{ route('admin.maudit.index') }}" class="btn btn-default btn-flat">
                    <i class="fa fa-list"></i>
                    <i class="fs-normal hidden-xs">Mostrar tudo</i>
                </a>
                <button class="btn btn-success btn-flat">
                    <i class="fa fa-search"></i>
                    <i class="fs-normal hidden-xs">Buscar</i>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('table')
    @if (count($revisions) > 0)
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Local</th>
                <th>Usuário</th>
                <th>Ação</th>
                <th>Registro</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($revisions as $revision)
                <tr>
                    <td>{{ $revision->id }}</td>
                    <td>@if (isset($alias[$revision->revisionable_type])) {{ $alias[$revision->revisionable_type] }} @else {{ $revision->revisionable_type }} @endif</td>
                    <td>@if ($revision->user()) {{ $revision->user()->name }} @else {{ 'Desconhecido' }} @endif</td>
                    @if($revision->key == 'created_at' && !$revision->old_value)
                        <td>criou um registro</td>
                    @elseif($revision->key == 'deleted_at' && !$revision->new_value)
                        <td>restaurou um registro</td>
                    @elseif($revision->key == 'deleted_at' && !$revision->old_value)
                        <td>removeu um registro</td>
                    @else
                        <td>alterou o campo {{ $revision->fieldName() }} de
                            @if (is_array($revision->oldValue())) <a role="button" data-container="body"
                                                                     data-toggle="popover" data-placement="top"
                                                                     data-content="{{ print_r($revision->oldValue()) }}">array</a>
                            @else {{ $revision->oldValue() }}
                            @endif
                            para
                            @if (is_array($revision->newValue())) <a role="button" data-container="body"
                                                                     data-toggle="popover" data-placement="top"
                                                                     data-content="{{ print_r($revision->newValue()) }}">array</a>
                            @else {{ $revision->newValue() }}
                            @endif
                        </td>
                    @endif
                    <td>#{{ $revision->revisionable_id }}</td>
                    <td>{{ Carbon::parse($revision->created_at)->format('d/m/Y H:i') }}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        @include('admin.partials.nothing-found')
    @endif
@endsection

@section('pagination')
    {!! $revisions->appends(request()->except(['page']))->render() !!}
@endsection

@section('pagination-showing')
    @include('admin.partials.pagination-showing', ['model' => $revisions])
@endsection
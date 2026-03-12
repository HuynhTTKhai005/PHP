@extends('admin.app')

@section('title', 'Dashboard')
@section('content')
    <div id="admin-dashboard-content" data-refresh-interval="60000">
        @include('admin.partials.dashboard_content')
    </div>
@endsection

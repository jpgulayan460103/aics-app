@extends('layouts.app')

@section('content')

<div id="app">
    <app :user="{{ $user }}" :upload-config="{{ json_encode($upload_config) }}"><app/>
</div>
@endsection

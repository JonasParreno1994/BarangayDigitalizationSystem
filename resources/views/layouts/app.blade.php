@extends('layouts.adminLayout.index')

@section('content')


    <div class="content-wrapper">
        <main>
            {{ $slot }}
        </main>
    </div>

@endsection

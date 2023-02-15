@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>AgReFed FAIR Assessment Form</h1>
        <div id="app">
            <template>
                <assessment>
                    {{ csrf_field() }}
                </assessment>
            </template>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="app">
            <template>
                <Help>
                    {{ csrf_field() }}
                </Help>
            </template>
        </div>
    </div>
@endsection

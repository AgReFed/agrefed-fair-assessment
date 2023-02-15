@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>AgReFed FAIR Assessment Result</h1>
        <div id="app">
            <template>
                <assessment_result>
                    {{ csrf_field() }}
                </assessment_result>
            </template>
        </div>
    </div>
@endsection

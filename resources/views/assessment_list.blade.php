@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container bg-white p-4">
            <h1>Saved assessments</h1>
            <div id="app">
                <template>
                    <assessment_list>
                        {{ csrf_field() }}
                    </assessment_list>
                </template>
            </div>

        </div>
    </div>
@endsection

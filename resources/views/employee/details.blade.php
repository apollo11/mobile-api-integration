@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                        <pre>
                {{ $userDetails->id }}
            </pre>
                <pre>
                {{ $userDetails->userName }}
            </pre>
                <pre>
                {{ $userDetails->userMobile }}
            </pre>
            </div>

            <div class="row">
                @foreach($jobDetails as $value  )
                <pre>
                    {{ $value->id}}
                </pre>
                    @endforeach
            </div>
        </div>
    </div>

@endsection
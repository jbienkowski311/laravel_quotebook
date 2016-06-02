@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                    <hr />
                    <a href="{{ route('dashboard') }}" class="btn btn-default">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

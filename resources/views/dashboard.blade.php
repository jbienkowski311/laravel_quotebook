@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <p>You are logged in!</p>
                    <div class="form-group">
                        <label for="api_token">Your API token:</label>
                        <input class="form-control" type="text" value="{{ Auth::user()->api_token }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Quotes</div>
                <div class="panel-body">
                    @foreach($quotes as $index => $quote)
                    @if($index%2==0)
                    <div class="row">
                    @endif
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Quote #{{ $index+1 }}</div>
                                <div class="panel-body quotes">
                                    <blockquote>
                                        <p>{{ $quote->text }}</p>
                                        <footer>by <cite title="{{ $quote->author->name }}">{{ $quote->author->name }}</cite></footer>
                                    </blockquote>
                                </div>
                                <div class="panel-footer">
                                    @if(!Auth::user()->quotes()->find($quote->id))
                                    <a href="{{ route('user.like.quote', ['quote_id' => $quote->id]) }}" class="btn btn-info">Like Quote</a>
                                    @else
                                    <a href="{{ route('user.unlike.quote', ['quote_id' => $quote->id]) }}" class="btn btn-warning">Unlike Quote</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @if($index%2==1)
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

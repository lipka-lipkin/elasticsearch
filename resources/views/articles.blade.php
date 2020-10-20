<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

{{--@extends('layouts.app')--}}
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Articles <small>({{ count($articles) }})</small>
            </div>
            <div class="card-body">
                @forelse ($articles as $article)
                    <article class="mb-3">
                        <h2>{{ $article['title'] }}</h2>
                        <h3>{{ $article['description'] }}</h3>
                        <p class="m-0">{{ $article['body'] }}</p>

                        <div>
                            @foreach ($article['tags'] as $tag)
                                <span class="badge badge-light">{{ $tag}}</span>
                            @endforeach
                        </div>
                    </article>
                @empty
                    <p>No articles found</p>
                @endforelse
            </div>
        </div>
    </div>
@stop



</body>
</html>



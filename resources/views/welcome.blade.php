@extends('layouts.app')

@section('content')
<img class="block px-1 w-full h-full" src="{{ Storage::url('images/banner.jpg') }}" alt="" style="object-fit: cover;">

<div class="container mx-auto font-sans">
    <h1 class="text-center mb-4">Welcome to {{ config('app.name') }}!</h1>

    <div class="w-full">
        <h1 class="text-center font-thin mb-4">Longing for the glorious days of Pandaria?</h1>
        <h2 class="text-center font-thin leading-normal mb-4">
            - Then you've come to the right place!
        </h2>

        @include('components.feature-cards')
    </div>

    <div class="text-center">
        <h1 class="font-thin leading-normal mb-4">
            What are you waiting for?
        </h1>
        <a href="{{ url('register') }}" class="text-3xl no-underline font-normal font-medium:hover">
            - Create your account!
        </a>
    </div>
    <hr class="border-t"></hr>

    <div class="w-full">
        <h1 class="font-thin mb-4 text-center">Latest news</h1>
        @foreach($news as $article)
            @include('components.news-article-preview', ['article' => $article])
        @endforeach
    </div>
</div>
@endsection
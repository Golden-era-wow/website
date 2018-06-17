@extends('layouts.app')

@section('content')
<article class="w-full text-center font-sans">
    <div class="flex flex-wrap no-underline text-black h-64 overflow-hidden">
        <img class="block pr-px w-full h-full" src="{{ $news->photo_url }}" alt="" style="object-fit: cover;">
    </div>

    <h1 class="font-thin mb-4">{{ $news->title }}</h1>

    <p class="text-grey mb-3">Written by {{ $news->creator->name }} on {{ $news->created_at->format('d M y') }}</p>

    <span class="text-grey-darkest mb-6 leading-normal">
        {{ new \Illuminate\Support\HtmlString((new \Parsedown)->text($news->body)) }}
    </span>

    {{-- <footer class="border-t border-grey-lighter text-sm flex">
    <a href="{{ $news->link }}" class="block no-underline text-blue flex px-4 py-2 items-center hover:bg-grey-lighter">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
        class="feather feather-link h-6 w-6 mr-1 stroke-current">

        <path d="M9.26 13a2 2 0 0 1 .01-2.01A3 3 0 0 0 9 5H5a3 3 0 0 0 0 6h.08a6.06 6.06 0 0 0 0 2H5A5 5 0 0 1 5 3h4a5 5 0 0 1 .26 10zm1.48-6a2 2 0 0 1-.01 2.01A3 3 0 0 0 11 15h4a3 3 0 0 0 0-6h-.08a6.06 6.06 0 0 0 0-2H15a5 5 0 0 1 0 10h-4a5 5 0 0 1-.26-10z"/>
        </svg>
        <span>Read more</span>
    </a>
    </footer> --}}
</article>
@endsection

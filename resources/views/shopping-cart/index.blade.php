@extends('layouts.app')

@section('content')
    <div class="container text-center mx-auto">
        @foreach($cart->products as $products)
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 mx-2 mb-4 rounded overflow-hidden shadow-lg">
              <img class="w-full" :src="{{ $product->photo_url }}" alt="Product photo">
              <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">
                     {{ $product->name }}
                </div>
                <h3 class="font-thin">
                     {{ $product->type }}
                </h3>
                <p class="text-grey-darker text-base">
                   {{ $product->description }}
                </p>
              </div>

              <div class="px-6 py-4">
                <!-- price tag badge -->
                <span class="inline-block bg-brand-darker rounded-full px-3 py-1 text-sm font-semibold text-brand-light mr-2">
                  {{ $product->cost }} <i class="fa fa-tag"></i>
                </span>
              </div>
            </div>
        @endforeach

        <span class="block w-full bg-brand-darker rounded-full px-3 py-1 text-sm font-semibold text-brand-light mr-2">
            {{ __('Total') }}: {{ $cart->products->sum('cost') }} <i class="fa fa-tag"></i>
        </span>

        <button class="block w-full bg-transparent hover:bg-green text-green-dark font-semibold hover:text-white py-2 px-4 border border-green hover:border-transparent rounded">
            {{ __('Buy') }}
        </button>
    </div>
@endsection
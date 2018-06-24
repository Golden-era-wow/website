@extends('layouts.app')

@section('content')
	<shop-index inline-template>
		<div class="container text-center mb-4 mx-auto">
		  <input v-model="query" placeholder="Search for products">

		  <ais-index :app-id="algoliaAppId" :api-key="algoliaSearchKey" index-name="products" :query-parameters="{query: query}">
	        <ais-results class="flex sm:inline-flex md:block lg:hidden xl:flex flex-wrap">
	          <div slot="header" class="w-full">
	            <h2>{{ __('Products') }}</h2>
	            <ais-stats></ais-stats>

				<ais-sort-by-selector :indices="sortOptions">
				  <template slot-scope="{ indexName, label }">
				    <option :value="indexName">{{ __('Sort by') }}: @{{ label }}</option>
				  </template>
				</ais-sort-by-selector>
	          </div>

	          <hr class="divider"></hr>

	          <template slot-scope="{ result }">
				<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 mx-2 mb-4 rounded overflow-hidden shadow-lg">
				  <img class="w-full" :src="result.photo_url" alt="Product photo">
				  <div class="px-6 py-4">
				    <div class="font-bold text-xl mb-2">
				    	 <ais-highlight :result="result" attribute-name="name"/>
				    </div>
				    <h3 class="font-thin">
				    	 <ais-highlight :result="result" attribute-name="type"/>
				    </h3>
				    <p class="text-grey-darker text-base">
				       <ais-highlight :result="result" attribute-name="description"/>
				    </p>
				  </div>
				  	<!-- price tag badge -->
	                <span class="inline-block bg-brand-darker rounded-full px-3 py-1 text-sm font-semibold text-brand-light mr-2">
	                  @{{ result.cost }} <i class="fa fa-tag"></i>
	                </span>
				  <div class="px-6 py-4">
	                <button class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 border border-blue hover:border-transparent rounded" @click="$store.dispatch('addProduct', result)">
					  {{ __('Add to cart') }}
					</button>
				  </div>
				</div>
	          </template>
	        </ais-results>
		  </ais-index>

		  <ais-powered-by />
		</div>
	</shop-index>
@endsection
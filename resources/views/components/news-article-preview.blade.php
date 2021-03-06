  <div class="bg-white max-w-5xl mx-auto my-8 border border-grey-light rounded-t-lg overflow-hidden">
    <div class="flex flex-wrap no-underline text-black h-64 overflow-hidden">
        <img class="block pr-px w-full h-full" src="{{ $article->photo_url }}" alt=""
          style="object-fit: cover;">
    </div>
    <div class="px-2 pt-2 flex-grow">
      <a href="{{ $article->creator->link ?? '#' }}" class="block no-underline text-blue items-center hover:bg-grey-lighter">
        By <span class="font-medium">{{ $article->creator->name }}</span>
      </a>
      <small class="lead">{{ $article->created_at->format('d M Y') }}</small>
      <hr class="border-t border-grey-lighter"></hr>

      <article class="py-4 text-grey-darkest">
        <h3>{{ $article->title }}</h3>
        <p>{{ $article->summary }}</p>
      </article>

      <footer class="border-t border-grey-lighter text-sm flex">
        <a href="{{ $article->link }}" class="block no-underline text-blue flex px-4 py-2 items-center hover:bg-grey-lighter">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-link h-6 w-6 mr-1 stroke-current">

            <path d="M9.26 13a2 2 0 0 1 .01-2.01A3 3 0 0 0 9 5H5a3 3 0 0 0 0 6h.08a6.06 6.06 0 0 0 0 2H5A5 5 0 0 1 5 3h4a5 5 0 0 1 .26 10zm1.48-6a2 2 0 0 1-.01 2.01A3 3 0 0 0 11 15h4a3 3 0 0 0 0-6h-.08a6.06 6.06 0 0 0 0-2H15a5 5 0 0 1 0 10h-4a5 5 0 0 1-.26-10z"/>
          </svg>
          <span>Read more</span>
        </a>
      </footer>
    </div>
  </div>

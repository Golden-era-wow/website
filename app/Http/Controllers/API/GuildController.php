<?php

namespace App\Http\Controllers\API;

use App\Emulator;
use App\Filters\GuildApiFilters;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuildResource;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Rule;

class GuildController extends Controller
{
	public function index(GuildApiFilters $filters)
	{
		$this->validate(request(), [
			'emulator' => ['string', Rule::in(Emulator::supported())],
            'perPage' => 'nullable|integer|max:25',
            'columns' => 'nullable|array',
            'pageName' => 'nullable|string',
            'page' => 'nullable|integer',
		]);

		$filters->validate();

		$query = Emulator::driver(request('emulator'))->guilds();

		$filters->apply($query);

		$results = $query->paginate(
            request('perPage') ?? 10,
            request('columns') ?? ['*'],
            request('pageName') ?? 'page',
            request('page') ?? 0
		)->mapInto(Fluent::class);
		
		return GuildResource::collection($results);
	}
}

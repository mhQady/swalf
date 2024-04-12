<?php

namespace App\Http\Controllers\Dash;

use App\Models\Country;
use App\Enums\Country\HasMarketEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dash\CountryRequest;

class CountryController extends Controller
{
    public function index()
    {
        $this->authorize('browse country');

        $countries = Country::filter()->latest('id')->paginate(columns: ['id', 'code', 'phone_code', 'name', 'is_active', 'has_market', 'currency_code']);

        return view('dash.countries.index', compact('countries'));
    }

    public function create()
    {
        $this->authorize('add country');

        return view('dash.countries.create');
    }

    public function store(CountryRequest $request)
    {
        Country::create($request->validated());

        toast(__('main.created.country'), 'success');

        return to_route('dash.countries.index');
    }

    public function edit(Country $country)
    {
        return view('dash.countries.edit', compact('country'));
    }

    public function update(Country $country, CountryRequest $request)
    {
        $country->update($request->validated());

        toast(__('main.updated.country'), 'success');

        return to_route('dash.countries.index');
    }

    public function destroy(Country $country)
    {
        if ($country->hasMarket == HasMarketEnum::YES || $country->has('products')) {
            toast(__('messages.You can not delete This Country, it has products or has market'), 'warning');
            return back();
        }

        $country->delete();

        toast(__('main.deleted.country'), 'success');

        return to_route('dash.countries.index');
    }
}

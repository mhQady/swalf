<?php

namespace App\Http\Controllers\Dash;

use App\Models\City;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dash\CityRequest;

class CityController extends Controller
{
    public function index()
    {
        $this->authorize('browse city');

        $cities = City::filter()->latest('id')->with('state.country:id,name')->paginate(25);

        return view('dash.cities.index', compact('cities'));
    }

    public function create()
    {
        $this->authorize('add city');

        $countries = Country::whereHas('states')->get(['id', 'name']);

        return view('dash.cities.create', compact('countries'));
    }

    public function store(CityRequest $request)
    {
        City::create(['name' => $request->name, 'state_id' => $request->state_id]);

        toast(__('main.created.city'), 'success');

        return to_route('dash.cities.index');
    }

    public function edit(City $city)
    {
        $this->authorize('edit city');

        $city->load('state');

        $countries = Country::whereHas('states')->get(['id', 'name']);

        return view('dash.cities.edit', compact('countries', 'city'));
    }

    public function update(City $city, CityRequest $request)
    {
        $city->update(['name' => $request->name, 'state_id' => $request->state_id]);

        toast(__('main.updated.city'), 'success');

        return to_route('dash.cities.index');
    }

    public function destroy(City $city)
    {
        $this->authorize('delete city');

        if ($city->products()->exists()) {
            toast(__('messages.You can not delete This City, it has products'), 'warning');
            return back();
        }

        $city->delete();

        toast(__('main.deleted.city'), 'success');

        return to_route('dash.cities.index');
    }
}

<?php

namespace App\Http\Controllers\Dash;

use App\Models\Interest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dash\InterestRequest;

class InterestController extends Controller
{
    public function index()
    {
        $this->authorize('browse interest');

        $interests = Interest::filter()->latest()->withCount('products')->paginate(columns: ['id', 'name', 'created_at']);

        return view('dash.interests.index', compact('interests'));
    }

    public function create()
    {
        $this->authorize('add interest');

        return view('dash.interests.create');
    }

    public function store(InterestRequest $request)
    {
        try {
            $interest = Interest::create($request->validated());

            if ($request->hasFile('img'))
                uploadFiles($request->file('img'), Interest::MEDIA_COLLECTIONS[0], $interest);
        } catch (\Exception $e) {
            toast(__('messages.Error occurred, Please try again later'), 'error');
            return back();
        }

        toast(__('main.created.interest'), 'success');

        return to_route('dash.interests.index');
    }

    public function edit(Interest $interest)
    {
        $this->authorize('edit interest');

        return view('dash.interests.edit', compact('interest'));
    }

    public function update(Interest $interest, InterestRequest $request)
    {

        try {
            $interest->update($request->validated());

            if ($request->hasFile('img'))
                uploadFiles($request->file('img'), Interest::MEDIA_COLLECTIONS[0], $interest);

        } catch (\Exception $e) {
            toast(__('messages.Error occurred, Please try again later'), 'error');
            return back();
        }

        toast(__('main.updated.interest'), 'success');

        return to_route('dash.interests.index');
    }

    public function destroy(Interest $interest)
    {
        $this->authorize('delete interest');

        if ($interest->products()->exists()) {
            toast(__('messages.You can not delete This Interest, it has products'), 'warning');
            return back();
        }

        $interest->delete();

        toast(__('main.deleted.interest'), 'success');

        return to_route('dash.interests.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LabelController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth.forbid', except: ['index']),
        ];
    }

    public function index(): View
    {
        $labels = Label::all();

        return view('label.index', compact('labels'));
    }

    public function create(): View
    {
        $label = new Label();

        return view('label.create', compact('label'));
    }

    public function store(LabelRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        Label::create($validatedData);

        return redirect(route('labels.index'))
            ->with('success', __('flash.The tag created successfully'));
    }

    public function show(Label $label): void
    {
        abort(403, 'This action is unauthorized.');
    }

    public function edit(Label $label): View
    {
        return view('label.edit', compact('label'));
    }

    public function update(LabelRequest $request, Label $label): RedirectResponse
    {
        $label->update($request->validated());

        return redirect(route('labels.index'))
            ->with('success', __('flash.The tag has been successfully changed'));
    }

    public function destroy(Label $label): RedirectResponse
    {
        if ($label->tasks()->exists()) {
            return redirect(route('labels.index'))
                ->with('error', __("flash.Couldn't delete tag"));
        }

        $label->delete();

        return redirect(route('labels.index'))
            ->with('success', __('flash.The tag was successfully deleted'));
    }
}

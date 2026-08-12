<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function editTerms()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'terms-and-conditions'],
            ['title' => 'Terms & Conditions', 'content' => '<p>Default Terms & Conditions content...</p>']
        );
        return view('page.terms', compact('page'));
    }

    public function updateTerms(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        Page::updateOrCreate(
            ['slug' => 'terms-and-conditions'],
            [
                'title'   => $request->title,
                'content' => $request->content,
            ]
        );

        return back()->with('success', 'Terms & Conditions updated successfully.');
    }

    public function editPrivacy()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'privacy-policy'],
            ['title' => 'Privacy Policy', 'content' => '<p>Default Privacy Policy content...</p>']
        );
        return view('page.privacy', compact('page'));
    }

    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        Page::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title'   => $request->title,
                'content' => $request->content,
            ]
        );

        return back()->with('success', 'Privacy Policy updated successfully.');
    }
}

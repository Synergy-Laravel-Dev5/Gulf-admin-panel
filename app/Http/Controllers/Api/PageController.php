<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    /**
     * Get Terms & Conditions content.
     */
    public function termsAndConditions(): JsonResponse
    {
        $page = Page::where('slug', 'terms-and-conditions')->first();

        return response()->json([
            'status' => true,
            'data'   => [
                'title'   => $page->title ?? 'Terms & Conditions',
                'content' => $page->content ?? '',
            ]
        ]);
    }

    /**
     * Get Privacy Policy content.
     */
    public function privacyPolicy(): JsonResponse
    {
        $page = Page::where('slug', 'privacy-policy')->first();

        return response()->json([
            'status' => true,
            'data'   => [
                'title'   => $page->title ?? 'Privacy Policy',
                'content' => $page->content ?? '',
            ]
        ]);
    }
}

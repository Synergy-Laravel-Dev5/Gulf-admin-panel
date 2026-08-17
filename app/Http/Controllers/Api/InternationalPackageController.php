<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InternationalPackage;

class InternationalPackageController extends Controller
{
    public function index()
    {
        $packages = InternationalPackage::where(function ($q) {
            $q->whereRaw('LOWER(status) = ?', ['active'])
              ->orWhereNull('status')
              ->orWhere('status', '!=', 'inactive');
        })->latest()->get();

        foreach ($packages as $package) {
            $this->formatPackage($package);
        }

        return response()->json([
            'success' => true,
            'data'    => $packages,
        ]);
    }

    public function show($id)
    {
        $package = InternationalPackage::find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found',
            ], 404);
        }

        $this->formatPackage($package);

        return response()->json([
            'success' => true,
            'data'    => $package,
        ]);
    }

    private function formatPackage($package)
    {
        if ($package) {
            if ($package->image) {
                if (str_contains($package->image, '/')) {
                    $cleanPath = str_replace('storage/', '', $package->image);
                    $package->image = asset('uploads/' . $cleanPath);
                } else {
                    $package->image = asset('assets/images/packages/international/' . $package->image);
                }
            } else {
                $package->image = null;
            }
            $package->description = $this->cleanHtml($package->description);
            $package->features = $this->cleanHtml($package->features);
            $package->requirements = $this->cleanHtml($package->requirements);
        }
        return $package;
    }

    private function cleanHtml($text)
    {
        if (!$text) return '';
        
        // Replace list items with bullets and newlines
        $text = str_ireplace(['<li>', '</li>'], ["\n• ", "\n"], $text);
        
        // Convert block/inline-break elements to newlines to prevent words from sticking together
        $text = str_ireplace(
            ['<p>', '</p>', '<br>', '<br />', '</div>', '</td>', '</tr>', '<ul>', '</ul>', '<ol>', '</ol>'], 
            ["\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n"], 
            $text
        );
        
        $text = strip_tags($text);
        
        // Recursive decode to resolve multiple encodings (e.g. &amp;amp; -> &amp; -> &)
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        
        // Merge duplicate newlines
        $text = preg_replace("/\n+/", "\n", $text);
        
        return trim($text);
    }
}
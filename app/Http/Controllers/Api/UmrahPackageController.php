<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UmrahPackage;

class UmrahPackageController extends Controller
{
    public function index()
    {
        $packages = UmrahPackage::latest()->get();

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
        $package = UmrahPackage::find($id);

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
                    $package->image = asset('storage/' . $package->image);
                } else {
                    $package->image = asset('assets/images/packages/umrah/' . $package->image);
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
        
        $text = str_ireplace(['<li>', '</li>'], ["\n• ", "\n"], $text);
        
        $text = str_ireplace(
            ['<p>', '</p>', '<br>', '<br />', '</div>', '</td>', '</tr>', '<ul>', '</ul>', '<ol>', '</ol>'], 
            ["\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n", "\n"], 
            $text
        );
        
        $text = strip_tags($text);
        
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        
        $text = preg_replace("/\n+/", "\n", $text);
        
        return trim($text);
    }
}

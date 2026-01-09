<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('settings.settings');
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        // Settings update logic can be added here

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}

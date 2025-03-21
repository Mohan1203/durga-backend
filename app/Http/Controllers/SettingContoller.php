<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Settings::first();
        return view('admin.settings', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'years_experience' => 'nullable|integer',
            'global_partners' => 'nullable|integer',
            'products_count' => 'nullable|integer',
            'state_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = Settings::first() ?? new Settings();

        // Handle file uploads
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && file_exists(public_path($settings->logo))) {
                unlink(public_path($settings->logo));
            }
            $imageName = 'logo_' . time() . '.' . $request->logo->extension();
            $request->logo->move(public_path("images"), $imageName);
            $settings->logo = 'images/' . $imageName;
        }

        if ($request->hasFile('state_image')) {
            // Delete old state image if exists
            if ($settings->state_image && file_exists(public_path($settings->state_image))) {
                unlink(public_path($settings->state_image));
            }
            $imageName = 'state_' . time() . '.' . $request->state_image->extension();
            $request->state_image->move(public_path("images"), $imageName);
            $settings->state_image = 'images/' . $imageName;
        }

        // Update other fields
        $settings->years_experience = $request->years_experience;
        $settings->global_partners = $request->global_partners;
        $settings->products_count = $request->products_count;
        
        $settings->save();

        return redirect()->back()->with('success', 'Company information updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $setting)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $settings = Settings::first() ?? new Settings();

        if ($id == 1) {
            // Contact Information Update
            $request->validate([
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:100',
                'address' => 'nullable|string|max:500',
            ]);

            $settings->phone = $request->phone;
            $settings->email = $request->email;
            $settings->address = $request->address;
            
            $settings->save();
            return redirect()->back()->with('success', 'Contact information updated successfully!');
        } 
        elseif ($id == 2) {
            // Social Media Update
            $request->validate([
                'facebook' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'youtube' => 'nullable|url|max:255',
            ]);

            $settings->facebook = $request->facebook;
            $settings->twitter = $request->twitter;
            $settings->linkedin = $request->linkedin;
            $settings->instagram = $request->instagram;
            $settings->youtube = $request->youtube;
            
            $settings->save();
            return redirect()->back()->with('success', 'Social media links updated successfully!');
        }

        return redirect()->back()->with('error', 'Invalid update request');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $setting)
    {
        try {
            if ($setting->logo && file_exists(public_path($setting->logo))) {
                unlink(public_path($setting->logo));
            }
            if ($setting->state_image && file_exists(public_path($setting->state_image))) {
                unlink(public_path($setting->state_image));
            }
            $setting->delete();
            return response()->json(['success' => true, 'message' => 'Setting deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting setting'], 500);
        }
    }
}
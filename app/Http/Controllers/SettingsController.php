<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Code;
use App\Models\Location;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() {
        return view('settings.index');
    }

    public function codes() {
        return view('settings.codes', [
            'codes' => Code::all()
        ]);
    }

    public function codesStore(Request $request) {
        $validation = $request->validate([
            'value' => 'required'
        ]);
        
        Code::create($validation);

        return redirect('/settings/codes')->with('success', 'Code succesfully added.');
    }

    public function codesDestroy(Code $code) {
        $code->delete();
        return redirect('/settings/codes')->with('success', 'Code deleted succesfully');
    }

    public function accessories() {
        return view('settings.accessories', [
            'accessories' => Accessory::all()
        ]);
    }

    public function accessoriesStore(Request $request) {
        $validation = $request->validate([
            'value' => 'required'
        ]);
        
        Accessory::create($validation);

        return redirect('/settings/accessories')->with('success', 'Accessory succesfully added.');
    }

    public function accessoriesDestroy(Accessory $accessory) {
        $accessory->delete();
        return redirect('/settings/accessories')->with('success', 'Accessory deleted succesfully');
    }

    public function locations() {
        return view('settings.locations', [
            'locations' => Location::all()
        ]);
    }

    public function locationsStore(Request $request) {
        $validation = $request->validate([
            'value' => 'required'
        ]);
        
        Location::create($validation);

        return redirect('/settings/locations')->with('success', 'Location succesfully added.');
    }

    public function locationsDestroy(Location $location) {
        $location->delete();
        return redirect('/settings/locations')->with('success', 'Location deleted succesfully');
    }
}

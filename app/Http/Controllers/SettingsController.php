<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Accommodation;
use App\Models\BikeColor;
use App\Models\BikeRack;
use App\Models\Code;
use App\Models\DashboardAutomation;
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

    public function colors() {
        return view('settings.colors', [
            'colors' => BikeColor::all()
        ]);
    }

    public function colorsStore(Request $request) {
        $validation = $request->validate([
            'value' => 'required'
        ]);
        
        BikeColor::create($validation);

        return redirect('/settings/colors')->with('success', 'Color succesfully added.');
    }

    public function colorsDestroy(BikeColor $color) {
        $color->delete();
        return redirect('/settings/colors')->with('success', 'Color deleted succesfully');
    }

    public function racks() {
        return view('settings.racks', [
            'racks' => BikeRack::all()
        ]);
    }

    public function racksStore(Request $request) {
        $validation = $request->validate([
            'value' => 'required'
        ]);
        
        BikeRack::create($validation);

        return redirect('/settings/racks')->with('success', 'Rack succesfully added.');
    }

    public function racksDestroy(BikeRack $rack) {
        $rack->delete();
        return redirect('/settings/racks')->with('success', 'Rack deleted succesfully');
    }

    public function accommodations() {
        return view('settings.accommodations', [
            'accommodations' => Accommodation::all()
        ]);
    }

    public function accommodationsStore(Request $request) {
        $validation = $request->validate([
            'value' => 'required'
        ]);
        
        Accommodation::create($validation);

        return redirect('/settings/accommodations')->with('success', 'Accommodation succesfully added.');
    }

    public function accommodationsDestroy(Accommodation $accommodation) {
        $accommodation->delete();
        return redirect('/settings/accommodations')->with('success', 'Accommodation deleted succesfully');
    }

    public function automation() {
        $settingAutomation = DashboardAutomation::where('id',1)->first();
        $settingSms = DashboardAutomation::where('id', 2)->first();

        return view('settings.automation', [
            'enabledAuto' => $settingAutomation->enabled,
            'enabledSms' => $settingSms->enabled
        ]);
    }

    public function automationEdit(Request $request) {
        $setting = DashboardAutomation::where('id',1)->first();
        $smsSetting = DashboardAutomation::where('id',2)->first();

        if($request->auto_enabled) {
            $setting->enabled = 1;
            $smsSetting->enabled = 1;

            $smsSetting->save();
            $setting->save();
            $result = "enabled";
        } else {
            $setting->enabled = 0;
            $setting->save();
            $result = "disabled";
        }

        return back();
    }

    public function smsEdit(Request $request) {
        $automationSetting = DashboardAutomation::where('id',1)->first();
        $setting = DashboardAutomation::where('id',2)->first();

        if($request->auto_enabled) {
            $setting->enabled = 1;
            $setting->save();
            $result = "enabled";
        } else {
            $setting->enabled = 0;
            $automationSetting->enabled = 0;

            $setting->save();
            $automationSetting->save();
            $result = "disabled";
        }

        return back();
    }
}

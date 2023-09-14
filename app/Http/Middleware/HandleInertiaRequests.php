<?php

namespace App\Http\Middleware;

// use App\Models\College;
// use App\Models\Course;
use App\Models\ListPrivilege;
use App\Models\Setting;
use App\Models\ListProgram;
use App\Models\ListDropdown;
use App\Models\ListAgency;
use App\Models\ListStatus;
use App\Models\ListExpense;
use App\Models\LocationRegion;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Http\Resources\Staff\IndexResource as StaffResource;
use App\Http\Resources\SettingResource;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $expenditures = ListDropdown::where('classification','Expenditure')->get();
        $lists = [];
        foreach($expenditures as $expenditure){
            $expenses = ListExpense::where('expenditure_id',$expenditure->id)->get();
            $lists[] = [
                'language' => $expenditure->name,
                'libs' => $expenses
            ];
        }

        $settings = Setting::with('agency.region')->first();
        $region_code = ($settings)? $settings->agency->region_code : NULL;
        $semester_year = ($settings)? $settings->year : NULL;
 
        return array_merge(parent::share($request), [
            'auth' => (\Auth::check()) ? new StaffResource(\Auth::user()) : '',
            'role' => (\Auth::check()) ? \Auth::user()->role : '',
            'flash' => [
                'message' => session('message'),
                'data' => session('data'),
                'type' => session('type'),
                'color' => session('color')
            ],
            'regions' => LocationRegion::all(),
            'dropdowns' => ListDropdown::all(),
            'programs' => ListProgram::all(),
            'expenses' => $lists,
            'statuses' => ListStatus::all(),
            'privileges' => ListPrivilege::all(),
            'agencies' => ListAgency::all(),
            'region_code' => $region_code,
            'semester_year' => $semester_year,
            'settings' => ($settings) ? new SettingResource($settings) : null
        ]);
    }
}

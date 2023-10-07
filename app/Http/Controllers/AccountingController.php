<?php

namespace App\Http\Controllers;

use App\Models\ListExpense;
use App\Models\ListDropdown;
use App\Models\AccountingBalance;
use App\Models\AccountingReports;
use App\Models\AccountingAllotment;
use App\Models\AccountingAllotmentList;
use App\Models\AccountingDisbursement;
use App\Models\AccountingRealignment;
use Illuminate\Http\Request;
use App\Http\Requests\AllotmentRequest;
use App\Http\Resources\Accounting\AllotmentResource;
use App\Http\Resources\Accounting\DisbursementResource;
use App\Http\Resources\Accounting\SuballotmentResource;
use App\Http\Resources\Accounting\ExpenseResource;
use App\Http\Resources\Accounting\RealignResource;

class AccountingController extends Controller
{
    public $year, $quarter, $range, $report_id;

    public function __construct()
    {
        $report =  AccountingReports::latest()->first();
        switch(date('m')){
            case 1: case 2: case 3:
                $quarter = 1;
                $range = [1,2,3];
            break;
            case 4: case 5: case 6:
                $quarter = 2;
                $range = [4,5,6];
            break;
            case 7: case 8: case 9:
                $quarter = 3;
                $range = [7,8,9];
            break;
            case 10: case 11: case 12:
                $quarter = 4;
                $range = [10,11,12];
            break;
        }

        $this->year = date('Y');
        $this->quarter = $quarter;
        $this->range = $range;
        $this->report_id = ($report) ? $report->id : '';
    }

    public function index(Request $request){
        $type = $request->type;
        switch($type){
            case 'reports':
                return $this->reports($request);
            break;
            case 'breakdowns':
                return $this->breakdowns($request);
            break;
            case 'expenses':
                return $this->expenses($request);
            break;
            case 'allotments':
                return $this->allotments($request);
            break;
            case 'disbursements':
                return $this->disbursements($request);
            break;
            case 'realignments':
                return $this->realignments($request);
            break;
            default : 
            $this->check();
            // if($this->quarter == 1){
            //     $year = $this->year - 1;
            //     $quarter = 4; 
            // }else{
            //     $year = $this->year;
            //     $quarter = $this->quarter - 1;
            // }
            return inertia('Modules/Accounting/Index', [
                'latest' => AccountingReports::latest()->first(),
                'old' => AccountingReports::orderBy('created_at', 'desc')->skip(1)->take(1)->first()
                // AccountingReports::where('year',$year)->where('quarter',$quarter)->first()
            ]);
        }
    }

    public function show($type){
        switch($type){
            case 'allotments':
                return inertia('Modules/Accounting/Allotment/Index');
            break;
            case 'disbursements':
                return inertia('Modules/Accounting/Disbursement/Index');
            break;
            case 'expenses':
                return inertia('Modules/Accounting/Expense/Index');
            break;
            case 'realignments':
                return inertia('Modules/Accounting/Realignment/Index');
            break;
            case 'breakdown':
                return $this->print('breakdown');
            break; 
        }
    }

    public function store(AllotmentRequest $request){
        $type = $request->type;
        $this->check();
        if($type == 'allotment'){
            $data = \DB::transaction(function () use ($request){
                $code = 'DOST-'.AccountingAllotment::count()+1;
                $data = AccountingAllotment::create(array_merge($request->all(),['code' => $code, 'added_by' => \Auth::user()->id, 'report_id' => $this->report_id]));
                return $data;
            });

            return back()->with([
                'message' => 'Allotment added successfully. Thanks',
                'data' =>  $data,
                'type' => 'bxs-check-circle'
            ]); 
        }else if($type == 'suballotment'){
            $data = \DB::transaction(function () use ($request){
                $data = AccountingAllotmentList::create(array_merge($request->all(),['added_by' => \Auth::user()->id]));
                if($data){
                    $expense = ListExpense::where('id',$request->expense_id)->first();
                    $expense->amount = $expense->amount + trim(str_replace(',','',$request->amount),'₱ ');
                    $expense->save();

                    if($expense){
                        $report = AccountingReports::latest()->first();
                        $report->balance = $report->balance + trim(str_replace(',','',$request->amount),'₱ ');
                        $report->save();
                        if($report){
                            $balance = AccountingBalance::where('report_id',$report->id)->where('expense_id',$request->expense_id)->first();
                            if($balance != null){
                                $balance->amount = $balance->amount + trim(str_replace(',','',$request->amount),'₱ ');
                            }else{
                                $balance = new AccountingBalance;
                                $balance->amount = $expense->amount;
                                $balance->report_id = $report->id;
                                $balance->expense_id = $request->expense_id;
                                $balance->save();
                            }
                        }
                    }
                }
                $data = AccountingAllotmentList::with('user.profile','expense')->where('id',$data->id)->first();
                return $data;
            });

            return back()->with([
                'message' => 'SubAllotment added successfully. Thanks',
                'data' =>  $data,
                'type' => 'bxs-check-circle'
            ]); 
        }else if($type == 'expense'){
            $data = \DB::transaction(function () use ($request){
                $data = ListExpense::create($request->all());
                $data = ListExpense::with('expenditure')->where('id',$data->id)->first();
                $this->check();
                return $data;
            });

            return back()->with([
                'message' => 'Expense Class added successfully. Thanks',
                'data' =>  $data,
                'type' => 'bxs-check-circle'
            ]); 
        }else if($type == 'realignment'){
            $data = \DB::transaction(function () use ($request){
                $data = AccountingRealignment::create(array_merge($request->all(),['added_by' => \Auth::user()->id,'attachment' => json_encode([])]));
                if($data){
                    $expense = ListExpense::where('id',$request->receiver_class)->first();
                    $expense->balance = $expense->balance + trim(str_replace(',','',$request->amount),'₱ ');
                    $expense->save();

                    if($expense){
                        $report = AccountingReports::latest()->first();
                        $report->balance = $report->balance + trim(str_replace(',','',$request->amount),'₱ ');
                        $report->save();
                        if($report){
                            $balance = AccountingBalance::where('report_id',$report->id)->where('expense_id',$request->receiver_class)->first();
                            if($balance != null){
                                $balance->amount = $balance->amount + trim(str_replace(',','',$request->amount),'₱ ');
                                $balance->save();
                            }else{
                                $balance = new AccountingBalance;
                                $balance->amount = $expense->balance;
                                $balance->report_id = $report->id;
                                $balance->expense_id = $request->receiver_class;
                                $balance->save();
                            }
                        }
                    }

                    $expense = ListExpense::where('id',$request->sender_class)->first();
                    $expense->balance = $expense->balance - trim(str_replace(',','',$request->amount),'₱ ');
                    $expense->save();

                    if($expense){
                        $report = AccountingReports::latest()->first();
                        $report->balance = $report->balance - trim(str_replace(',','',$request->amount),'₱ ');
                        $report->save();
                        if($report){
                            $balance = AccountingBalance::where('report_id',$report->id)->where('expense_id',$request->sender_class)->first();
                            if($balance != null){
                                $balance->amount = $balance->amount - trim(str_replace(',','',$request->amount),'₱ ');
                                $balance->save();
                            }else{
                                $balance = new AccountingBalance;
                                $balance->amount = $expense->balance;
                                $balance->report_id = $report->id;
                                $balance->expense_id = $request->sender_class;
                                $balance->save();
                            }
                        }
                    }
                }
                return $data;
            });

            return back()->with([
                'message' => 'Realignment Class added successfully. Thanks',
                'data' =>  $data,
                'type' => 'bxs-check-circle'
            ]); 
        }else{
            $data = \DB::transaction(function () use ($request){
                $data = AccountingDisbursement::create(array_merge($request->all(),['added_by' => \Auth::user()->id, 'report_id' => $this->report_id]));
                if($data){
                    $expense = ListExpense::where('id',$request->expense_id)->first();
                    $expense->amount = $expense->amount - trim(str_replace(',','',$request->amount),'₱ ');
                    $expense->save();

                    if($expense){
                        $report = AccountingReports::latest()->first();
                        $report->balance = $report->balance - trim(str_replace(',','',$request->amount),'₱ ');
                        $report->save();

                        if($report){
                            $balance = AccountingBalance::where('report_id',$report->id)->where('expense_id',$request->expense_id)->first();
                            if($balance != null){
                                $balance->amount = $balance->amount - trim(str_replace(',','',$request->amount),'₱ ');
                                $balance->save();
                            }else{
                                $balance = new AccountingBalance;
                                $balance->amount = $expense->amount;
                                $balance->report_id = $report->id;
                                $balance->expense_id = $request->receiver_class;
                                $balance->save();
                            }
                        }
                    }
                }
                return $data;
            });

            return back()->with([
                'message' => 'Disbursement added successfully. Thanks',
                'data' =>  $data,
                'type' => 'bxs-check-circle'
            ]); 
        }
    }

    public function expenses($request){
        $data = ExpenseResource::collection(
            ListExpense::with('expenditure')
            ->withSum('allotments', 'amount')
            ->withSum('disbursements', 'amount')
            ->withSum('add', 'amount')
            ->withSum('minus', 'amount')
            ->orderBy('created_at','DESC')
            ->paginate($request->counts)
            ->withQueryString()
        );
        return $data;
    }

    public function allotments($request){
        $data = AllotmentResource::collection(
            AccountingAllotment::with('lists','user.profile')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('check_no', 'LIKE', '%'.$keyword.'%');
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->counts)
            ->withQueryString()
        );
        return $data;
    }

    public function disbursements($request){
        $data = DisbursementResource::collection(
            AccountingDisbursement::with('expense','user.profile')
            ->orderBy('created_at','DESC')
            ->paginate($request->counts)
            ->withQueryString()
        );
        return $data;
    }

    public function realignments($request){
        $data = RealignResource::collection(
            AccountingRealignment::with('receiver','sender','user.profile')
            ->orderBy('created_at','DESC')
            ->paginate($request->counts)
            ->withQueryString()
        );
        return $data;
    }

    public function check(){
        $data = AccountingReports::where('year',$this->year)->where('quarter',$this->quarter)->count();
        if($data == 0){
            $old = AccountingReports::latest()->first();
            $count = AccountingReports::count();
            $report = new AccountingReports;
            $report->code = date('Ymd').'-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT);  
            $report->year = $this->year;
            $report->quarter = $this->quarter;
            $report->balance = ($old) ? $old->balance : 0;
            $report->save();
            if($report){
                $this->balances($report->id);
            }
        }else{
            $report = AccountingReports::latest()->first();
            if($report){
                $this->balances($report->id);
            }
        }
    }

    public function balances($report_id){
        $expenses = ListExpense::where('amount','!=',0)->get();
        foreach($expenses as $expense){
            $check = AccountingBalance::where('report_id',$report_id)->where('expense_id',$expense->id)->count();
            if($check == 0){
                $balance = new AccountingBalance;
                $balance->expense_id = $expense->id;
                $balance->report_id = $report_id;
                $balance->amount = $expense->balance;
                $balance->save();
            }
        }
    }

    public function reports(){
        $allotments = AccountingAllotment::withSum('lists', 'amount')->where('report_id',$this->report_id)->get();
        // $total_a = AccountingAllotmentList::whereYear('created_at',$this->year)->whereIn(\DB::raw('MONTH(created_at)'), $this->range)->sum('amount');
        // $total_d = AccountingDisbursement::whereYear('created_at',$this->year)->whereIn(\DB::raw('MONTH(created_at)'), $this->range)->sum('amount');
        $total_a = AccountingAllotmentList::whereHas('allotment',function ($query){
            $query->where('report_id',$this->report_id);
        })->sum('amount');
        $total_d = AccountingDisbursement::where('report_id',$this->report_id)->sum('amount');
        $array = [
            'allotments' => $allotments, 
            'total_disbursement' => $total_d,
            'total_allotment' => $total_a,
        ];
        return $array;
    }

    public function breakdowns(){
        $old = AccountingReports::orderBy('created_at', 'desc')->skip(1)->take(1)->first();
        $report_id = $this->report_id;
        $expenditures = ListDropdown::where('classification','Expenditure')->get();
        foreach($expenditures as $expenditure){
            $lists = [];

            $expenses = ListExpense::where('expenditure_id',$expenditure->id)->where('is_active',1)
            ->withSum(['balances' => fn ($query) => 
                $query->select(\DB::raw('COALESCE(SUM(amount), 0)'))->where('report_id',($old) ? $old->id : null)
            ],'amount')
            ->withSum(['disbursements' => fn ($query) => 
                $query->select(\DB::raw('COALESCE(SUM(amount), 0)'))->where('report_id',$report_id)
            ],'amount')
            ->withSum(['allotments' => fn ($query) => 
                $query->whereHas('allotment',function ($query) use ($report_id){
                    $query->where('report_id',$report_id);
                })->select(\DB::raw('COALESCE(SUM(amount), 0)'))
            ],'amount')
            ->get();
            
            $container[] = [
                'name' => $expenditure->name,
                'unexpended' => '0.00',
                'release' => '0.00',
                'disbursement' => '0.00',
                'balance' => '0.00',
                'list' => $expenses
            ];
        }
       
        return $container;
    }

    public function edit($type){
        if($type == 'breakdown'){
            
            $val = AccountingReports::orderBy('created_at', 'desc')->latest()->first();
            if($val->quarter == 1){
                $info = 'January 1 to March 31, 2013';
            }else if($val->quarter == 2){
                $info = 'April 1 to June 30, 2013';
            }else if($val->quarter == 3){
                $info = 'July 1 to September 30, 2013';
            }else{
                $info = 'October 1 to December 31, 2013';
            }

            $array = [
                'lists' => $this->breakdowns(),
                'info' => $info
            ];
            $pdf = \PDF::loadView('Printing.FinancialReport.breakdown',$array)->setPaper('a4', 'portrait');
            return $pdf->download('FinancialReportBreakdown.pdf');
        }else{
            $array = [
                'lists' => ''
            ];
            $pdf = \PDF::loadView('Printing.FinancialReport.main',$array)->setPaper('a4', 'landscape');
            return $pdf->download('FinancialReport.pdf');
        }
    }
}

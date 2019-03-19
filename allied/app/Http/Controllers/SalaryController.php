<?php

namespace App\Http\Controllers;
use App\Salary;
use App\employee;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function viewSalaryByMonth(Request $request){
        if($request->isMethod('post')){
            $month = $request->input('month'). "-01";
            $salary = Salary::where('month', $month)->get();
            return view('Salary.viewByMonth',compact('salary'));
        }

        return view('Salary.selectMonth');
        
    }
    public function viewSalaryByPerson($id){
        $salary = Salary::where('employee_id', $id)->get();
        return view('Salary.viewByPerson',compact('salary'));
    }

    public function addSalary(Request $request){

        if($request->isMethod('post')){
            $employees = employee::all();
            $month = $request->input('month');
            foreach ($employees as $employee) {
                $constant = $employee->salary_constant;
                $change = $employee->salary_change;
                $allowances = $employee->salary_allowances;
                $rewards = $employee->rewards;
                $sumSalaryForMonth = $constant + $change + $allowances + $rewards;
                $id = $employee->id;
                $insurance_type = $employee->insurance; // 1
                $taxes_type = $employee->taxes;         // 1
                $insurance_emp = 0;
                $insurance_camp = 0;
                if($insurance_type == 1){
                    $insurance_emp_constant = $constant * 0.14;
                    $insurance_emp_change = $change * 0.11;
                    $insurance_emp = $insurance_emp_constant + $insurance_emp_change;
                    $insurance_camp_constant = $constant * 0.26;
                    $insurance_camp_change = $change * 0.24;
                    $insurance_camp = $insurance_camp_constant + $insurance_camp_change;
                }
                $taxes = 0;
                $sumSalary = $sumSalaryForMonth * 12;
                $cost = $insurance_emp * 12;
                $total = ($sumSalary - $cost) - 14300;
                if ($taxes_type == 1) {
                    if($total < 1){
                    $taxes = 0;
                    }
                    elseif ($total <= 23500) {
                        $taxes = $total * 0.1;
                    }
                    elseif ($total > 23500 && $total <= 38500) {
                        $taxes = 2350 + ($total - 23500) * 0.15*.85;
                    } 
                    elseif ($total > 38500 && $total <= 193500) {
                        $taxes = 4600 + ($total - 38500) * 0.2*.45;
                    }
                    elseif ($total > 193500) {
                        $taxes = 35600 + ($total - 193500) * 0.225*.075;
                    }
                }
                if($taxes > 0){
                    $taxes = $taxes/12;
                }
                $net = $sumSalaryForMonth - $insurance_emp - $taxes;

                $newSalary = new Salary();
                $newSalary->constant = $constant;
                $newSalary->change = $change;
                $newSalary->allowances = $allowances;
                $newSalary->rewards = $rewards;
                $newSalary->insurance_emp = $insurance_emp;
                $newSalary->insurance_camp = $insurance_camp;
                $newSalary->taxes = $taxes;
                $newSalary->net = $net;
                $newSalary->month = $month . "-01";
                $newSalary->employee_id = $id;
                $newSalary->save();

            }

            $salary = Salary::all();
            return view('Salary.viewByMonth',compact('salary'));
            
        }
        return view('Salary.roll');
    }
}

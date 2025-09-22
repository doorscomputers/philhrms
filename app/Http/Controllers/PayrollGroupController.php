<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayrollGroupRequest;
use App\Http\Requests\UpdatePayrollGroupRequest;
use App\Models\Company;
use App\Models\PayrollGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayrollGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = PayrollGroup::with('company')->latest();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('pay_frequency')) {
            $query->where('pay_frequency', $request->get('pay_frequency'));
        }

        $payrollGroups = $query->paginate(15);

        return view('payroll-groups.index', compact('payrollGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::all();

        return view('payroll-groups.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayrollGroupRequest $request): RedirectResponse
    {
        PayrollGroup::create($request->validated());

        return redirect()->route('payroll-groups.index')
            ->with('success', 'Payroll group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PayrollGroup $payrollGroup): View
    {
        $payrollGroup->load('company');

        return view('payroll-groups.show', compact('payrollGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PayrollGroup $payrollGroup): View
    {
        $companies = Company::all();

        return view('payroll-groups.edit', compact('payrollGroup', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayrollGroupRequest $request, PayrollGroup $payrollGroup): RedirectResponse
    {
        $payrollGroup->update($request->validated());

        return redirect()->route('payroll-groups.index')
            ->with('success', 'Payroll group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayrollGroup $payrollGroup): RedirectResponse
    {
        $payrollGroup->delete();

        return redirect()->route('payroll-groups.index')
            ->with('success', 'Payroll group deleted successfully.');
    }
}

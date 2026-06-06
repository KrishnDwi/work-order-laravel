<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\IssueType;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // ============ DEPARTMENTS ============
    
    public function departmentIndex()
    {
        $departments = Department::all();
        return view('admin-departments', compact('departments'));
    }

    public function departmentStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return redirect('/admin/settings/departments')->with('success', 'Department added successfully.');
    }

    public function departmentUpdate(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $department->update($validated);

        return redirect('/admin/settings/departments')->with('success', 'Department updated successfully.');
    }

    public function departmentDelete($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect('/admin/settings/departments')->with('success', 'Department deleted successfully.');
    }

    // ============ ISSUE TYPES ============
    
    public function issueTypeIndex()
    {
        $issueTypes = IssueType::all();
        return view('admin-issue-types', compact('issueTypes'));
    }

    public function issueTypeStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:issue_types,name',
            'description' => 'nullable|string',
        ]);

        IssueType::create($validated);

        return redirect('/admin/settings/issue-types')->with('success', 'Issue type added successfully.');
    }

    public function issueTypeUpdate(Request $request, $id)
    {
        $issueType = IssueType::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:issue_types,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $issueType->update($validated);

        return redirect('/admin/settings/issue-types')->with('success', 'Issue type updated successfully.');
    }

    public function issueTypeDelete($id)
    {
        $issueType = IssueType::findOrFail($id);
        $issueType->delete();

        return redirect('/admin/settings/issue-types')->with('success', 'Issue type deleted successfully.');
    }
}

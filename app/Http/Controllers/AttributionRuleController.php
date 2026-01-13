<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AttributionRule;
use App\Models\User;

class AttributionRuleController extends Controller
{
    public function index()
    {
        $rules = AttributionRule::orderByDesc('priority')->get();
        $users = User::whereIn('role', ['commercial', 'admin'])->orderBy('name')->get();
        return view('admin.attribution_rules.index', compact('rules', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'criteria_type' => 'required|in:source,amount_gt,sector,workload',
            'criteria_value' => 'nullable|string', // required unless workload
            'target_user_id' => 'nullable|exists:users,id', // nullable for workload balancing
            'priority' => 'required|integer',
        ]);

        AttributionRule::create($validated);

        return redirect()->route('admin.attribution-rules.index')->with('success', 'Règle créée.');
    }

    public function destroy(AttributionRule $attributionRule)
    {
        $attributionRule->delete();
        return redirect()->route('admin.attribution-rules.index')->with('success', 'Règle supprimée.');
    }
}

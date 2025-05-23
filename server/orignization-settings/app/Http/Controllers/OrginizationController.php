<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositionModel;
class OrginizationController extends Controller
{
    //
    public function all()
    {
        $positions = PositionModel::all();

        return response()->json($positions);
    }

    public function createPosition(Request $request)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:50',
            'report_id' => 'nullable|exists:reports,id',
        ]);

        $exists = PositionModel::where('position_name', $validated['position_name'])
            ->where('reports_id', $validated['reports_id'] ?? null)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Position with this name already exists for the given report.',
            ], 409);
        }

        $position = PositionModel::create([
            'position_name' => $validated['position_name'],
            'report_id' => $validated['reports_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'position' => $position,
        ]);
    }

    public function getPositionById($id)
    {
        $position = PositionModel::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Position not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'position' => $position,
        ]);
    }

    public function removePosition($id)
    {
        $position = PositionModel::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Position not found.',
            ], 404);
        }

        $position->delete();

        return response()->json([
            'success' => true,
            'message' => 'Position deleted successfully.',
        ]);
    }

    public function updatePosition(Request $request, $id)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:50',
            'reports_id' => 'required|exists:reports,id', 
        ]);

        $position = PositionModel::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Position not found.',
            ], 404);
        }

        $duplicate = PositionModel::where('position_name', $validated['position_name'])
            ->where('reports_id', $validated['reports_id'])
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'A position with this name already exists under the selected report.',
            ], 409);
        }

        $position->update([
            'position_name' => $validated['position_name'],
            'reports_id' => $validated['reports_id'],
        ]);

        return response()->json([
            'success' => true,
            'position' => $position,
        ]);
    }

}

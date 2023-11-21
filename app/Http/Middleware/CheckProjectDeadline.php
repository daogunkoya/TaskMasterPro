<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckProjectDeadline
{
    public function handle(Request $request, Closure $next)
    {
        $projectId = $request->route('id'); // Assuming project ID is in the route parameters
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        $currentDateTime = Carbon::now();
        $deadline = Carbon::parse($project->deadline);

        if ($currentDateTime > $deadline) {
            $project->status = 'completed';
            $project->save();

            return response()->json(['message' => 'Project marked as completed due to passed deadline'], 200);
        }

        return $next($request);
    }
}

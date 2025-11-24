<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportJobController extends Controller
{
    public function index()
    {
        $jobs = DB::table('import_jobs')->orderBy('created_at','desc')->paginate(20);
        return view('import.jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = DB::table('import_jobs')->where('id',$id)->first();
        if (! $job) abort(404);
        $job->summary = json_decode($job->summary, true);
        $job->errors = json_decode($job->errors, true);
        return view('import.jobs.show', compact('job'));
    }

    public function downloadErrors($id)
    {
        $job = DB::table('import_jobs')->where('id',$id)->first();
        if (! $job) abort(404);
        $errors = $job->errors ?: '[]';
        return response($errors, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="import_errors_'. $id .'.json"'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    /**
     * Display a listing of logs.
     */
    public function index(Request $request)
    {
        $query = Log::with(['user', 'loan.item'])
            ->orderBy('created_at', 'desc');
        
        // Filter berdasarkan tipe log
        if ($request->has('type') && $request->type != '') {
            $query->where('action_type', $request->type);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }
        
        $logs = $query->paginate(20);
        
        // Gunakan view 'log' (sesuai dengan struktur file Anda)
        return view('log', compact('logs'));
    }
    
    /**
     * Store a newly created log in storage.
     */
    public function store(Request $request)
    {
        $log = Log::create([
            'user_id' => Auth::id(),
            'loan_id' => $request->loan_id,
            'action_type' => $request->action_type,
            'description' => $request->description,
            'details' => $request->details,
        ]);
        
        return response()->json($log, 201);
    }
    
    /**
     * Update the specified log in storage.
     */
    public function update(Request $request, $id)
    {
        $log = Log::findOrFail($id);
        
        $log->update([
            'description' => $request->description,
            'details' => $request->details,
        ]);
        
        return redirect()->route('logs')->with('success', 'Log berhasil diperbarui!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $log = Log::findOrFail($id);
        $log->delete();
        
        return redirect()->route('logs')->with('success', 'Log berhasil dihapus!');
    }
    
    /**
     * Display user's own logs.
     */
    public function userLogs(Request $request)
    {
        $logs = Log::with(['loan.item'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('my-logs', compact('logs'));
    }
    
    /**
     * Create log record helper method.
     */
    public static function createLog($userId, $loanId, $actionType, $description, $details = null)
    {
        return Log::create([
            'user_id' => $userId,
            'loan_id' => $loanId,
            'action_type' => $actionType,
            'description' => $description,
            'details' => $details,
        ]);
    }
}
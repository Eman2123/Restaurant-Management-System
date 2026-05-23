<?php
namespace App\Http\Controllers\Admin;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::withCount('orders')->latest()->get();
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|integer|unique:tables,table_number',
            'capacity'     => 'required|integer|min:1|max:20',
            'status'       => 'required|in:available,occupied,reserved',
        ]);

        Table::create($request->only('table_number','capacity','status'));

        return redirect()->route('admin.tables.index')
               ->with('success', 'Table added successfully!');
    }

    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'table_number' => 'required|integer|unique:tables,table_number,'.$table->id,
            'capacity'     => 'required|integer|min:1|max:20',
            'status'       => 'required|in:available,occupied,reserved',
        ]);

        $table->update($request->only('table_number','capacity','status'));

        return redirect()->route('admin.tables.index')
               ->with('success', 'Table updated!');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')
               ->with('success', 'Table deleted!');
    }

    public function qrcode(Table $table)
    {
        $url = route('customer.order.create',
                    ['table' => $table->id]);
        $qr  = QrCode::format('svg')
                    ->size(300)
                    ->generate($url);

        return view('admin.tables.qrcode',
                    compact('table', 'qr', 'url'));
    }
}
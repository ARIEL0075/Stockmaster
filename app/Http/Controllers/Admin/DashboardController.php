<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\StockMovementRequest;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;


class DashboardController extends Controller
{
   public function dashboard()
{
    $totalProducts = Product::count();
    $totalCategories = Category::count();

    // Nombre de produits dont le stock est faible
    $lowStock = Product::whereColumn('quantity', '<=', 'min_stock')
        ->where('quantity', '>', 0)
        ->count();

    // Nombre de produits en rupture de stock
    $outOfStock = Product::where('quantity', '<=', 0)->count();

    // Produits à surveiller : les 8 plus bas en stock
    $alerts = Product::with('category')
        ->whereColumn('quantity', '<=', 'min_stock')
        ->orderBy('quantity')
        ->take(8)
        ->get();

    return view('admin.dashboard', [
        'totalProducts' => $totalProducts,
        'totalCategories' => $totalCategories,
        'lowStock' => $lowStock,
        'outOfStock' => $outOfStock,
        'alerts' => $alerts,
    ]);
}

    public function stockMovements()
{
    $movements = stockMovement::with(['product', 'user'])
        ->latest()
        ->latest('id')
        ->paginate(15);

    $products = product::orderBy('name')
        ->get(['id', 'name', 'reference', 'quantity']);

    return view('admin.stock-movements', [
        'movements' => $movements,
        'products'  => $products,
    ]);
}

public function storeStockMovement(StockMovementRequest $request)
{
    $data = $request->validated();

    DB::transaction(function () use ($data) {
        // Verrouille la ligne du produit jusqu'à la fin de la transaction
        $produit = product::lockForUpdate()->findOrFail($data['product_id']);

        if ($data['type'] === 'sortie') {
            if ($data['quantity'] > $produit->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => "Stock insuffisant : il reste {$produit->quantity} unité(s) de « {$produit->name} ».",
                ]);
            }

            $produit->quantity -= $data['quantity'];
        } else {
            $produit->quantity += $data['quantity'];
        }

        $produit->save();

        StockMovement::create([
            'product_id'  => $produit->id,
            'user_id'     => Auth::id(),
            'type'        => $data['type'],
            'quantity'    => $data['quantity'],
            'description' => $data['description'] ?? null,
        ]);
    });

       return redirect()
       ->route('admin.stock-movements')
       ->with('success', 'Mouvement de stock enregistré avec succès.');
}

    public function history()
    {
        return view('admin.history');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function login()
    {
        return view('admin.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Vous êtes maintenant déconnecté');
    }

    public function dologin(LoginRequest $request)
    {
        $cre = $request->validated();

        if (Auth::attempt($cre)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Aucun utilisateur ne correspond à ces identifiants'
        ])->onlyInput('email');
    }
}
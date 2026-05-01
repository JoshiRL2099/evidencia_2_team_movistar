<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('role');
        $role = strtoupper(trim($user->role->name ?? ''));

        if ($role === 'ADMIN') {
            return $this->adminDashboard($user);
        }

        return $this->userDashboard($user);
    }

    private function adminDashboard($user)
    {
        $pendingOrders = Order::where('status', 'ORDERED')->count();
        $onRouteOrders = Order::where('status', 'IN_ROUTE')->count();
        $deliveredToday = Order::where('status', 'DELIVERED')
            ->whereDate('updated_at', today())
            ->count();

        $outOfStockItems = Product::where('active', true)
            ->where('stock_quantity', '<=', 0)
            ->count();

        $salesUsers = User::whereHas('role', fn($q) => $q->where('name', 'SALES'))
            ->where('is_active', true)
            ->count();

        $purchasingUsers = User::whereHas('role', fn($q) => $q->where('name', 'PURCHASING'))
            ->where('is_active', true)
            ->count();

        $warehouseUsers = User::whereHas('role', fn($q) => $q->where('name', 'WAREHOUSE'))
            ->where('is_active', true)
            ->count();

        $routeUsers = User::whereHas('role', fn($q) => $q->where('name', 'ROUTE'))
            ->where('is_active', true)
            ->count();

        $recentActivity = OrderStatusHistory::with(['order', 'changedBy'])
            ->latest('changed_at')
            ->take(10)
            ->get();

        return view('dashboard-admin', compact(
            'user',
            'pendingOrders',
            'onRouteOrders',
            'deliveredToday',
            'outOfStockItems',
            'salesUsers',
            'purchasingUsers',
            'warehouseUsers',
            'routeUsers',
            'recentActivity'
        ));
    }

    private function userDashboard($user)
    {
        $latestOrder = Order::with([
            'customer',
            'deliveryAddress',
            'items.product'
        ])
            ->where('created_by_user_id', $user->user_id)
            ->latest('created_at')
            ->first();

        return view('dashboard-user', compact('user', 'latestOrder'));
    }
}
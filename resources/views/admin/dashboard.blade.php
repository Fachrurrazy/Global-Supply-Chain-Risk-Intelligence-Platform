@extends('admin.layout')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('styles')
<style>
    .stat-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-left: 5px solid #3498db;
    }
    .stat-card.users { border-color: #9b59b6; }
    .stat-card.ports { border-color: #2ecc71; }
    .stat-card.articles { border-color: #e74c3c; }
    .stat-card.cargo { border-color: #f1c40f; }
    
    .stat-icon {
        font-size: 2.5rem;
        color: #cbd5e1;
    }
    .stat-content h3 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
    }
    .stat-content p {
        margin: 0;
        color: #7f8c8d;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-3">
        <div class="stat-card users">
            <div class="stat-content">
                <h3>{{ $usersCount ?? 0 }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card ports">
            <div class="stat-content">
                <h3>{{ $portsCount ?? 0 }}</h3>
                <p>Ports</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card articles">
            <div class="stat-content">
                <h3>--</h3>
                <p>Articles</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-journal-text"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card cargo">
            <div class="stat-content">
                <h3>{{ $cargoCount ?? 0 }}</h3>
                <p>Cargo Entries</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-box-seam-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Recent Activity</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">No recent activity found. Implement the specific management pages to see activities here.</p>
            </div>
        </div>
    </div>
</div>
@endsection

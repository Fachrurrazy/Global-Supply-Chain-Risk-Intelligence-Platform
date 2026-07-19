@extends('admin.layout')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="cyber-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--clh-text-muted); margin-bottom: 4px;">Total Users</div>
                        <div style="font-family: var(--clh-font-mono); font-size: 2rem; font-weight: 800; color: var(--clh-text-primary);">{{ $usersCount ?? 0 }}</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: var(--clh-radius-md); background: rgba(168, 85, 247, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people-fill" style="font-size: 1.3rem; color: #A855F7;"></i>
                    </div>
                </div>
                <div style="margin-top: 12px; height: 3px; border-radius: 2px; background: var(--clh-bg-input); overflow: hidden;">
                    <div style="height: 100%; width: 65%; background: linear-gradient(90deg, #A855F7, #6366F1); border-radius: 2px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="cyber-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--clh-text-muted); margin-bottom: 4px;">Ports</div>
                        <div style="font-family: var(--clh-font-mono); font-size: 2rem; font-weight: 800; color: var(--clh-text-primary);">{{ $portsCount ?? 0 }}</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: var(--clh-radius-md); background: rgba(52, 211, 153, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-geo-alt-fill" style="font-size: 1.3rem; color: var(--clh-positive);"></i>
                    </div>
                </div>
                <div style="margin-top: 12px; height: 3px; border-radius: 2px; background: var(--clh-bg-input); overflow: hidden;">
                    <div style="height: 100%; width: 80%; background: linear-gradient(90deg, #34D399, #00E5FF); border-radius: 2px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="cyber-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--clh-text-muted); margin-bottom: 4px;">Articles</div>
                        <div style="font-family: var(--clh-font-mono); font-size: 2rem; font-weight: 800; color: var(--clh-text-primary);">{{ $articlesCount ?? 0 }}</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: var(--clh-radius-md); background: rgba(248, 113, 113, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-journal-text" style="font-size: 1.3rem; color: var(--clh-negative);"></i>
                    </div>
                </div>
                <div style="margin-top: 12px; height: 3px; border-radius: 2px; background: var(--clh-bg-input); overflow: hidden;">
                    <div style="height: 100%; width: 45%; background: linear-gradient(90deg, #F87171, #FBBF24); border-radius: 2px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="cyber-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--clh-text-muted); margin-bottom: 4px;">Cargo Entries</div>
                        <div style="font-family: var(--clh-font-mono); font-size: 2rem; font-weight: 800; color: var(--clh-text-primary);">{{ $cargoCount ?? 0 }}</div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: var(--clh-radius-md); background: rgba(251, 191, 36, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-box-seam-fill" style="font-size: 1.3rem; color: var(--clh-warning);"></i>
                    </div>
                </div>
                <div style="margin-top: 12px; height: 3px; border-radius: 2px; background: var(--clh-bg-input); overflow: hidden;">
                    <div style="height: 100%; width: 55%; background: linear-gradient(90deg, #FBBF24, #00E5FF); border-radius: 2px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="cyber-card">
            <div class="card-header">
                <h5><i class="bi bi-activity me-2" style="color: var(--clh-accent);"></i>Recent Activity</h5>
            </div>
            <div class="card-body text-center py-5">
                <i class="bi bi-clock-history" style="font-size: 2.5rem; color: var(--clh-text-muted); opacity: 0.3;"></i>
                <p class="mt-2" style="color: var(--clh-text-muted); font-size: 0.85rem;">No recent activity found. Manage your platform data using the sidebar menus.</p>
            </div>
        </div>
    </div>
</div>
@endsection

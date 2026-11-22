
@extends('layouts.app')

@section('title', 'Dashboard - InspectPro')
@section('heading', 'Dashboard Overview')

@section('content')

<style>
    /* Dashboard layout */
    .dashboard {
        display: flex;
        flex-direction: column;
        gap: 28px;
        color: #f1f0ff;
    }

    .dashboard-hero {
        padding: 32px;
        border: 1px solid #373052;
        border-radius: 20px;
        background: linear-gradient(120deg, #211b3a, #171522);
    }

    .dashboard-hero h1 {
        margin: 0 0 10px;
        font-size: clamp(25px, 4vw, 36px);
    }

    .dashboard-hero p {
        margin: 0;
        color: #b6b0ce;
        line-height: 1.8;
    }

    .dashboard-label {
        margin: 0 0 15px;
        font-size: 20px;
    }

    /* Statistics */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .dashboard-stat {
        min-width: 0;
        padding: 22px;
        border: 1px solid #302b43;
        border-radius: 16px;
        background: #191724;
    }

    .dashboard-stat small {
        color: #aaa4c2;
        line-height: 1.7;
    }

    .dashboard-stat strong {
        display: block;
        margin-top: 12px;
        font-size: 32px;
        overflow-wrap: anywhere;
    }

    /* Management and API cards */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .dashboard-api-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .dashboard-card {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
        padding: 23px;
        border: 1px solid #302b43;
        border-radius: 16px;
        background: #191724;
        color: #f1f0ff;
        text-decoration: none;
        transition: border-color .2s, transform .2s, background .2s;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        border-color: #8b70ff;
        background: #211d32;
    }

    .dashboard-card h3 {
        margin: 0;
        font-size: 18px;
    }

    .dashboard-card p {
        margin: 0;
        flex: 1;
        color: #aaa4c2;
        line-height: 1.8;
    }

    .dashboard-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        border-radius: 13px;
        background: #30254e;
        color: #c7baff;
        font-size: 23px;
    }

    .dashboard-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
        color: #c3b5ff;
        font-weight: 700;
    }

    /* Workflow information */
    .dashboard-notice {
        padding: 19px 22px;
        border: 1px solid #373052;
        border-radius: 12px;
        background: #191724;
        color: #c8c2dc;
        line-height: 1.9;
    }

    .dashboard-notice strong {
        color: #e4ddff;
    }

    /* Responsive layout */
    @media (max-width: 1100px) {
        .dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .dashboard-hero {
            padding: 22px;
        }

        .dashboard-stats,
        .dashboard-grid,
        .dashboard-api-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-stat,
        .dashboard-card {
            padding: 19px;
        }
    }
</style>

<div class="dashboard">

    {{-- Welcome section --}}
    <section class="dashboard-hero">
        <h1>Inspection Service</h1>
        <p>
            Welcome to InspectPro. Manage your inspection data,
            maintain records, and test your Laravel backend APIs
            from one central dashboard.
        </p>
    </section>

    {{-- Database statistics --}}
    <section>
        <h2 class="dashboard-label">System Overview</h2>

        <div class="dashboard-stats">
            <div class="dashboard-stat">
                <small>Inspection Types</small>
                <strong>{{ \App\Models\InspectionType::count() }}</strong>
            </div>

            <div class="dashboard-stat">
                <small>Inspection Plans</small>
                <strong>{{ \App\Models\InspectionPlan::count() }}</strong>
            </div>

            <div class="dashboard-stat">
                <small>Total Inspections</small>
                <strong>{{ \App\Models\Inspection::count() }}</strong>
            </div>

            <div class="dashboard-stat">
                <small>Active Inspectors</small>
                <strong>{{ \App\Models\Inspector::where('is_active', true)->count() }}</strong>
            </div>
        </div>
    </section>

    {{-- Management: graphical web pages --}}
    <section>
        <h2 class="dashboard-label">Management</h2>

        <div class="dashboard-grid">

            <a class="dashboard-card"
               href="{{ route('inspection-types.index') }}">
                <span class="dashboard-icon">◈</span>
                <h3>Inspection Types</h3>
                <p>
                    View records, create new types, edit existing data,
                    and delete types when permitted.
                </p>
                <span class="dashboard-link">Manage Types →</span>
            </a>

            <a class="dashboard-card"
               href="{{ route('inspection-plans.index') }}">
                <span class="dashboard-icon">▦</span>
                <h3>Inspection Plans</h3>
                <p>
                    Manage plans, inspection categories, schedules,
                    frequencies, and statuses.
                </p>
                <span class="dashboard-link">Manage Plans →</span>
            </a>

            <a class="dashboard-card"
               href="{{ route('inspections.index') }}">
                <span class="dashboard-icon">✓</span>
                <h3>Inspections</h3>
                <p>
                    View and manage inspections, then open an inspection
                    to work with its items and findings.
                </p>
                <span class="dashboard-link">Manage Inspections →</span>
            </a>

            <a class="dashboard-card"
               href="{{ url('/api/v1/inspectors') }}">
                <span class="dashboard-icon">♙</span>
                <h3>Inspectors Data</h3>
                <p>
                    View the inspectors returned by the API.
                    Full web-based CRUD can be added separately.
                </p>
                <span class="dashboard-link">View Inspectors JSON →</span>
            </a>

        </div>
    </section>

    {{-- API testing: HTTP requests and JSON responses --}}
    <section>
        <h2 class="dashboard-label">API Testing Workbench</h2>

        <div class="dashboard-api-grid">

            <a class="dashboard-card"
               href="{{ route('api-tester', ['endpoint' => '/api/v1/inspection-types']) }}">
                <span class="dashboard-icon">{ }</span>
                <h3>Inspection Types API</h3>
                <p>
                    Test GET, POST, PUT, PATCH, and DELETE requests
                    for inspection types.
                </p>
                <span class="dashboard-link">Test Types API →</span>
            </a>

            <a class="dashboard-card"
               href="{{ route('api-tester', ['endpoint' => '/api/v1/inspection-plans']) }}">
                <span class="dashboard-icon">{ }</span>
                <h3>Inspection Plans API</h3>
                <p>
                    Send requests to create, retrieve, update,
                    and delete inspection plans.
                </p>
                <span class="dashboard-link">Test Plans API →</span>
            </a>

            <a class="dashboard-card"
               href="{{ route('api-tester', ['endpoint' => '/api/v1/inspections']) }}">
                <span class="dashboard-icon">{ }</span>
                <h3>Inspections API</h3>
                <p>
                    Test inspection endpoints and inspect their
                    HTTP status codes and JSON responses.
                </p>
                <span class="dashboard-link">Test Inspections API →</span>
            </a>

            <a class="dashboard-card"
               href="{{ route('api-tester', ['endpoint' => '/api/v1/inspectors']) }}">
                <span class="dashboard-icon">{ }</span>
                <h3>Inspectors API</h3>
                <p>
                    Send requests to the inspectors endpoint and
                    examine the server response.
                </p>
                <span class="dashboard-link">Test Inspectors API →</span>
            </a>

        </div>
    </section>

    {{-- Backend workflow --}}
    <section class="dashboard-notice">
        <strong>Backend workflow</strong><br>
        HTTP Request → Validation → Database → HTTP Response<br>
        Use the API Testing Workbench to test requests and examine
        status codes and JSON responses. Use the Management section
        to work with the graphical web interface.
    </section>

</div>
@endsection

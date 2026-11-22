
@extends('layouts.app')

@section('title', 'API Tester - InspectPro')
@section('heading', 'API Testing Workbench')

@section('content')
<style>
    .tester { display:grid; gap:20px; }
    .tester-hero, .tester-panel {
        background:#141d32; border:1px solid #293653;
        border-radius:15px; padding:24px;
    }
    .tester-hero p, .hint { color:#99a7c2; line-height:1.7; }
    .tester-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .tester-field { display:flex; flex-direction:column; gap:8px; min-width:0; }
    .tester-field label { color:#cbd4e7; }
    .tester textarea { min-height:190px; font-family:Consolas,monospace; font-size:13px; }
    .tester select, .tester input, .tester textarea {
        width:100%; background:#0d1426; color:#e8ecf8;
        border:1px solid #35415e; border-radius:8px; padding:12px;
    }
    .tester-actions { display:flex; flex-wrap:wrap; gap:10px; margin-top:18px; }
    .tester-btn { border:0; border-radius:8px; padding:12px 18px; cursor:pointer; font-weight:bold; }
    .tester-send { background:#8b7cf6; color:white; }
    .tester-clear { background:#28334d; color:white; }
    .tester-result {
        background:#090e1b; border:1px solid #293653; border-radius:10px;
        padding:16px; min-height:180px; overflow:auto;
    }
    .tester-result pre {
        white-space:pre-wrap; overflow-wrap:anywhere; color:#d8e2f5;
        font:13px/1.7 Consolas,monospace; margin:12px 0 0;
    }
    .tester-meta { display:flex; flex-wrap:wrap; gap:12px; align-items:center; }
    .tester-badge { padding:7px 11px; background:#292747; border-radius:8px; }
    .tester-badge.good { color:#8ce4b0; }
    .tester-badge.bad { color:#ff9292; }
    .management-links { display:flex; flex-wrap:wrap; gap:10px; }
    .management-links a {
        background:#211d32; border:1px solid #373052; border-radius:9px;
        padding:12px 15px; color:#d4caff;
    }
    @media(max-width:700px) {
        .tester-grid { grid-template-columns:1fr; }
        .tester-hero, .tester-panel { padding:17px; }
    }
</style>

<div class="tester">
    <section class="tester-hero">
        <h1>API Testing Workbench</h1>
        <p>
            Send HTTP requests to your Laravel API, inspect response status codes,
            and view the returned JSON. Requests are sent to your actual local API.
        </p>
        <div class="management-links">
            <a href="{{ route('inspection-types.index') }}">Manage Types</a>
            <a href="{{ route('inspection-plans.index') }}">Manage Plans</a>
            <a href="{{ route('inspections.index') }}">Manage Inspections</a>
        </div>
    </section>

    <section class="tester-panel">
        <h2>Request</h2>
        <div class="tester-grid">
            <div class="tester-field">
                <label for="api-method">HTTP Method</label>
                <select id="api-method">
                    <option>GET</option>
                    <option>POST</option>
                    <option>PUT</option>
                    <option>PATCH</option>
                    <option>DELETE</option>
                </select>
            </div>

            <div class="tester-field">
                <label for="api-endpoint">Endpoint</label>
                <select id="api-endpoint">
                    <option value="/api/v1/inspection-types">Inspection Types</option>
                    <option value="/api/v1/inspection-plans">Inspection Plans</option>
                    <option value="/api/v1/inspections">Inspections</option>
                    <option value="/api/v1/inspectors">Inspectors</option>
                    <option value="/api/v1/inspections/{id}/complete">Complete Inspection</option>
                    <option value="/api/v1/inspections/{id}/items">Inspection Items</option>
                    <option value="/api/v1/inspection-items/{id}">Single Inspection Item</option>
                    <option value="/api/v1/inspections/{id}/findings">Inspection Findings</option>
                    <option value="/api/v1/findings/{id}">Single Finding</option>
                </select>
            </div>

            <div class="tester-field">
                <label for="api-id">Record ID (for individual records)</label>
                <input id="api-id" type="number" min="1" placeholder="Example: 1">
            </div>

            <div class="tester-field">
                <label for="api-url">Request URL</label>
                <input id="api-url" readonly>
            </div>
        </div>

        <div class="tester-field" style="margin-top:18px">
            <label for="api-body">Request Body (JSON)</label>
            <textarea id="api-body" spellcheck="false">{
  "title": "Equipment Inspection",
  "description": "Routine inspection of equipment",
  "is_active": true
}</textarea>
            <span class="hint">
                For POST, PUT, and PATCH, enter the fields required by the selected endpoint.
                GET and DELETE normally do not need a body.
            </span>
        </div>

        <div class="tester-actions">
            <button type="button" class="tester-btn tester-send" id="api-send">Send Request</button>
            <button type="button" class="tester-btn tester-clear" id="api-clear">Clear Response</button>
        </div>
    </section>

    <section class="tester-panel">
        <h2>Response</h2>
        <div class="tester-meta">
            <span class="tester-badge" id="api-status">Status: Not sent</span>
            <span class="tester-badge" id="api-duration">Duration: —</span>
        </div>
        <div class="tester-result" style="margin-top:16px">
            <pre id="api-response">Your server response will appear here.</pre>
        </div>
    </section>
</div>

<script>
(() => {
    const methodEl = document.getElementById('api-method');
    const endpointEl = document.getElementById('api-endpoint');
    const idEl = document.getElementById('api-id');
    const urlEl = document.getElementById('api-url');
    const bodyEl = document.getElementById('api-body');
    const sendBtn = document.getElementById('api-send');
    const clearBtn = document.getElementById('api-clear');
    const statusEl = document.getElementById('api-status');
    const durationEl = document.getElementById('api-duration');
    const responseEl = document.getElementById('api-response');

    function getUrl() {
        let path = endpointEl.value;
        if (path.includes('{id}')) {
            const id = idEl.value.trim();
            if (!id || Number(id) < 1) return null;
            path = path.replace('{id}', encodeURIComponent(id));
        }
        return new URL(path, window.location.origin).toString();
    }

    function updateUrl() {
        urlEl.value = getUrl() || 'Enter a valid record ID above';
    }

    methodEl.addEventListener('change', updateUrl);
    endpointEl.addEventListener('change', updateUrl);
    idEl.addEventListener('input', updateUrl);

    sendBtn.addEventListener('click', async () => {
        const url = getUrl();
        const method = methodEl.value;

        if (!url) {
            statusEl.textContent = 'Status: Record ID required';
            statusEl.className = 'tester-badge bad';
            responseEl.textContent = 'Enter a valid record ID for this endpoint.';
            return;
        }

        const options = {
            method,
            headers: { 'Accept': 'application/json' }
        };

        if (['POST', 'PUT', 'PATCH'].includes(method)) {
            let parsedBody;
            try {
                parsedBody = JSON.parse(bodyEl.value);
            } catch (error) {
                statusEl.textContent = 'Status: Invalid JSON';
                statusEl.className = 'tester-badge bad';
                responseEl.textContent = error.message;
                return;
            }
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(parsedBody);
        }

        sendBtn.disabled = true;
        sendBtn.textContent = 'Sending...';
        statusEl.textContent = 'Status: Waiting...';
        statusEl.className = 'tester-badge';
        responseEl.textContent = 'Waiting for server response...';

        const started = performance.now();

        try {
            const response = await fetch(url, options);
            const elapsed = Math.round(performance.now() - started);
            const raw = await response.text();

            durationEl.textContent = `Duration: ${elapsed} ms`;
            statusEl.textContent = `Status: ${response.status} ${response.statusText}`;
            statusEl.className = 'tester-badge ' +
                (response.ok ? 'good' : 'bad');

            try {
                responseEl.textContent = JSON.stringify(JSON.parse(raw), null, 2);
            } catch {
                responseEl.textContent = raw || '(Empty response body)';
            }
        } catch (error) {
            statusEl.textContent = 'Status: Network error';
            statusEl.className = 'tester-badge bad';
            responseEl.textContent =
                'Could not reach the server. Check that Laravel is running.\n\n' +
                error.message;
        } finally {
            sendBtn.disabled = false;
            sendBtn.textContent = 'Send Request';
        }
    });

    clearBtn.addEventListener('click', () => {
        statusEl.textContent = 'Status: Not sent';
        statusEl.className = 'tester-badge';
        durationEl.textContent = 'Duration: —';
        responseEl.textContent = 'Your server response will appear here.';
    });

    updateUrl();
})();
</script>
@endsection

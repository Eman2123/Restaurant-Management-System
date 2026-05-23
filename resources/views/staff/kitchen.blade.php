<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kitchen Display — RMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Public Sans', sans-serif;
            background: #0f0f0f;
            color: #fff;
            min-height: 100vh;
        }

        /* Topbar */
        .kds-header {
            background: #1a1a1a;
            border-bottom: 2px solid #2a2a2a;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .kds-logo {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .kds-logo span {
            background: #c8a951;
            color: #000;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .kds-time {
            font-size: 22px;
            font-weight: 700;
            color: #c8a951;
            font-variant-numeric: tabular-nums;
        }
        .kds-stats {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .kds-stat {
            text-align: center;
        }
        .kds-stat .num {
            font-size: 24px;
            font-weight: 800;
            line-height: 1;
        }
        .kds-stat .lbl {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
        }

        /* Column layout */
        .kds-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            padding: 16px;
            min-height: calc(100vh - 64px);
        }

        .kds-col-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 12px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .col-pending  .kds-col-header { background:#ffc107; color:#000; }
        .col-cooking  .kds-col-header { background:#fd7e14; color:#fff; }
        .col-ready    .kds-col-header { background:#198754; color:#fff; }

        /* Order Cards */
        .order-card {
            background: #1e1e1e;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            margin-bottom: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: slideIn 0.4s ease;
        }
        @keyframes slideIn {
            from { opacity:0; transform:translateY(-10px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .order-card:hover {
            border-color: #444;
            transform: translateY(-2px);
        }
        .order-card.urgent { border-color: #dc3545 !important; }
        .order-card.urgent .card-top { background: rgba(220,53,69,0.15); }

        .card-top {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #2a2a2a;
        }
        .order-num {
            font-size: 20px;
            font-weight: 800;
            color: #c8a951;
        }
        .order-table {
            background: #2a2a2a;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .order-time {
            font-size: 12px;
            color: #888;
        }
        .order-timer {
            font-size: 13px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }
        .timer-ok     { background:rgba(25,135,84,0.2); color:#198754; }
        .timer-warn   { background:rgba(255,193,7,0.2); color:#ffc107; }
        .timer-urgent { background:rgba(220,53,69,0.2); color:#dc3545;
                        animation: blink 1s infinite; }
        @keyframes blink {
            0%,100% { opacity:1; }
            50%      { opacity:0.5; }
        }

        .card-items { padding: 12px 16px; }
        .item-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #2a2a2a;
        }
        .item-row:last-child { border-bottom: none; }
        .item-qty {
            background: #c8a951;
            color: #000;
            font-weight: 800;
            font-size: 14px;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .item-name {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.3;
        }
        .item-note {
            font-size: 11px;
            color: #ffc107;
            margin-top: 2px;
        }

        .card-actions {
            padding: 12px 16px;
            border-top: 1px solid #2a2a2a;
        }
        .btn-action {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-action:hover { transform: scale(1.02); opacity: 0.9; }
        .btn-cook  { background:#fd7e14; color:#fff; }
        .btn-ready { background:#198754; color:#fff; }
        .btn-serve { background:#0d6efd; color:#fff; }

        /* Notification */
        .kds-notif {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
        }
        .notif-item {
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 10px;
            min-width: 260px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: notifIn 0.3s ease;
            border-left: 4px solid #c8a951;
        }
        @keyframes notifIn {
            from { opacity:0; transform:translateX(20px); }
            to   { opacity:1; transform:translateX(0); }
        }

        /* Empty state */
        .empty-col {
            text-align: center;
            padding: 60px 20px;
            color: #444;
        }
        .empty-col i { font-size: 48px; display:block; margin-bottom:12px; }

        /* Scrollable columns */
        .kds-col {
            height: calc(100vh - 96px);
            overflow-y: auto;
        }
        .kds-col::-webkit-scrollbar { width: 4px; }
        .kds-col::-webkit-scrollbar-track { background: transparent; }
        .kds-col::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 2px;
        }

        /* Sound button */
        .sound-btn {
            background: #2a2a2a;
            border: 1px solid #333;
            color: #888;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }
        .sound-btn.on { color: #c8a951; border-color: #c8a951; }
    </style>
</head>
<body>

<!-- Header -->
<div class="kds-header">
    <div class="kds-logo">
        <i class="ti ti-chef-hat" style="font-size:24px; color:#c8a951;"></i>
        Kitchen Display
        <span>LIVE</span>
    </div>

    <div class="kds-stats">
        <div class="kds-stat">
            <div class="num text-warning" id="statPending">0</div>
            <div class="lbl">Pending</div>
        </div>
        <div class="kds-stat">
            <div class="num text-danger" id="statCooking">0</div>
            <div class="lbl">Cooking</div>
        </div>
        <div class="kds-stat">
            <div class="num text-success" id="statReady">0</div>
            <div class="lbl">Ready</div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <button class="sound-btn on" id="soundBtn"
                onclick="toggleSound()">
            <i class="ti ti-volume me-1"></i>Sound ON
        </button>
        <a href="{{ route('staff.dashboard') }}"
           style="color:#888; font-size:13px; text-decoration:none;">
            <i class="ti ti-arrow-left me-1"></i>Back
        </a>
        <div class="kds-time" id="clock">00:00:00</div>
    </div>
</div>

<!-- Board -->
<div class="kds-board">

    <!-- Pending Column -->
    <div class="col-pending">
        <div class="kds-col-header">
            <span><i class="ti ti-clock me-2"></i>New Orders</span>
            <span id="pendingCount">0</span>
        </div>
        <div class="kds-col" id="pendingCol">
            <div class="empty-col" id="pendingEmpty">
                <i class="ti ti-check-circle" style="color:#198754;"></i>
                <p>No pending orders</p>
            </div>
        </div>
    </div>

    <!-- Cooking Column -->
    <div class="col-cooking">
        <div class="kds-col-header">
            <span><i class="ti ti-flame me-2"></i>Cooking</span>
            <span id="cookingCount">0</span>
        </div>
        <div class="kds-col" id="cookingCol">
            <div class="empty-col" id="cookingEmpty">
                <i class="ti ti-flame"></i>
                <p>Nothing cooking</p>
            </div>
        </div>
    </div>

    <!-- Ready Column -->
    <div class="col-ready">
        <div class="kds-col-header">
            <span><i class="ti ti-circle-check me-2"></i>Ready</span>
            <span id="readyCount">0</span>
        </div>
        <div class="kds-col" id="readyCol">
            <div class="empty-col" id="readyEmpty">
                <i class="ti ti-circle-check"></i>
                <p>No orders ready</p>
            </div>
        </div>
    </div>

</div>

<!-- Notifications -->
<div class="kds-notif" id="notifArea"></div>

<!-- Audio -->
<audio id="newOrderSound" preload="auto">
    <source src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2xBKT2Aw+HeqoFcRkNnnMTiv5ZxXFtnh6K0vLuYblBCUXiXsMC/rIJYQD5jjLTN0r+WYTM6c6TZ5M6kckAnPnGm4+jh0LWRWzI4g7jf2r5+Ri0rdqjg5ee6fToiO4C0v8qhYDYjLWun2cqpZi8ZMXus3tGqYCshI2Wi1dSqWx8XKDE=" type="audio/wav">
</audio>

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    let soundOn = true;
    let previousPendingIds = new Set();
    let orderTimers = {};

    // Clock
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').textContent =
            now.toLocaleTimeString('en-US', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Toggle sound
    function toggleSound() {
        soundOn = !soundOn;
        const btn = document.getElementById('soundBtn');
        btn.innerHTML = soundOn
            ? '<i class="ti ti-volume me-1"></i>Sound ON'
            : '<i class="ti ti-volume-off me-1"></i>Sound OFF';
        btn.classList.toggle('on', soundOn);
    }

    // Play sound
    function playSound() {
        if (!soundOn) return;
        try {
            const ctx = new AudioContext();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.frequency.setValueAtTime(880, ctx.currentTime);
            osc.frequency.setValueAtTime(660, ctx.currentTime + 0.1);
            osc.frequency.setValueAtTime(880, ctx.currentTime + 0.2);
            gain.gain.setValueAtTime(0.3, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.5);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.5);
        } catch(e) {}
    }

    // Show notification
    function showNotif(message, color = '#c8a951') {
        const area = document.getElementById('notifArea');
        const div = document.createElement('div');
        div.className = 'notif-item';
        div.style.borderLeftColor = color;
        div.innerHTML = `
            <i class="ti ti-bell" style="color:${color}; font-size:20px;"></i>
            <div>
                <div style="font-weight:700; font-size:13px;">${message}</div>
                <div style="font-size:11px; color:#888;">
                    ${new Date().toLocaleTimeString()}
                </div>
            </div>`;
        area.prepend(div);
        setTimeout(() => {
            div.style.opacity = '0';
            div.style.transition = 'opacity 0.5s';
            setTimeout(() => div.remove(), 500);
        }, 4000);
    }

    // Timer for order
    function getElapsedTime(createdAt) {
        const created = new Date(createdAt);
        const now = new Date();
        const mins = Math.floor((now - created) / 60000);
        const secs = Math.floor(((now - created) % 60000) / 1000);
        return { mins, secs, total: Math.floor((now - created) / 60000) };
    }

    // Update status via AJAX
    function updateStatus(orderId, status) {
        fetch(`/staff/kitchen/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify({ status })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showNotif(data.message,
                    status === 'cooking' ? '#fd7e14' :
                    status === 'ready'   ? '#198754' : '#0d6efd');
                fetchOrders();
            }
        });
    }

    // Build order card HTML
    function buildCard(order, colType) {
        const elapsed = getElapsedTime(order.created_at);
        const isUrgent = elapsed.total >= 15;
        const timerClass = elapsed.total < 10 ? 'timer-ok' :
                           elapsed.total < 15 ? 'timer-warn' : 'timer-urgent';

        let actionBtn = '';
        if (colType === 'pending') {
            actionBtn = `<button class="btn-action btn-cook"
                onclick="updateStatus(${order.id},'cooking')">
                <i class="ti ti-flame"></i> Start Cooking
            </button>`;
        } else if (colType === 'cooking') {
            actionBtn = `<button class="btn-action btn-ready"
                onclick="updateStatus(${order.id},'ready')">
                <i class="ti ti-check"></i> Mark Ready
            </button>`;
        } else if (colType === 'ready') {
            actionBtn = `<button class="btn-action btn-serve"
                onclick="updateStatus(${order.id},'served')">
                <i class="ti ti-user-check"></i> Mark Served
            </button>`;
        }

        const itemsHtml = order.order_items.map(item => `
            <div class="item-row">
                <div class="item-qty">${item.quantity}</div>
                <div>
                    <div class="item-name">${item.menu_item.name}</div>
                    ${item.special_instructions
                        ? `<div class="item-note">
                               <i class="ti ti-alert-triangle"></i>
                               ${item.special_instructions}
                           </div>`
                        : ''}
                </div>
            </div>`).join('');

        return `
        <div class="order-card ${isUrgent ? 'urgent' : ''}"
             id="order-${order.id}">
            <div class="card-top">
                <div>
                    <div class="order-num">#${order.id}</div>
                    <div class="order-time">
                        ${new Date(order.created_at).toLocaleTimeString()}
                    </div>
                </div>
                <div class="text-end">
                    <div class="order-table">
                        ${order.table
                            ? 'Table #'+order.table.table_number
                            : 'Takeaway'}
                    </div>
                    <div class="order-timer ${timerClass} mt-1">
                        <i class="ti ti-clock me-1"></i>
                        ${elapsed.mins}m ${elapsed.secs}s
                    </div>
                </div>
            </div>
            <div class="card-items">${itemsHtml}</div>
            ${order.notes
                ? `<div style="padding:8px 16px; background:rgba(255,193,7,0.1);
                              border-top:1px solid rgba(255,193,7,0.2);
                              font-size:12px; color:#ffc107;">
                       <i class="ti ti-note me-1"></i>${order.notes}
                   </div>`
                : ''}
            <div class="card-actions">${actionBtn}</div>
        </div>`;
    }

    // Fetch and render orders
    function fetchOrders() {
        fetch('{{ route("staff.kitchen.live") }}')
        .then(r => r.json())
        .then(data => {

            // Update counts
            document.getElementById('statPending').textContent =
                data.counts.pending;
            document.getElementById('statCooking').textContent =
                data.counts.cooking;
            document.getElementById('statReady').textContent =
                data.counts.ready;
            document.getElementById('pendingCount').textContent =
                data.counts.pending;
            document.getElementById('cookingCount').textContent =
                data.counts.cooking;
            document.getElementById('readyCount').textContent =
                data.counts.ready;

            // Check new orders
            const newIds = new Set(data.pending.map(o => o.id));
            newIds.forEach(id => {
                if (!previousPendingIds.has(id)) {
                    playSound();
                    showNotif(`New Order #${id} received!`, '#ffc107');
                }
            });
            previousPendingIds = newIds;

            // Render pending
            const pendingCol = document.getElementById('pendingCol');
            const pendingEmpty = document.getElementById('pendingEmpty');
            if (data.pending.length === 0) {
                pendingCol.innerHTML = pendingEmpty.outerHTML;
            } else {
                pendingCol.innerHTML = data.pending
                    .map(o => buildCard(o, 'pending')).join('');
            }

            // Render cooking
            const cookingCol = document.getElementById('cookingCol');
            const cookingEmpty = document.getElementById('cookingEmpty');
            if (data.cooking.length === 0) {
                cookingCol.innerHTML = cookingEmpty.outerHTML;
            } else {
                cookingCol.innerHTML = data.cooking
                    .map(o => buildCard(o, 'cooking')).join('');
            }

            // Render ready
            const readyCol = document.getElementById('readyCol');
            const readyEmpty = document.getElementById('readyEmpty');
            if (data.ready.length === 0) {
                readyCol.innerHTML = readyEmpty.outerHTML;
            } else {
                readyCol.innerHTML = data.ready
                    .map(o => buildCard(o, 'ready')).join('');
            }
        });
    }

    // Initial load
    fetchOrders();

    // Refresh every 8 seconds
    setInterval(fetchOrders, 8000);

    // Update timers every second
    setInterval(fetchOrders, 30000);
</script>
</body>
</html>
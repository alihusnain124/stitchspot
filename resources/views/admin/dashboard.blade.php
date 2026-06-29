@extends('admin/layout')
@section('title','Dashboard')
@section('page_title','Dashboard')
@section('dashboard_select','active')
@section('content')

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-card-icon"><i class="fa-solid fa-bag-shopping"></i></div>
        <span class="stat-trend"><i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i></span>
      </div>
      <div class="stat-card-value">{{ $stats['total_orders'] }}</div>
      <div class="stat-card-label">Total Orders</div>
      <div class="stat-card-sub mt-1">
        <span class="text-warning fw-semibold">{{ $stats['pending_orders'] }}</span> pending
        &nbsp;·&nbsp;
        <span class="text-success fw-semibold">{{ $stats['paid_orders'] }}</span> paid
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-card-icon"><i class="fa-solid fa-users"></i></div>
      </div>
      <div class="stat-card-value">{{ $stats['total_customers'] }}</div>
      <div class="stat-card-label">Customers</div>
      <div class="stat-card-sub mt-1">Registered accounts</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-card-icon"><i class="fa-solid fa-shirt"></i></div>
      </div>
      <div class="stat-card-value">{{ $stats['total_products'] }}</div>
      <div class="stat-card-label">Products</div>
      <div class="stat-card-sub mt-1">In catalogue</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-card-icon"><i class="fa-solid fa-scissors"></i></div>
      </div>
      <div class="stat-card-value">{{ $stats['total_tailor_orders'] }}</div>
      <div class="stat-card-label">Tailor Orders</div>
      <div class="stat-card-sub mt-1">Service bookings</div>
    </div>
  </div>
</div>

{{-- ── Charts Row ── --}}
<div class="row g-3 mb-4">

  {{-- Line/Bar chart: Orders over 6 months --}}
  <div class="col-lg-8">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <span class="admin-card-title">Orders Overview — Last 6 Months</span>
        <span style="font-size:11px;color:#9CA3AF">Normal vs Tailor</span>
      </div>
      <div class="admin-card-body" style="padding:20px">
        <canvas id="ordersChart" height="110"></canvas>
      </div>
    </div>
  </div>

  {{-- Donut chart: Payment status --}}
  <div class="col-lg-4">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <span class="admin-card-title">Payment Status</span>
      </div>
      <div class="admin-card-body" style="padding:20px;display:flex;flex-direction:column;align-items:center;justify-content:center">
        <canvas id="paymentChart" style="max-height:200px;max-width:200px"></canvas>
        <div style="display:flex;gap:20px;margin-top:18px;font-size:12px;font-family:'DM Sans',sans-serif">
          <span style="display:flex;align-items:center;gap:6px">
            <span style="width:10px;height:10px;border-radius:50%;background:#C9A96E;display:inline-block"></span>
            <span style="color:#666">Paid <strong style="color:#1A1A1A">{{ $paid }}</strong></span>
          </span>
          <span style="display:flex;align-items:center;gap:6px">
            <span style="width:10px;height:10px;border-radius:50%;background:#F4F2EF;border:2px solid #E5E7EB;display:inline-block"></span>
            <span style="color:#666">Pending <strong style="color:#1A1A1A">{{ $pending }}</strong></span>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ── Recent Orders ── --}}
<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">Recent Orders</span>
    <a href="{{ url('admin/order') }}" class="btn-adm btn-adm-ghost" style="font-size:11px">View All &rarr;</a>
  </div>
  <div class="admin-card-body">
    <table class="admin-table">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Customer</th>
          <th>Email</th>
          <th>Payment</th>
          <th>Status</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($recent_orders as $order)
        <tr>
          <td class="fw-semibold">#{{ $order->id }}</td>
          <td>{{ $order->name }}</td>
          <td style="color:#888">{{ $order->email }}</td>
          <td>
            @if(strtolower($order->payment_status) === 'paid')
              <span class="badge-on">Paid</span>
            @else
              <span class="badge-off">{{ ucfirst($order->payment_status) }}</span>
            @endif
          </td>
          <td>
            @if(strtolower($order->order_status) === 'delivered')
              <span class="badge-on">Delivered</span>
            @elseif(strtolower($order->order_status) === 'panding' || strtolower($order->order_status) === 'pending')
              <span class="badge-off">Pending</span>
            @else
              <span class="badge-info">{{ $order->order_status }}</span>
            @endif
          </td>
          <td style="color:#888;font-size:12px">{{ \Carbon\Carbon::parse($order->added_on)->format('d M Y') }}</td>
          <td>
            <a href="{{ url('admin/order_details/'.$order->id) }}" class="btn-adm btn-adm-ghost" style="font-size:11px;padding:4px 10px">View</a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center;color:#888;padding:32px">No orders yet.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ── Dashboard CSS additions ── --}}
<style>
  .stat-card {
    background: #fff;
    border: 1px solid #E5E7EB;
    padding: 22px 22px 18px;
    height: 100%;
  }
  .stat-card-icon {
    width: 42px; height: 42px;
    background: rgba(201,169,110,.12);
    color: #C9A96E;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px;
  }
  .stat-card-value {
    font-size: 36px;
    font-weight: 700;
    color: #1A1A1A;
    line-height: 1;
    margin-bottom: 4px;
  }
  .stat-card-label {
    font-size: 10.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: #9CA3AF;
  }
  .stat-card-sub {
    font-size: 11.5px;
    color: #9CA3AF;
  }
  .stat-trend { color: #9CA3AF; font-size: 12px; }
  .page-header-row { margin-bottom: 22px; }
  .page-header-row h1 { font-size: 20px; font-weight: 600; color: #1A1A1A; margin: 0; }
</style>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
  const labels  = @json($chartLabels);
  const orders  = @json($chartOrders);
  const tailor  = @json($chartTailor);

  // ── Bar chart ──────────────────────────────
  new Chart(document.getElementById('ordersChart'), {
    type: 'bar',
    data: {
      labels,
      datasets: [
        {
          label: 'Normal Orders',
          data: orders,
          backgroundColor: '#C9A96E',
          borderRadius: 4,
          barPercentage: 0.55,
        },
        {
          label: 'Tailor Orders',
          data: tailor,
          backgroundColor: '#1A1A1A',
          borderRadius: 4,
          barPercentage: 0.55,
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
          labels: {
            font: { family: "'DM Sans', sans-serif", size: 12 },
            color: '#6B7280',
            boxWidth: 12, boxHeight: 12, borderRadius: 2,
            usePointStyle: true, pointStyle: 'rect',
          }
        },
        tooltip: {
          backgroundColor: '#1A1A1A',
          titleFont: { family: "'DM Sans', sans-serif", size: 12 },
          bodyFont:  { family: "'DM Sans', sans-serif", size: 12 },
          padding: 10,
          cornerRadius: 0,
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: '#9CA3AF' },
          border: { display: false }
        },
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            font: { family: "'DM Sans', sans-serif", size: 11 },
            color: '#9CA3AF'
          },
          grid: { color: '#F3F2EF' },
          border: { display: false, dash: [4,4] }
        }
      }
    }
  });

  // ── Donut chart ────────────────────────────
  new Chart(document.getElementById('paymentChart'), {
    type: 'doughnut',
    data: {
      labels: ['Paid', 'Pending'],
      datasets: [{
        data: [{{ $paid }}, {{ $pending }}],
        backgroundColor: ['#C9A96E', '#F4F2EF'],
        borderColor:     ['#C9A96E', '#E5E7EB'],
        borderWidth: 2,
        hoverOffset: 6,
      }]
    },
    options: {
      cutout: '72%',
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1A1A1A',
          titleFont: { family: "'DM Sans', sans-serif", size: 12 },
          bodyFont:  { family: "'DM Sans', sans-serif", size: 12 },
          padding: 10,
          cornerRadius: 0,
        }
      }
    }
  });
</script>

@endsection

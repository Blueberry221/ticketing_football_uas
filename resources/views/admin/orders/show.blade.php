@extends('layouts.admin')

@section('title', 'Detail Order #' . $order->order_number)
@section('page-title', 'Detail Order #' . $order->order_number)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.orders') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Detail Order #{{ $order->order_number }}</h1>
            </div>
            <p class="mt-1 text-sm text-gray-600">Informasi lengkap tentang order ini</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            @if($order->status === 'pending')
                <button onclick="updateOrderStatus('paid')" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-check mr-2"></i>
                    Konfirmasi Pembayaran
                </button>
                <button onclick="updateOrderStatus('cancelled')" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batalkan Order
                </button>
            @elseif($order->status === 'paid')
                <button onclick="updateOrderStatus('refunded')" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-undo mr-2"></i>
                    Refund Order
                </button>
            @endif
            <button onclick="printOrder()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-print mr-2"></i>
                Print
            </button>
        </div>
    </div>

    <!-- Order Status Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">#{{ $order->order_number }}</h2>
                    <p class="text-sm text-gray-600">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($order->status === 'paid') bg-green-100 text-green-800
                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @elseif($order->status === 'refunded') bg-purple-100 text-purple-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    @if($order->status === 'paid')
                        <i class="fas fa-check-circle mr-1"></i>
                    @elseif($order->status === 'pending')
                        <i class="fas fa-clock mr-1"></i>
                    @elseif($order->status === 'cancelled')
                        <i class="fas fa-times-circle mr-1"></i>
                    @elseif($order->status === 'refunded')
                        <i class="fas fa-undo mr-1"></i>
                    @endif
                    {{ ucfirst($order->status) }}
                </span>
                <div class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($order->total_price) }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Customer</h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                    </div>
                </div>
                <div class="pt-3 border-t border-gray-100">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Role</p>
                            <p class="font-medium text-gray-900">{{ ucfirst($order->user->role) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Bergabung</p>
                            <p class="font-medium text-gray-900">{{ $order->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Metode Pembayaran</span>
                    <span class="font-medium text-gray-900">{{ ucfirst($order->payment_method) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Tiket</span>
                    <span class="font-medium text-gray-900">{{ $order->tickets->count() }} tiket</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium text-gray-900">Rp {{ number_format($order->total_price) }}</span>
                </div>
                <div class="pt-3 border-t border-gray-100">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-lg font-bold text-gray-900">Rp {{ number_format($order->total_price) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline Order</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-plus text-blue-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Order Dibuat</p>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                @if($order->status === 'paid')
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Pembayaran Dikonfirmasi</p>
                            <p class="text-sm text-gray-600">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                @elseif($order->status === 'cancelled')
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-times text-red-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Order Dibatalkan</p>
                            <p class="text-sm text-gray-600">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                @elseif($order->status === 'refunded')
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-undo text-purple-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Order Direfund</p>
                            <p class="text-sm text-gray-600">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tickets Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Detail Tiket</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertandingan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kursi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Booking</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-futbol text-green-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $ticket->match->homeTeam->name }} vs {{ $ticket->match->awayTeam->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $ticket->match->match_date->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $ticket->seat->seat_number }}</div>
                                <div class="text-sm text-gray-500">{{ $ticket->seat->area->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($ticket->seat->price) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($ticket->status === 'booked') bg-green-100 text-green-800
                                    @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $ticket->booked_at ? $ticket->booked_at->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Status Update -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Perubahan Status</h3>
        <p class="text-sm text-gray-600 mb-6" id="statusMessage">Apakah Anda yakin ingin mengubah status order ini?</p>
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeStatusModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <button id="confirmStatusBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
let currentStatus = null;

function updateOrderStatus(status) {
    currentStatus = status;
    
    let message = '';
    switch(status) {
        case 'paid':
            message = 'Apakah Anda yakin ingin mengkonfirmasi pembayaran order ini?';
            break;
        case 'cancelled':
            message = 'Apakah Anda yakin ingin membatalkan order ini? Tindakan ini tidak dapat dibatalkan.';
            break;
        case 'refunded':
            message = 'Apakah Anda yakin ingin melakukan refund untuk order ini?';
            break;
    }
    
    document.getElementById('statusMessage').textContent = message;
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusModal').classList.add('flex');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusModal').classList.remove('flex');
    currentStatus = null;
}

document.getElementById('confirmStatusBtn').addEventListener('click', function() {
    if (currentStatus) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.orders.updateStatus", $order) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = currentStatus;
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(statusField);
        
        document.body.appendChild(form);
        form.submit();
    }
});

function printOrder() {
    window.print();
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-white {
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
}
</style>
@endsection
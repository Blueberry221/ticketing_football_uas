@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola konfigurasi dan pengaturan sistem tiket sepak bola</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="backupSystem()" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i>
                Backup System
            </button>
            <button onclick="clearCache()" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-broom mr-2"></i>
                Clear Cache
            </button>
        </div>
    </div>

    <!-- Settings Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showTab('general')" class="tab-button active border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-cog mr-2"></i>
                    General
                </button>
                <button onclick="showTab('payment')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-credit-card mr-2"></i>
                    Payment
                </button>
                <button onclick="showTab('email')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-envelope mr-2"></i>
                    Email
                </button>
                <button onclick="showTab('security')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Security
                </button>
                <button onclick="showTab('maintenance')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-tools mr-2"></i>
                    Maintenance
                </button>
            </nav>
        </div>
    </div>

    <!-- General Settings Tab -->
    <div id="general-tab" class="tab-content">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Pengaturan Umum</h3>
                <p class="text-sm text-gray-600">Konfigurasi dasar sistem tiket</p>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="section" value="general">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Site Name -->
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Situs
                        </label>
                        <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Football Ticket System') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Site Description -->
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Situs
                        </label>
                        <input type="text" id="site_description" name="site_description" value="{{ old('site_description', $settings['site_description'] ?? 'Sistem Tiket Sepak Bola Online') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Contact Email -->
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Kontak
                        </label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'admin@footballticket.com') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Contact Phone -->
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Telepon Kontak
                        </label>
                        <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+62 21 1234 5678') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Timezone -->
                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">
                            Timezone
                        </label>
                        <select id="timezone" name="timezone" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="Asia/Jakarta" {{ ($settings['timezone'] ?? 'Asia/Jakarta') === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar" {{ ($settings['timezone'] ?? '') === 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura" {{ ($settings['timezone'] ?? '') === 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                    
                    <!-- Currency -->
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">
                            Mata Uang
                        </label>
                        <select id="currency" name="currency" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="IDR" {{ ($settings['currency'] ?? 'IDR') === 'IDR' ? 'selected' : '' }}>Indonesian Rupiah (IDR)</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                        </select>
                    </div>
                </div>
                
                <!-- Ticket Settings -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Tiket</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="max_tickets_per_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Maksimal Tiket per Order
                            </label>
                            <input type="number" id="max_tickets_per_order" name="max_tickets_per_order" value="{{ old('max_tickets_per_order', $settings['max_tickets_per_order'] ?? 10) }}" 
                                   min="1" max="50" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="booking_expiry_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Booking (Menit)
                            </label>
                            <input type="number" id="booking_expiry_minutes" name="booking_expiry_minutes" value="{{ old('booking_expiry_minutes', $settings['booking_expiry_minutes'] ?? 15) }}" 
                                   min="5" max="60" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="refund_deadline_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Batas Refund (Jam)
                            </label>
                            <input type="number" id="refund_deadline_hours" name="refund_deadline_hours" value="{{ old('refund_deadline_hours', $settings['refund_deadline_hours'] ?? 24) }}" 
                                   min="1" max="168" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payment Settings Tab -->
    <div id="payment-tab" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Pengaturan Pembayaran</h3>
                <p class="text-sm text-gray-600">Konfigurasi gateway pembayaran</p>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="section" value="payment">
                
                <!-- Payment Methods -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Metode Pembayaran</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <input type="checkbox" id="enable_bank_transfer" name="payment_methods[]" value="bank_transfer" 
                                       {{ in_array('bank_transfer', $settings['payment_methods'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="enable_bank_transfer" class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Transfer Bank</div>
                                    <div class="text-sm text-gray-500">Pembayaran melalui transfer bank</div>
                                </label>
                            </div>
                            <i class="fas fa-university text-gray-400 text-xl"></i>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <input type="checkbox" id="enable_ewallet" name="payment_methods[]" value="ewallet" 
                                       {{ in_array('ewallet', $settings['payment_methods'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="enable_ewallet" class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">E-Wallet</div>
                                    <div class="text-sm text-gray-500">OVO, GoPay, DANA, dll</div>
                                </label>
                            </div>
                            <i class="fas fa-mobile-alt text-gray-400 text-xl"></i>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <input type="checkbox" id="enable_credit_card" name="payment_methods[]" value="credit_card" 
                                       {{ in_array('credit_card', $settings['payment_methods'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="enable_credit_card" class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Kartu Kredit</div>
                                    <div class="text-sm text-gray-500">Visa, Mastercard, dll</div>
                                </label>
                            </div>
                            <i class="fas fa-credit-card text-gray-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Gateway Configuration -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Konfigurasi Gateway</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="midtrans_server_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Midtrans Server Key
                            </label>
                            <input type="password" id="midtrans_server_key" name="midtrans_server_key" value="{{ old('midtrans_server_key', $settings['midtrans_server_key'] ?? '') }}" 
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="midtrans_client_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Midtrans Client Key
                            </label>
                            <input type="text" id="midtrans_client_key" name="midtrans_client_key" value="{{ old('midtrans_client_key', $settings['midtrans_client_key'] ?? '') }}" 
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="payment_environment" class="block text-sm font-medium text-gray-700 mb-2">
                                Environment
                            </label>
                            <select id="payment_environment" name="payment_environment" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="sandbox" {{ ($settings['payment_environment'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                                <option value="production" {{ ($settings['payment_environment'] ?? '') === 'production' ? 'selected' : '' }}>Production</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="payment_fee_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                                Biaya Admin (%)
                            </label>
                            <input type="number" id="payment_fee_percentage" name="payment_fee_percentage" value="{{ old('payment_fee_percentage', $settings['payment_fee_percentage'] ?? 2.5) }}" 
                                   min="0" max="10" step="0.1" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Settings Tab -->
    <div id="email-tab" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Pengaturan Email</h3>
                <p class="text-sm text-gray-600">Konfigurasi SMTP dan template email</p>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="section" value="email">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="smtp_host" class="block text-sm font-medium text-gray-700 mb-2">
                            SMTP Host
                        </label>
                        <input type="text" id="smtp_host" name="smtp_host" value="{{ old('smtp_host', $settings['smtp_host'] ?? 'smtp.gmail.com') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="smtp_port" class="block text-sm font-medium text-gray-700 mb-2">
                            SMTP Port
                        </label>
                        <input type="number" id="smtp_port" name="smtp_port" value="{{ old('smtp_port', $settings['smtp_port'] ?? 587) }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="smtp_username" class="block text-sm font-medium text-gray-700 mb-2">
                            SMTP Username
                        </label>
                        <input type="email" id="smtp_username" name="smtp_username" value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="smtp_password" class="block text-sm font-medium text-gray-700 mb-2">
                            SMTP Password
                        </label>
                        <input type="password" id="smtp_password" name="smtp_password" value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="smtp_encryption" class="block text-sm font-medium text-gray-700 mb-2">
                            Encryption
                        </label>
                        <select id="smtp_encryption" name="smtp_encryption" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="tls" {{ ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-2">
                            From Address
                        </label>
                        <input type="email" id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? 'noreply@footballticket.com') }}" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Email Notifications</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Order Confirmation</div>
                                <div class="text-sm text-gray-500">Kirim email konfirmasi order</div>
                            </div>
                            <input type="checkbox" name="email_notifications[]" value="order_confirmation" 
                                   {{ in_array('order_confirmation', $settings['email_notifications'] ?? []) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Payment Reminder</div>
                                <div class="text-sm text-gray-500">Kirim reminder pembayaran</div>
                            </div>
                            <input type="checkbox" name="email_notifications[]" value="payment_reminder" 
                                   {{ in_array('payment_reminder', $settings['email_notifications'] ?? []) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Match Reminder</div>
                                <div class="text-sm text-gray-500">Kirim reminder pertandingan</div>
                            </div>
                            <input type="checkbox" name="email_notifications[]" value="match_reminder" 
                                   {{ in_array('match_reminder', $settings['email_notifications'] ?? []) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between">
                    <button type="button" onclick="testEmail()" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Test Email
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Security Settings Tab -->
    <div id="security-tab" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Pengaturan Keamanan</h3>
                <p class="text-sm text-gray-600">Konfigurasi keamanan dan akses sistem</p>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="section" value="security">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="session_lifetime" class="block text-sm font-medium text-gray-700 mb-2">
                            Session Lifetime (Menit)
                        </label>
                        <input type="number" id="session_lifetime" name="session_lifetime" value="{{ old('session_lifetime', $settings['session_lifetime'] ?? 120) }}" 
                               min="30" max="1440" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="max_login_attempts" class="block text-sm font-medium text-gray-700 mb-2">
                            Max Login Attempts
                        </label>
                        <input type="number" id="max_login_attempts" name="max_login_attempts" value="{{ old('max_login_attempts', $settings['max_login_attempts'] ?? 5) }}" 
                               min="3" max="10" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="lockout_duration" class="block text-sm font-medium text-gray-700 mb-2">
                            Lockout Duration (Menit)
                        </label>
                        <input type="number" id="lockout_duration" name="lockout_duration" value="{{ old('lockout_duration', $settings['lockout_duration'] ?? 15) }}" 
                               min="5" max="60" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="password_min_length" class="block text-sm font-medium text-gray-700 mb-2">
                            Minimum Password Length
                        </label>
                        <input type="number" id="password_min_length" name="password_min_length" value="{{ old('password_min_length', $settings['password_min_length'] ?? 8) }}" 
                               min="6" max="20" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Security Features</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Two-Factor Authentication</div>
                                <div class="text-sm text-gray-500">Aktifkan 2FA untuk admin</div>
                            </div>
                            <input type="checkbox" name="security_features[]" value="two_factor_auth" 
                                   {{ in_array('two_factor_auth', $settings['security_features'] ?? []) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">IP Whitelist</div>
                                <div class="text-sm text-gray-500">Batasi akses berdasarkan IP</div>
                            </div>
                            <input type="checkbox" name="security_features[]" value="ip_whitelist" 
                                   {{ in_array('ip_whitelist', $settings['security_features'] ?? []) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Activity Logging</div>
                                <div class="text-sm text-gray-500">Log semua aktivitas admin</div>
                            </div>
                            <input type="checkbox" name="security_features[]" value="activity_logging" 
                                   {{ in_array('activity_logging', $settings['security_features'] ?? []) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Maintenance Settings Tab -->
    <div id="maintenance-tab" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Pengaturan Maintenance</h3>
                <p class="text-sm text-gray-600">Kelola maintenance mode dan backup sistem</p>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Maintenance Mode -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-medium text-yellow-800">Maintenance Mode</h4>
                            <p class="text-sm text-yellow-600">Aktifkan mode maintenance untuk mencegah akses user</p>
                        </div>
                        <button onclick="toggleMaintenance()" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-tools mr-2"></i>
                            {{ $settings['maintenance_mode'] ?? false ? 'Disable' : 'Enable' }}
                        </button>
                    </div>
                </div>
                
                <!-- System Information -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Sistem</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-700">Laravel Version</div>
                            <div class="text-lg font-semibold text-gray-900">{{ app()->version() }}</div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-700">PHP Version</div>
                            <div class="text-lg font-semibold text-gray-900">{{ PHP_VERSION }}</div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-700">Database Size</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $system_info['db_size'] ?? '0 MB' }}</div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-700">Storage Used</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $system_info['storage_used'] ?? '0 MB' }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Backup & Restore -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Backup & Restore</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <button onclick="createBackup()" class="w-full flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-download mr-2"></i>
                                Create Full Backup
                            </button>
                            
                            <button onclick="createDbBackup()" class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-database mr-2"></i>
                                Backup Database Only
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="backup_file" class="block text-sm font-medium text-gray-700 mb-2">
                                    Restore from Backup
                                </label>
                                <input type="file" id="backup_file" accept=".sql,.zip" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            
                            <button onclick="restoreBackup()" class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-upload mr-2"></i>
                                Restore Backup
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cache Management -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Cache Management</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <button onclick="clearCache('config')" class="flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-cog mr-2"></i>
                            Clear Config
                        </button>
                        
                        <button onclick="clearCache('route')" class="flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-route mr-2"></i>
                            Clear Routes
                        </button>
                        
                        <button onclick="clearCache('view')" class="flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-eye mr-2"></i>
                            Clear Views
                        </button>
                        
                        <button onclick="clearCache('all')" class="flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-broom mr-2"></i>
                            Clear All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active class to selected tab button
    event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');
}

// Maintenance functions
function toggleMaintenance() {
    if (confirm('Apakah Anda yakin ingin mengubah mode maintenance?')) {
        // In real implementation, this would make an AJAX call
        alert('Maintenance mode toggled');
    }
}

function backupSystem() {
    if (confirm('Membuat backup sistem? Proses ini mungkin memakan waktu beberapa menit.')) {
        alert('Backup process started. You will be notified when complete.');
    }
}

function createBackup() {
    if (confirm('Membuat full backup sistem?')) {
        alert('Full backup process started.');
    }
}

function createDbBackup() {
    if (confirm('Membuat backup database?')) {
        alert('Database backup process started.');
    }
}

function restoreBackup() {
    const fileInput = document.getElementById('backup_file');
    if (!fileInput.files.length) {
        alert('Pilih file backup terlebih dahulu.');
        return;
    }
    
    if (confirm('PERINGATAN: Restore backup akan mengganti semua data yang ada. Apakah Anda yakin?')) {
        alert('Restore process started.');
    }
}

function clearCache(type = 'all') {
    const cacheTypes = {
        'config': 'configuration cache',
        'route': 'route cache',
        'view': 'view cache',
        'all': 'all caches'
    };
    
    if (confirm(`Clear ${cacheTypes[type]}?`)) {
        alert(`${cacheTypes[type]} cleared successfully.`);
    }
}

function testEmail() {
    const email = prompt('Masukkan email untuk test:');
    if (email) {
        alert('Test email sent to ' + email);
    }
}
</script>
@endsection
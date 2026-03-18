@extends('layouts.app')

@section('page-title')
    {{ __('Manage Permissions') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Customers') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Manage Permissions') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <!-- Card Header -->
                    <div class="card-header bg-white py-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-circle bg-gradient-to-r from-blue-600 to-purple-600 p-3 flex items-center justify-center">
                                    <i class="ti ti-lock text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="text-gray-800 font-bold mb-1">{{ __('Manage Permissions') }}</h4>
                                <p class="text-gray-500 text-sm mb-0">{{ __('Configure permissions for') }} <span class="font-semibold text-gray-700">{{ $user->name }}</span></p>
                            </div>
                            <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium" id="selectedCount">
                                {{ count($userPermissions) }} {{ __('selected') }}
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        {{ Form::open(['route' => ['users.update.permission', request()->route('id')], 'method' => 'POST', 'id' => 'permissionForm']) }}
                        
                        <!-- Check All Container -->
                        <div class="border-2 border-green-500 rounded-lg p-4 mb-6 flex items-center justify-between bg-white">
                            <div class="flex items-center">
                                <input type="checkbox" id="check-all" class="w-5 h-5 text-green-600 rounded border-gray-300 focus:ring-green-500 cursor-pointer" 
                                    {{ count($userPermissions) > 0 ? 'checked' : '' }}>
                                <label class="ml-3 font-semibold text-green-600 cursor-pointer text-base" for="check-all">
                                    <i class="ti ti-check mr-1"></i>
                                    {{ __('Select All Permissions') }}
                                </label>
                            </div>
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium" id="checkAllBadge">
                                {{ count($userPermissions) }}/{{ $modules->sum(fn($module) => $module->permissions->count()) }}
                            </span>
                        </div>

                        <!-- Permissions by Module -->
                        @foreach ($modules as $index => $module)
                            @if($module->permissions->count() > 0)
                                <!-- Module Divider (except first) -->
                                @if(!$loop->first)
                                    <div class="flex items-center my-6">
                                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                                        <span class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('MODULE') }}</span>
                                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                                    </div>
                                @endif

                                <!-- Module Card -->
                                <div class="border border-gray-200 rounded-lg overflow-hidden mb-4 hover:shadow-lg transition-shadow duration-200">
                                    <!-- Module Header -->
                                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-4 cursor-pointer" 
                                         data-bs-toggle="collapse" 
                                         data-bs-target="#module{{ $index }}" 
                                         aria-expanded="true">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <i class="ti ti-folder"></i>
                                                <h6 class="font-semibold text-lg mb-0">{{ ucfirst($module->name) }}</h6>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="bg-white bg-opacity-20 text-white text-xs px-3 py-1 rounded-full">
                                                    {{ $module->permissions->count() }} {{ __('permissions') }}
                                                </span>
                                                <i class="ti ti-chevron-up transition-transform duration-200"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Module Body -->
                                    <div id="module{{ $index }}" class="collapse show">
                                        <div class="p-6 bg-gray-50">
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                @foreach ($module->permissions as $permission)
                                                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 hover:border-gray-300">
                                                        <div class="flex items-start">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">
                                                                    @php
                                                                        $icons = [
                                                                            'manage' => 'ti ti-settings',
                                                                            'create' => 'ti ti-plus',
                                                                            'edit' => 'ti ti-edit',
                                                                            'delete' => 'ti ti-trash',
                                                                            'view' => 'ti ti-eye',
                                                                            'export' => 'ti ti-download',
                                                                            'import' => 'ti ti-upload',
                                                                        ];
                                                                        $icon = 'ti ti-lock';
                                                                        foreach($icons as $key => $value) {
                                                                            if(str_contains($permission->name, $key)) {
                                                                                $icon = $value;
                                                                                break;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <i class="{{ $icon }} text-sm"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ml-3 flex-1">
                                                                <div class="flex items-start">
                                                                    <input type="checkbox" 
                                                                           name="permissions[]" 
                                                                           value="{{ $permission->name }}" 
                                                                           id="permission_{{ $permission->id }}" 
                                                                           class="mt-1 w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500 cursor-pointer permission-checkbox"
                                                                           {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                                                                    <label class="ml-2 text-sm text-gray-700 cursor-pointer flex-1" for="permission_{{ $permission->id }}">
                                                                        <span class="font-medium">{{ ucfirst($permission->name) }}</span>
                                                                    </label>
                                                                    @if(in_array($permission->name, $userPermissions))
                                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                                            <i class="ti ti-check text-xs mr-1"></i>
                                                                            {{ __('Selected') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 btn-save">
                                <i class="ti ti-device-floppy mr-2"></i>
                                {{ __('Save Changes') }}
                            </button>
                            <a href="{{ route('users.index') }}" class="px-8 py-3 bg-white text-gray-600 font-semibold rounded-lg border-2 border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <i class="ti ti-x mr-2"></i>
                                {{ __('Cancel') }}
                            </a>
                        </div>
                        
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
<script>
    $(document).ready(function() {
        // Update selected count
        function updateSelectedCount() {
            let checked = $('.permission-checkbox:checked').length;
            let total = $('.permission-checkbox').length;
            
            $('#selectedCount').text(checked + ' / ' + total + ' {{ __("selected") }}');
            $('#checkAllBadge').text(checked + '/' + total);
            
            // Update check all checkbox
            if (checked === total) {
                $('#check-all').prop('checked', true);
                $('#check-all').prop('indeterminate', false);
            } else if (checked === 0) {
                $('#check-all').prop('checked', false);
                $('#check-all').prop('indeterminate', false);
            } else {
                $('#check-all').prop('checked', false);
                $('#check-all').prop('indeterminate', true);
            }
        }
        
        // Check all functionality
        $('#check-all').click(function() {
            $('.permission-checkbox').prop('checked', this.checked);
            updateSelectedCount();
            
            // Show/hide selected badges
            if(this.checked) {
                $('.permission-item .badge').show();
            } else {
                $('.permission-item .badge').hide();
            }
        });
        
        // Individual checkbox click
        $('.permission-checkbox').click(function() {
            updateSelectedCount();
            
            // Toggle selected badge
            let badgeContainer = $(this).closest('.flex').find('.bg-green-100');
            if($(this).is(':checked')) {
                if(badgeContainer.length === 0) {
                    $(this).closest('.flex').append(
                        '<span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800"><i class="ti ti-check text-xs mr-1"></i>{{ __("Selected") }}</span>'
                    );
                } else {
                    badgeContainer.show();
                }
            } else {
                badgeContainer.hide();
            }
        });
        
        // Initialize count
        updateSelectedCount();
        
        // Form submit animation
        $('#permissionForm').on('submit', function() {
            $('.btn-save').prop('disabled', true).html(
                '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>' +
                ' {{ __("Saving...") }}'
            );
        });
        
        // Module collapse icons
        $('.permission-header').each(function() {
            let icon = $(this).find('.ti-chevron-up');
            if(icon.length === 0) {
                $(this).find('.flex.items-center.justify-between').append('<i class="ti ti-chevron-up transition-transform duration-200"></i>');
            }
        });
        
        $('[data-bs-toggle="collapse"]').click(function() {
            let icon = $(this).find('.ti-chevron-up, .ti-chevron-down');
            icon.toggleClass('ti-chevron-up ti-chevron-down');
        });
        
        // Search functionality (optional)
        @if(false)
        // Add search input before check-all container
        let searchHtml = `
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="searchPermissions" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="{{ __('Search permissions...') }}">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="ti ti-search"></i>
                    </div>
                </div>
            </div>
        `;
        $('.check-all-container').before(searchHtml);
        
        $('#searchPermissions').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('.grid > div').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        @endif
    });
</script>
@endpush
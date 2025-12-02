<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-light text-[#26225C] mb-2">Manage Users</h1>
                    <p class="text-gray-600">View and manage all system users</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-all shadow-md">
                        Manage Roles
                    </a>
                    @can('create', App\Models\User::class)
                    <a href="{{ route('admin.users.create') }}" class="mp-form flex items-center gap-2 px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg" data-target="userModal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New User
                    </a>
                    @endcan
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Import Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-[#FFC72C] bg-gradient-to-r from-[#26225C] to-[#3a3770]">
                    <h2 class="text-xl font-medium text-white">Import Users</h2>
                    <p class="text-sm text-yellow-100 mt-0.5">Bulk import users from CSV file</p>
                </div>
                <div class="p-6">
                    <form id="user-import-form" method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" class="flex flex-wrap items-end gap-4">
                        @csrf
                        <div class="flex-1 min-w-[250px]">
                            <label class="block text-sm font-semibold text-[#26225C] mb-2">CSV File</label>
                            <input type="file" name="csv_file" accept=".csv" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white">
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users.template') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                                Download Template
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-[#26225C] hover:bg-[#3a3770] text-white font-semibold rounded-xl transition-all shadow-md">
                                Import CSV
                            </button>
                        </div>
                    </form>
                    <p class="text-xs text-gray-500 mt-3">Format: name,email,password,role,id_number,first_name,middle_name,last_name,birthday,course_and_year</p>
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-container overflow-x-auto">
                @if($users->count() > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#26225C] to-[#3a3770] border-b border-[#FFC72C]">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Role</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Department</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Created</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-white uppercase">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                @php
                                    $userRole = $user->roles->first();
                                    $roleName = $userRole ? $userRole->name : ($user->role ?? 'student');
                                @endphp
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white cursor-pointer" onclick="window.location.href='{{ route('admin.users.show', $user->id) }}'">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#26225C] to-[#3a3770] flex items-center justify-center font-semibold text-white text-sm">
                                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-[#26225C]">{{ $user->name }}</div>
                                                @if($user->id_number)
                                                    <div class="text-xs text-gray-500">ID: {{ $user->id_number }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($roleName==='admin')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                                {{ ucfirst(str_replace('_', ' ', $roleName)) }}
                                            </span>
                                        @elseif($roleName==='faculty')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                                {{ ucfirst(str_replace('_', ' ', $roleName)) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                                {{ ucfirst(str_replace('_', ' ', $roleName)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600">{{ $user->department ?? 'N/A' }}</div>
                                        @if($user->course)
                                            <div class="text-xs text-gray-500">{{ $user->course }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-500">{{ $user->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center text-[#26225C] hover:text-[#FFC72C] transition-colors" onclick="event.stopPropagation()">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-xl">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-[#26225C] mb-2">No users found</h3>
                        <p class="text-sm text-gray-500">Get started by creating a new user or importing from CSV</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- User Modal -->
    <div id="userModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out" style="display: none;">
        <div class="flex justify-center pt-8 px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all duration-300 ease-out modal-content-wrapper">
                <div class="modal-content">
                    <!-- Content will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-container {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-container thead th {
            font-weight: 600;
            text-align: left;
        }
        
        .table-container tbody tr {
            transition: background-color 0.2s;
        }
        
        .table-container tbody tr:hover {
            background-color: rgba(255, 199, 44, 0.05);
        }
    </style>

    <script>
        // Ensure modal displays properly with smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('userModal');
            const wrapper = modal?.querySelector('.modal-content-wrapper');
            
            if (modal && wrapper) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            if (!modal.classList.contains('hidden')) {
                                modal.style.display = 'block';
                                setTimeout(() => {
                                    modal.style.opacity = '1';
                                    wrapper.style.opacity = '1';
                                    wrapper.style.transform = 'translateY(0)';
                                }, 10);
                            } else {
                                modal.style.opacity = '0';
                                wrapper.style.opacity = '0';
                                wrapper.style.transform = 'translateY(-20px)';
                                setTimeout(() => {
                                    modal.style.display = 'none';
                                }, 300);
                            }
                        }
                    });
                });
                observer.observe(modal, { attributes: true, attributeFilter: ['class'] });
                
                wrapper.style.opacity = '0';
                wrapper.style.transform = 'translateY(-20px)';
                wrapper.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            }
        });

        // Import form handler
        document.getElementById('user-import-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<svg class='animate-spin w-4 h-4 mr-1 inline-block' fill='none' viewBox='0 0 24 24'><circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle><path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z'></path></svg> Importing...`;
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success || data.status === 'success') {
                    if (typeof window.toastr !== 'undefined') {
                        window.toastr.success(data.message || 'Import complete!');
                    } else {
                        alert(data.message || 'Import complete!');
                    }
                    setTimeout(() => { window.location.reload(); }, 1200);
                } else {
                    if (typeof window.toastr !== 'undefined') {
                        window.toastr.error(data.message || 'Import failed');
                    } else {
                        alert('Error: ' + (data.message || 'Import failed'));
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error('Failed to import users');
                } else {
                    alert('Failed to import users');
                }
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    </script>
</x-app-layout>

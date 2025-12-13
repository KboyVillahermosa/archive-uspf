<x-guest-layout>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .min-h-screen {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
    </style>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="h-screen w-screen flex overflow-hidden m-0 p-0 fixed inset-0">
        <!-- Left Panel (Promotional) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#26225C] via-[#3a3770] to-[#4a4a8a] relative overflow-hidden">
            <!-- Background Pattern with Curved Lines -->
            <div class="absolute inset-0">
                <!-- Curved line from top right -->
                <svg class="absolute top-0 right-0 w-96 h-96 opacity-20" viewBox="0 0 200 200" fill="none">
                    <path d="M200 0 Q150 50 100 100 T0 200" stroke="#FFC72C" stroke-width="2" fill="none"/>
                </svg>
                <!-- Curved line from bottom left -->
                <svg class="absolute bottom-0 left-0 w-96 h-96 opacity-20" viewBox="0 0 200 200" fill="none">
                    <path d="M0 200 Q50 150 100 100 T200 0" stroke="#FFC72C" stroke-width="2" fill="none"/>
                </svg>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-between p-16 text-white">
                <div>
                    <!-- Logo -->
                    <div class="mb-12">
                        <img src="{{ asset('images/logo.png') }}" alt="USPF Logo" class="h-16 w-auto" />
                    </div>
                    
                    <!-- Greeting -->
                    <h1 class="text-5xl font-bold mb-4">Join USPF Research Archive! 👋</h1>
                    
                    <!-- Tagline -->
                    <p class="text-xl opacity-90 leading-relaxed max-w-md">
                        Create your account to access, share, and contribute to the research community at the University of Southern Philippines Foundation.
                    </p>
                </div>
                
                <!-- Copyright -->
                <div class="text-sm opacity-75">
                    © {{ date('Y') }} USPF Research Archive. All rights reserved.
                </div>
            </div>
        </div>
        
        <!-- Right Panel (Registration Form) -->
        <div class="flex-1 flex flex-col justify-center p-8 lg:p-16 bg-white overflow-y-auto">
            <div class="max-w-md w-full mx-auto">
                <h2 class="text-3xl font-bold text-[#26225C] mb-2">Create Account</h2>
                <p class="text-gray-600 mb-8">Fill in your details to get started</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- First Name -->
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input id="first_name" 
                                    class="block mt-1 w-full" 
                                    type="text" 
                                    name="first_name" 
                                    :value="old('first_name')" 
                                    required 
                                    autofocus 
                                    autocomplete="given-name" />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input id="last_name" 
                                    class="block mt-1 w-full" 
                                    type="text" 
                                    name="last_name" 
                                    :value="old('last_name')" 
                                    required 
                                    autocomplete="family-name" />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('USPF Email Address')" />
                        <x-text-input id="email" 
                                    class="block mt-1 w-full" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autocomplete="username"
                                    placeholder="username_department@uspf.edu.ph" />
                        <p class="mt-1 text-sm text-gray-500">
                            Format: <span class="font-mono text-xs">firstname_lastname_department@uspf.edu.ph</span>
                        </p>
                        <p class="mt-1 text-xs text-gray-400">
                            Example: <span class="font-mono">fvillahermosa_ccs@uspf.edu.ph</span>
                        </p>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Department -->
                    <div>
                        <x-input-label for="department" :value="__('Department')" />
                        <select id="department" 
                                name="department" 
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-[#26225C] focus:ring-[#26225C]">
                            <option value="">Select Department</option>
                            @if(isset($departments))
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>

                    <!-- Program/Course -->
                    <div>
                        <x-input-label for="program" :value="__('Program/Course')" />
                        <select id="program" 
                                name="program" 
                                required
                                disabled
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-[#26225C] focus:ring-[#26225C] disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">Select Department First</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Please select a department first</p>
                        <x-input-error :messages="$errors->get('program')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" 
                                    class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" 
                                    class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" 
                                    required 
                                    autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#26225C]" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-primary-button class="bg-[#26225C] hover:bg-[#3a3770]">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Load departments on page load (if not already loaded from server)
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department');
            const programSelect = document.getElementById('program');

            // If departments are not pre-populated, load them from API
            if (departmentSelect && departmentSelect.options.length <= 1) {
                loadDepartments();
            }

            // Handle department selection change
            if (departmentSelect) {
                departmentSelect.addEventListener('change', function() {
                    const departmentId = this.value;
                    if (departmentId) {
                        loadPrograms(departmentId);
                        programSelect.disabled = false;
                    } else {
                        programSelect.innerHTML = '<option value="">Select Department First</option>';
                        programSelect.disabled = true;
                    }
                });
            }
        });

        // Function to load departments from API
        async function loadDepartments() {
            try {
                const response = await fetch('/api/departments', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const departments = await response.json();
                
                const departmentSelect = document.getElementById('department');
                if (!departmentSelect) return;

                // Only populate if not already populated from server
                if (departmentSelect.options.length <= 1) {
                    departmentSelect.innerHTML = '<option value="">Select Department</option>';
                    
                    departments.forEach(department => {
                        const option = document.createElement('option');
                        option.value = department.id;
                        option.textContent = department.name;
                        departmentSelect.appendChild(option);
                    });

                    // Restore old value if exists
                    const oldValue = departmentSelect.getAttribute('data-old-value');
                    if (oldValue) {
                        departmentSelect.value = oldValue;
                        if (oldValue) {
                            loadPrograms(oldValue);
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading departments:', error);
            }
        }

        // Function to load programs based on selected department
        async function loadPrograms(departmentId) {
            try {
                const response = await fetch(`/api/departments/${departmentId}/programs`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const programs = await response.json();
                
                const programSelect = document.getElementById('program');
                if (!programSelect) return;

                programSelect.innerHTML = '<option value="">Select Program</option>';
                
                programs.forEach(program => {
                    const option = document.createElement('option');
                    option.value = program.id;
                    option.textContent = program.name;
                    programSelect.appendChild(option);
                });

                // Restore old value if exists
                const oldValue = programSelect.getAttribute('data-old-value');
                if (oldValue) {
                    programSelect.value = oldValue;
                }
            } catch (error) {
                console.error('Error loading programs:', error);
                const programSelect = document.getElementById('program');
                if (programSelect) {
                    programSelect.innerHTML = '<option value="">Error loading programs</option>';
                }
            }
        }
    </script>
</x-guest-layout>

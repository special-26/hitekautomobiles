<x-layouts.auth>
    
    <div class="min-h-screen bg-[#090909] text-white flex">

        <!-- Left branding panel -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden
                    bg-gradient-to-br from-[#171717] via-[#101010] to-black
                    flex-col justify-between p-14">

            <div class="absolute -top-32 -left-32 w-96 h-96
                        bg-red-600/20 blur-[120px] rounded-full"></div>

            <div class="absolute bottom-0 right-0 w-96 h-96
                        bg-red-600/10 blur-[120px] rounded-full"></div>

            <!-- Logo -->
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-600 rounded-xl
                                flex items-center justify-center
                                font-black text-2xl shadow-lg shadow-red-600/30">
                        H
                    </div>
                    <div>
                        <h1 class="text-2xl font-black tracking-wider">
                            HITEK <span class="text-red-500">BAYS</span>
                        </h1>
                        <p class="text-xs text-gray-400 tracking-[0.25em]">
                            ALL-IN-ONE WORKSHOP PLATFORM
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main branding -->
            <div class="relative z-10 max-w-xl">
                <span class="inline-flex items-center gap-2 px-4 py-2
                            rounded-full border border-red-500/30
                            bg-red-500/10 text-red-400 text-xs font-bold
                            tracking-widest uppercase">
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                    Workshop Management Reimagined
                </span>

                <h2 class="text-5xl xl:text-6xl font-black leading-tight mt-8">
                    Run Your Workshop.
                    <span class="text-red-500">Grow Your Business.</span>
                </h2>

                <p class="text-gray-400 text-lg mt-6 leading-relaxed">
                    One powerful platform to manage jobs, inventory,
                    customers, teams and workshop growth.
                </p>

                <!-- Features -->
                <div class="grid grid-cols-2 gap-5 mt-12">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-white/5
                                    border border-white/10 flex items-center
                                    justify-center text-red-500">01</span>
                        <span class="text-sm text-gray-300">Job Management</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-white/5
                                    border border-white/10 flex items-center
                                    justify-center text-red-500">02</span>
                        <span class="text-sm text-gray-300">Inventory Control</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-white/5
                                    border border-white/10 flex items-center
                                    justify-center text-red-500">03</span>
                        <span class="text-sm text-gray-300">Customer Management</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-white/5
                                    border border-white/10 flex items-center
                                    justify-center text-red-500">04</span>
                        <span class="text-sm text-gray-300">Business Analytics</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 flex justify-between text-xs text-gray-500">
                <span>© 2026 Hitek Bays</span>
                <span>Built for modern workshops.</span>
            </div>
        </div>

        <!-- Right login panel -->
        <div class="w-full lg:w-1/2 flex items-center justify-center
                    px-6 py-12 sm:px-12 bg-[#0c0c0c]">

            <div class="w-full max-w-md">

                <!-- Mobile logo -->
                <div class="lg:hidden mb-12 text-center">
                    <h1 class="text-3xl font-black tracking-wider">
                        HITEK <span class="text-red-500">BAYS</span>
                    </h1>
                    <p class="text-xs text-gray-500 mt-2 tracking-widest">
                        ALL-IN-ONE WORKSHOP PLATFORM
                    </p>
                </div>

                <div class="mb-10">
                    <p class="text-red-500 text-sm font-bold uppercase
                            tracking-widest mb-3">
                        Welcome Back
                    </p>

                    <h2 class="text-4xl font-bold tracking-tight">
                        Sign in to your account
                    </h2>

                    <p class="text-gray-400 mt-3">
                        Enter your credentials to access your workspace.
                    </p>
                </div>

                <form method="POST" action="{{ route('login.store') }}"
                    class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            Email Address
                        </label>

                        <input type="email" name="email"
                            value="{{ old('email') }}"
                            required autofocus autocomplete="username"
                            placeholder="you@company.com"
                            class="w-full h-14 px-4 rounded-xl
                                    bg-[#171717] border border-white/10
                                    text-white placeholder-gray-600
                                    outline-none transition
                                    focus:border-red-500
                                    focus:ring-2 focus:ring-red-500/20">
                        @error('email')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="text-sm font-medium text-gray-300">
                                Password
                            </label>

                            @if (Route::has('password.request'))
                                <a :href="route('password.request')" wire:navigate
                                class="text-sm text-red-500 hover:text-red-400">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <input type="password" name="password"
                            required autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full h-14 px-4 rounded-xl
                                    bg-[#171717] border border-white/10
                                    text-white placeholder-gray-600
                                    outline-none transition
                                    focus:border-red-500
                                    focus:ring-2 focus:ring-red-500/20">
                        @error('password')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="remember" :checked="old('remember')"
                            class="w-4 h-4 accent-red-600 rounded">
                        <label for="remember" class="text-sm text-gray-400">
                            Remember me
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full h-14 rounded-xl bg-red-600
                                hover:bg-red-700 active:scale-[0.99]
                                text-white font-bold text-base
                                shadow-lg shadow-red-600/20
                                transition-all">
                        Sign In to Hitek Bays
                        <span class="ml-2">→</span>
                    </button>
                </form>

                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-white/10"></div>
                    <span class="text-xs text-gray-600 uppercase tracking-widest">
                        Secure Workspace
                    </span>
                    <div class="flex-1 h-px bg-white/10"></div>
                </div>

                <div class="rounded-xl border border-white/10 bg-[#141414]
                            p-4 flex gap-3 items-center">
                    <div class="w-10 h-10 rounded-lg bg-green-500/10
                                text-green-400 flex items-center justify-center">
                        ✓
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-200">
                            Your workspace is protected
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Secure access for authorized team members.
                        </p>
                    </div>
                </div>

                <p class="text-center text-xs text-gray-600 mt-10">
                    © 2026 Hitek Bays. All rights reserved.
                </p>

            </div>
        </div>
    </div>

</x-layouts.auth>

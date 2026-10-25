<div class="mx-auto max-w-5xl space-y-6 p-4 sm:p-6">
    <div>
        <a href="{{ route('marketing-studio.index') }}"
           class="text-sm font-medium text-slate-500 hover:text-hitek-red">
            ← Back to Marketing Studio
        </a>

        <h1 class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">
            Workshop Brand Profile
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Set your branding once. Your details will be reused in marketing creatives.
        </p>
    </div>

    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        {{-- Workshop identity --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Workshop details
            </h2>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Workshop name *
                    </label>
                    <input id="name" type="text" wire:model="name"
                           placeholder="Hitek Automobiles"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Contact number
                    </label>
                    <input id="phone" type="text" wire:model="phone"
                           placeholder="9216111868"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Email
                    </label>
                    <input id="email" type="email" wire:model="email"
                           placeholder="workshop@example.com"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="website" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Website
                    </label>
                    <input id="website" type="url" wire:model="website"
                           placeholder="https://example.com"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('website') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Workshop address
                    </label>
                    <textarea id="address" rows="2" wire:model="address"
                              placeholder="Plot no. 131, Industrial Area Phase I, Chandigarh, 160002"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white"></textarea>
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Logo --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Workshop logo
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Use a clear PNG or JPG logo. Transparent PNG works best for creatives.
            </p>

            <div class="mt-4 flex flex-col gap-5 sm:flex-row sm:items-center">
                <div class="flex h-28 w-40 items-center justify-center overflow-hidden rounded-xl border border-dashed border-slate-300 bg-slate-50 p-3 dark:border-slate-600 dark:bg-slate-800">
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" alt="New logo preview"
                             class="max-h-full max-w-full object-contain">
                    @elseif ($profile?->logo_path)
                        <img src="{{ asset('storage/' . $profile->logo_path) }}"
                             alt="Workshop logo"
                             class="max-h-full max-w-full object-contain">
                    @else
                        <span class="text-sm text-slate-400">Logo preview</span>
                    @endif
                </div>

                <div>
                    <input id="logo" type="file" wire:model="logo" accept="image/png,image/jpeg,image/webp"
                           class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-red-50 file:px-4 file:py-2 file:font-semibold file:text-hitek-red dark:text-slate-300">
                    @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="logo" class="mt-2 text-sm text-slate-500">
                        Uploading preview...
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Maximum file size: 2 MB.</p>
                </div>
            </div>
        </section>

        {{-- Brand colours --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Brand colours
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                These colours will be used as defaults in your marketing templates.
            </p>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="primary_color" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Primary colour
                    </label>
                    <div class="flex items-center gap-3">
                        <input id="primary_color" type="color" wire:model.live="primary_color"
                               class="h-11 w-16 cursor-pointer rounded border border-slate-300">
                        <input type="text" wire:model="primary_color"
                               class="w-32 rounded-lg border border-slate-300 px-3 py-2 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    </div>
                    @error('primary_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="secondary_color" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Secondary colour
                    </label>
                    <div class="flex items-center gap-3">
                        <input id="secondary_color" type="color" wire:model.live="secondary_color"
                               class="h-11 w-16 cursor-pointer rounded border border-slate-300">
                        <input type="text" wire:model="secondary_color"
                               class="w-32 rounded-lg border border-slate-300 px-3 py-2 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    </div>
                    @error('secondary_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Social media and CTA --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Social media and call-to-action
            </h2>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label for="instagram_handle" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Instagram handle or URL
                    </label>
                    <input id="instagram_handle" type="text" wire:model="instagram_handle"
                           placeholder="@hitekautomobiles"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('instagram_handle') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="facebook_handle" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Facebook page or URL
                    </label>
                    <input id="facebook_handle" type="text" wire:model="facebook_handle"
                           placeholder="Hitek Automobiles"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('facebook_handle') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="default_call_to_action" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Default call-to-action *
                    </label>
                    <input id="default_call_to_action" type="text" wire:model="default_call_to_action"
                           placeholder="Book your service today"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('default_call_to_action') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" wire:loading.attr="disabled"
                    class="rounded-lg bg-hitek-red px-6 py-3 font-semibold text-white transition hover:bg-hitek-red-hover disabled:opacity-60">
                <span wire:loading.remove wire:target="save">Save Brand Profile</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>
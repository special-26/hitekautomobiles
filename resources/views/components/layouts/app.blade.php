{{-- <x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar> --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white relative">
        {{ $slot }}

        {{-- <button class="fixed z-40 bottom-10 right-10 rounded-full w-16 h-16 bg-red-800 text-white flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262M8 11.75a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5zM7.25 9A.75.75 0 0 1 8 8.25h8a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9" clip-rule="evenodd"/></svg>
        </button> --}}

        <div x-data="{modalIsOpen: false}">
            <button x-on:click="modalIsOpen = true" type="button" class="fixed z-40 bottom-10 right-10 rounded-full w-16 h-16 bg-red-800 text-white flex items-center justify-center cursor-pointer hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m13.629 20.472l-.542.916c-.483.816-1.69.816-2.174 0l-.542-.916c-.42-.71-.63-1.066-.968-1.262c-.338-.197-.763-.204-1.613-.219c-1.256-.021-2.043-.098-2.703-.372a5 5 0 0 1-2.706-2.706C2 14.995 2 13.83 2 11.5v-1c0-3.273 0-4.91.737-6.112a5 5 0 0 1 1.65-1.651C5.59 2 7.228 2 10.5 2h3c3.273 0 4.91 0 6.113.737a5 5 0 0 1 1.65 1.65C22 5.59 22 7.228 22 10.5v1c0 2.33 0 3.495-.38 4.413a5 5 0 0 1-2.707 2.706c-.66.274-1.447.35-2.703.372c-.85.015-1.275.022-1.613.219c-.338.196-.548.551-.968 1.262M8 11.75a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5zM7.25 9A.75.75 0 0 1 8 8.25h8a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 9" clip-rule="evenodd"/></svg>
            </button>
            <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                <!-- Modal Dialog -->      
                <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100" class="flex w-[40vw] flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface bg-white rounded-2xl"> 
                    <!-- Dialog Header -->
                    <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4">
                        <h3 id="defaultModalTitle" class="font-semibold text-xl tracking-wide text-on-surface-strong text-gray-800">Book Appointment</h3>
                        <button x-on:click="modalIsOpen = false" aria-label="close modal" class="text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Dialog Body -->
                    <div class="px-4 py-8"> 
                        <div class="w-full">
  <div class="mx-auto grid  px-6 pb-20">
    <div class="">
      <p class="font-serif text-xl font-bold text-blue-900">Select a service</p>
      <div class="mt-4 grid max-w-3xl gap-x-4 gap-y-3 sm:grid-cols-1 md:grid-cols-2">
        <div class="relative">
          <input class="peer hidden" id="radio_1" type="radio" name="radio" checked />
          <span class="absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white peer-checked:border-red-400"></span>
          <label class="flex h-full cursor-pointer flex-col rounded-lg p-4 shadow-lg shadow-slate-100 peer-checked:bg-red-600 peer-checked:text-white text-gray-800" for="radio_1">
            <span class="mt-2- font-medium">Car Service</span>
            <span class="text-xs uppercase">1 Hour</span>
          </label>
        </div>
        <div class="relative">
          <input class="peer hidden" id="radio_2" type="radio" name="radio" />
          <span class="absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white peer-checked:border-red-400"></span>

          <label class="flex h-full cursor-pointer flex-col rounded-lg p-4 shadow-lg shadow-slate-100 peer-checked:bg-red-600 peer-checked:text-white text-gray-800" for="radio_2">
            <span class="mt-2 font-medium">Insurance Cover</span>
            <span class="text-xs uppercase">1 Hour</span>
          </label>
        </div>
      </div>
    </div>

    <div class="">
      <p class="mt-8 font-serif text-xl font-bold text-blue-900">Select a date</p>
      <div class="relative mt-4 w-56">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
          <svg aria-hidden="true" class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
        </div>
        <input datepicker="" datepicker-orientation="bottom" autofocus="autofocus" type="text" class="datepicker-input block w-full rounded-lg border border-red-300 bg-red-50 p-2.5 pl-10 text-red-800 outline-none ring-opacity-30 placeholder:text-red-800 focus:ring focus:ring-red-300 sm:text-sm" placeholder="Select date" />
      </div>
    </div>

    <div class="">
      <p class="mt-8 font-serif text-xl font-bold text-blue-900">Select a time</p>
      <div class="mt-4 grid grid-cols-4 gap-2 lg:max-w-xl">
        <button class="rounded-lg bg-red-100 px-4 py-2 font-medium text-red-900 active:scale-95">12:00</button>
        <button class="rounded-lg bg-red-100 px-4 py-2 font-medium text-red-900 active:scale-95">14:00</button>
        <button class="rounded-lg bg-red-700 px-4 py-2 font-medium text-white active:scale-95">09:00</button>
        <button class="rounded-lg bg-red-100 px-4 py-2 font-medium text-red-900 active:scale-95">12:00</button>
        <button class="rounded-lg bg-red-100 px-4 py-2 font-medium text-red-900 active:scale-95">15:00</button>
        <button class="rounded-lg bg-red-100 px-4 py-2 font-medium text-red-900 active:scale-95">12:00</button>
        <button class="rounded-lg bg-red-100 px-4 py-2 font-medium text-red-900 active:scale-95">14:00</button>
        <button class="rounded-lg bg-red-100 px-4 py-2 font-medium text-red-900 active:scale-95">12:00</button>
      </div>
    </div>
  </div>
</div>

                    </div>
                    <!-- Dialog Footer -->
                    <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                        <button class="mt-8 w-56 rounded-full border-8 border-red-500 bg-red-600 px-10 py-4 text-lg font-bold text-white transition hover:translate-y-1 cursor-pointer">Book Now</button>
                    </div>
                </div>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
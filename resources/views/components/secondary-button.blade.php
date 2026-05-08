<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-3 py-3 bg-slate-btn border border-transparent rounded-8 font-semibold text-base text-white h-12 hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-slate-btn focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 shadow-l1 hover:shadow-l2']) }}>
    {{ $slot }}
</button>

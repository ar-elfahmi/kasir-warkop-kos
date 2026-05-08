<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-3 py-3 bg-error-red border border-transparent rounded-8 font-semibold text-base text-white h-12 hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-error-red focus:ring-offset-2 transition ease-in-out duration-150 shadow-l1 hover:shadow-l2']) }}>
    {{ $slot }}
</button>

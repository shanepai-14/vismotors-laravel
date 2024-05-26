<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex 
    items-center px-4 py-2 bg-white border 
    border-transparent rounded-md font-semibold text-xs 
    uppercase tracking-widest text-red-400 hover:bg-red-400 focus:bg-red-400 
    active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 
    focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

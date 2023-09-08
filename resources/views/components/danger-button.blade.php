<button
        {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex font-semibold items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md text-white hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
  {{ $slot }}
</button>

<x-app-layout>
  <!-- header -->
  <div class="mb-12 bg-white px-4 py-2 shadow">
    <!-- Breadcrumb -->
    <nav class="flex py-3 text-gray-700">
      <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <x-link class="text-sm" href="{{ route('dashboard') }}">{{ __('Home') }}</x-link>
        </li>
        <li class="inline-flex items-center">
          <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
          <x-link class="text-sm" href="{{ route('project.message.index', ['project' => $header['id']]) }}">{{ $header['name'] }}</x-link>
        </li>
        <li>
          <div class="flex items-center">
            <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Add a message') }}</span>
          </div>
        </li>
      </ol>
    </nav>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-6xl overflow-hidden">
      <form class="grid grid-cols-[2fr_1fr] gap-4 px-4" method="POST" action="{{ route('project.message.store', ['project' => $header['id']]) }}">
        @csrf
        <!-- left -->
        <div>
          <div class="relative bg-white px-6 py-4 shadow sm:rounded-lg">
            <!-- Title -->
            <div class="mb-8">
              <x-input-label class="mb-1" for="title" :value="__('Title of the message')" />

              <x-text-input class="block w-full"
                            id="title"
                            name="title"
                            type="text"
                            :value="old('title')"
                            required
                            autofocus />

              <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <!-- Description -->
            <div class="mb-4">
              <x-textarea-markdown class="block w-full min-h-[350px]" body="" placeholder="{{ __('What would you like to share today?') }}" :minHeight="'min-h-[380px]'" />

              <x-input-error class="mt-2" :messages="$errors->get('body')" />
            </div>
          </div>
        </div>

        <!-- right -->
        <div>
          <div class="rounded-lg shadow">
            <div class="flex items-center justify-between rounded-t-lg border-b bg-white px-6 py-4">
              <x-link href="{{ route('project.message.index', ['project' => $header['id']]) }}" class="text-sm font-medium text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white">
                {{ __('Back') }}
              </x-link>

              <x-primary-button class="ml-4">
                {{ __('Save') }}
              </x-primary-button>
            </div>

            <!-- markdown help -->
            <div class="prose rounded-b-lg bg-gray-50 px-6 py-4 text-sm">
              <p>{{ __('We support Markdown, which lets you add formatting to your message.') }}</p>
              <p>{{ __('Quick reference:') }}</p>
              <ul>
                <li><code># H1</code></li>
                <li><code>## H2</code></li>
                <li><code>{{ __('**bold text**') }}</code></li>
                <li><code>{{ __('*italicized text*') }}</code></li>
              </ul>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>

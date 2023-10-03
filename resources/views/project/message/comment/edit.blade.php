<x-app-layout>
  <!-- header -->
  <div class="mb-12">
    <div class="bg-white px-4 py-2 shadow">
      <!-- Breadcrumb -->
      <nav class="flex py-3 text-gray-700">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <x-link class="text-sm"
                    href="{{ route('dashboard') }}"
                    wire:navigate>{{ __('Home') }}</x-link>
          </li>
          <li class="inline-flex items-center">
            <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
            <x-link class="text-sm"
                    href="{{ route('project.message.index', ['project' => $header['id']]) }}"
                    wire:navigate>{{ $header['name'] }}</x-link>
          </li>
          <li class="inline-flex items-center">
            <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
            <x-link class="text-sm"
                    href="{{ route('project.message.show', ['project' => $header['id'], 'message' => $view['message_id']]) }}"
                    wire:navigate>{{ $view['message_title'] }}</x-link>
          </li>
          <li>
            <div class="flex items-center">
              <x-heroicon-s-chevron-right class="mr-2 h-4 w-4 text-gray-400" />
              <span class="ml-1 text-sm text-gray-500 dark:text-gray-400 md:ml-2">{{ __('Edit comment') }}</span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto max-w-6xl overflow-hidden">
      <form class="grid grid-cols-[2fr_1fr] gap-4 px-4"
            method="POST"
            action="{{ route('project.message.comment.update', ['project' => $header['id'], 'message' => $view['message_id'], 'comment' => $view['id']]) }}">
        @csrf
        @method('PUT')

        <!-- left -->
        <div>
          <div class="relative bg-white px-6 py-4 shadow sm:rounded-lg">
            <!-- Description -->
            <div class="mb-4">
              <livewire:textarea-markdown :body="$view['body']" />

              <x-input-error class="mt-2"
                             :messages="$errors->get('body')" />
            </div>
          </div>
        </div>

        <!-- right -->
        <div>
          <div class="rounded-lg shadow">
            <div class="flex items-center justify-between rounded-t-lg border-b bg-white px-6 py-4">
              <x-link class="text-sm font-medium text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white"
                      href="{{ route('project.message.show', ['project' => $header['id'], 'message' => $view['message_id']]) }}"
                      wire:navigate>
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
                <li><code>**bold text**</code></li>
                <li><code>*italicized text*</code></li>
              </ul>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>

<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <div class="mx-auto max-w-2xl bg-white shadow sm:rounded-lg">
      <!-- header -->
      <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2">
        <h2 class="text-lg font-medium text-gray-900">
          {{ __('All the messages') }}
        </h2>

        <div>
          <x-primary-link wire:navigate.hover
                          :href="route('project.message.create', ['project' => $view['project_id']])">{{ __('Add a message') }}</x-primary-link>
        </div>
      </div>

      <!-- list of messages -->
      @if (count($view['messages']) > 0)
        <ul class="w-full"
            v-if="data.messages.length > 0">
          @foreach ($view['messages'] as $message)
            <li class="flex py-4 pl-4 pr-6 hover:bg-slate-50 last:hover:rounded-b-lg"
                wire:key="{{ $message['id'] }}">
              <!-- unread status -->
              <div class="unread"
                   v-if="!message.read"
                   v-tooltip="__('The message is unread')"></div>

              <div class="ml-1">
                <x-link class="mb-2 inline-block text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white"
                        href="{{ route('project.message.show', ['project' => $header['id'], 'message' => $message['id']]) }}"
                        wire:navigate>
                  {{ $message['title'] }}
                </x-link>

                <!-- author + nb of comments -->
                <div class="flex text-sm">
                  <!-- user name -->
                  <div class="group mr-4 flex items-center">
                    <x-avatar class="mr-2 h-4 w-4"
                              :data="$message['author']['avatar']" />

                    <x-link class="text-gray-600 group-hover:underline"
                            href="{{ route('user.show', ['user' => $message['author']['id']]) }}">
                      {{ $message['author']['name'] }}
                    </x-link>
                  </div>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <!-- blank state -->
        <div class="px-4 py-6 text-center">
          <h3 class="mb-2 text-lg font-medium text-gray-900">{{ __("You haven't written a message yet.") }}</h3>
          <p class="mb-5 text-gray-500">{{ __('Get started by adding your first message.') }}</p>
          <img class="mx-auto block h-60 w-60"
               src="/img/messages.png"
               alt="" />
        </div>
      @endif
    </div>
  </div>
</x-app-layout>

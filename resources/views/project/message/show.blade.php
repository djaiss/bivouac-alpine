<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <!-- body -->
    <div class="grid grid-cols-[3fr_1fr] gap-4 px-4">
      <!-- left -->
      <div>
        <!-- message -->
        <div class="relative mb-4 bg-white shadow sm:rounded-lg">
          <!-- message body -->
          <div class="border-b px-6 py-8">
            <!-- message header -->
            <h1 class="mb-3 text-center text-3xl">{{ $view['title'] }}</h1>

            <!-- avatar + name -->
            <div class="mb-8 flex items-center justify-center text-sm">
              <x-avatar class="mr-2 w-5"
                        :data="$view['author']['avatar']" />

              <x-link class="mr-4 text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white"
                      href="{{ route('user.show', ['user' => $view['author']['id']]) }}">
                {{ $view['author']['name'] }}
              </x-link>
              <p>{{ $view['created_at'] }}</p>
            </div>

            <!-- message body -->
            <div class="prose mx-auto">{!! $view['body'] !!}</div>
          </div>

          <!-- message footer -->
          <div class="rounded-b-lg bg-gray-50 p-3">
            {{-- <Reactions :reactions="data.reactions" :url="data.url" /> --}}
          </div>
        </div>

        <!-- tasks -->
        {{-- <TaskList class="mb-8" :task-list="data.task_list" :context="'message'" /> --}}

        <!-- comments -->
        {{-- <Comments :comments="data.comments" :url="data.url" /> --}}
      </div>

      <!-- right -->
      <div>
        <div class="rounded-lg shadow">
          <div class="flex items-center justify-between rounded-t-lg border-b bg-white px-6 py-4">
            <x-link class="text-sm font-medium text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white"
                    href="{{ route('project.message.edit', ['project' => $header['id'], 'message' => $view['id']]) }}"
                    wire:navigate>
              {{ __('Edit') }}
            </x-link>
          </div>

          <!-- markdown help -->
          <div class="prose rounded-b-lg bg-gray-50 px-6 py-4 text-sm">
            <x-link class="cursor-pointer font-medium text-red-700 underline hover:rounded-sm hover:bg-red-700 hover:text-white"
                    href="{{ route('project.message.delete', ['project' => $header['id'], 'message' => $view['id']]) }}"
                    wire:navigate>
              {{ __('Delete') }}
            </x-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

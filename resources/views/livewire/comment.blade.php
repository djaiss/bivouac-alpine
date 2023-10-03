<div>
  <!-- existing comments -->
  @if ($comments->count() > 0)
    <ol class="relative mx-auto max-w-3xl border-l border-gray-200 dark:border-gray-700">
      @foreach ($comments as $comment)
        <li class="mb-10 ml-4"
            wire:key="{{ $comment['id'] }}">
          <div
               class="border-bg-900 absolute -left-1.5 mt-1.5 h-3 w-3 rounded-full border bg-gray-300 dark:border-gray-900 dark:bg-gray-700">
          </div>

          <!-- avatar + time -->
          <div class="mb-2 flex justify-between text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
            <div class="flex items-center">
              <div class="mr-3 flex items-center">
                <x-avatar class="mr-2 w-5"
                          :data="$comment['author']['avatar']" />

                <x-link href="{{ route('user.show', ['user' => $comment['author']['id']]) }}">
                  {{ $comment['author']['name'] }}
                </x-link>
              </div>

              <time>{{ $comment['created_at'] }}</time>
            </div>

            <!-- actions -->
            <div class="relative"
                 x-data="{ dropdownOpen: false }">
              <button class="inline-flex items-center justify-center rounded-md border-gray-100 px-3 py-2 text-sm font-medium text-neutral-700 transition-colors hover:border-gray-400 hover:bg-white focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                      @click="dropdownOpen=true">
                <x-heroicon-o-ellipsis-horizontal class="h-5 w-5 text-gray-500 hover:text-gray-700" />
              </button>

              <div class="absolute left-1/2 top-0 z-50 mt-12 w-56 -translate-x-1/2"
                   x-show="dropdownOpen"
                   @click.away="dropdownOpen=false"
                   x-transition:enter="ease-out duration-200"
                   x-transition:enter-start="-translate-y-2"
                   x-transition:enter-end="translate-y-0"
                   x-cloak>
                <div class="mt-1 rounded-md border border-neutral-200/70 bg-white p-1 text-neutral-700 shadow-md">
                  <a class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50"
                     href="{{ route('project.message.comment.edit', ['project' => $comment['project_id'], 'message' => $comment['message_id'], 'comment' => $comment['id']]) }}">
                    <x-heroicon-o-pencil class="mr-2 h-4 w-4" />
                    <span>{{ __('Edit') }}</span>
                  </a>
                  <a class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50"
                     href="{{ route('project.message.comment.delete', ['project' => $comment['project_id'], 'message' => $comment['message_id'], 'comment' => $comment['id']]) }}">
                    <x-heroicon-o-trash class="mr-2 h-4 w-4" />
                    <span>{{ __('Delete') }}</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- comment -->
          <div class="rounded-lg bg-white shadow">
            <div class="border-b px-4 py-4">
              <div class="prose">{!! $comment['body'] !!}</div>
            </div>

            <!-- message footer -->
            <div class="rounded-b-lg bg-gray-50 p-3">
              <livewire:projects.manage-comment-reactions wire:key="{{ $comment['id'] }}"
                                                          :commentId="$comment['id']"
                                                          :reactions="$comment['reactions']" />
            </div>
          </div>
        </li>
      @endforeach
    </ol>
  @endif

  <!-- post a comment box -->
  <div>
    <form wire:submit="save">

      <div class="rounded-lg bg-white px-4 py-4 shadow">
        <p class="mb-3 font-bold">{{ __('Add a comment') }}</p>

        <livewire:textarea-markdown wire:model="value"
                                    :minHeight="'min-h-[100px]'" />

        <!-- actions -->
        <div class="mt-4 flex justify-start">
          <x-primary-button class="mr-2">
            {{ __('Save') }}
          </x-primary-button>

          <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200"
                wire:click="cancel()">
            {{ __('Cancel') }}
          </span>
        </div>
      </div>
    </form>
  </div>
</div>

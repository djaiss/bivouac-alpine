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

          </div>

          <!-- comment -->
          <div class="rounded-lg bg-white shadow">
            <div class="border-b px-4 py-4">
              <div class="prose">{!! $comment['body'] !!}</div>
            </div>

            <!-- message footer -->
            <div class="rounded-b-lg bg-gray-50 p-3">
              {{-- <Reactions :reactions="comment.reactions" :url="comment.url" /> --}}
            </div>
          </div>

          <!-- edit comment -->
          {{-- <div v-else class="rounded-lg bg-white px-4 py-4 shadow">
        <form @submit.prevent="update(comment)">
          <ul v-if="form.body" class="mb-5 inline-block text-sm">
            <li
              @click="showWriteTab"
              class="inline cursor-pointer rounded-l-md border px-3 py-1 pr-2"
              :class="{ 'border-blue-600 text-blue-600': activeTab === 'write' }">
              {{ __('Write') }}
            </li>
            <li
              @click="showPreviewTab"
              class="inline cursor-pointer rounded-r-md border-b border-r border-t px-3 py-1"
              :class="{ 'border-l border-blue-600 text-blue-600': activeTab === 'preview' }">
              {{ __('Preview') }}
            </li>
          </ul>

          <!-- write mode -->
          <div v-if="activeTab === 'write'">
            <TextArea
              @esc-key-pressed="editedComment = ''"
              id="description"
              class="block w-full"
              required
              autogrow
              v-model="form.body" />

            <div v-if="form.body" class="mt-4 flex justify-start">
              <PrimaryButton class="mr-2" :loading="loadingState" :disabled="loadingState">
                {{ __('Save') }}
              </PrimaryButton>

              <span
                @click="editedComment = ''"
                class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200">
                {{ __('Cancel') }}
              </span>
            </div>
          </div>

          <!-- preview mode -->
          <div v-if="activeTab === 'preview'" class="w-full rounded-lg border bg-gray-50 p-4">
            <div v-html="formattedBody" class="prose"></div>
          </div>
        </form>
      </div> --}}
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

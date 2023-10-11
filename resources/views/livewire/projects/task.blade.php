<div class="grid grid-cols-[3fr_1fr] gap-4 px-4">
  <!-- left -->
  <div>
    <!-- task -->
    <div class="relative mb-4 bg-white shadow sm:rounded-lg">
      <!-- body of the task  -->
      <div class="border-b px-6 py-6" x-data="{
          isEditingTitle: false,
          isEditingDescription: false,
          title: '{{ $task['title'] }}',
          description: '{{ $task['description'] }}',
          focus: function() {
              const textInput = this.$refs.textInput;
              textInput.focus();
              textInput.select();
          }
      }">
        <!-- task header -->
        <div x-show="!isEditingTitle" class="flex cursor-pointer items-start rounded-lg border border-transparent px-2 py-2 hover:border-gray-200">

          <input wire:click="checkTask({{ $task['id'] }})"
                 {{ $task['is_completed'] ? 'checked="checked"' : '' }}
                 class="checkbox-title relative mr-3 h-6 w-6 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                 style="top: 3px;"
                 type="checkbox">

          <p class="text-xl" x-on:click="isEditingTitle = true; $nextTick(() => focus())">{{ $task['title'] }}</p>
        </div>

        <!-- edit title box -->
        <form wire:submit="save()"
              x-show="isEditingTitle"
              class="flex items-center justify-between"
              x-cloak>
          <x-text-input class="mr-3 w-full"
                        id="title"
                        name="title"
                        type="text"
                        wire:model="title"
                        x-model="title"
                        x-ref="textInput"
                        required
                        x-on:keydown.escape="isEditingTitle = false"
                        :value="old('title')" />

          <!-- actions -->
          <div class="flex items-center">
            <x-primary-button class="mr-2" x-on:click="isEditingTitle = false">
              {{ __('Save') }}
            </x-primary-button>

            <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200" x-on:click="isEditingTitle = false">
              {{ __('Cancel') }}
            </span>
          </div>
        </form>

        <!-- description -->
        <div x-on:click="isEditingDescription = true" x-show="!isEditingDescription && description != ''" class="ml-3 cursor-pointer rounded-lg p-2 hover:bg-gray-100">
          <div class="prose" :key="$task['id']">{!! $task['description'] !!}</div>
        </div>

        <div x-show="!isEditingDescription && description == ''"
             x-on:click="isEditingDescription = true"
             class="mt-4 cursor-pointer text-sm text-gray-600 hover:underline"
             x-cloak>
          {{ __('+ add description') }}
        </div>

        <!-- edit description -->
        <form wire:submit="saveDescription()"
              x-show="isEditingDescription"
              class="mt-6"
              x-cloak>
          <livewire:textarea-markdown wire:model="description" :minHeight="'min-h-[100px]'" />

          <!-- actions -->
          <div class="mt-4 flex justify-start">
            <x-primary-button x-on:click="isEditingDescription = false" class="mr-2">
              {{ __('Save') }}
            </x-primary-button>

            <span x-on:click="isEditingDescription = false" class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200">
              {{ __('Cancel') }}
            </span>
          </div>
        </form>
      </div>

      <!-- message footer -->
      <div class="rounded-b-lg bg-gray-50 p-3">
        <livewire:projects.manage-task-reactions wire:key="{{ $task['id'] }}" :taskId="$task['id']" :reactions="$task['reactions']" />
      </div>
    </div>

    <!-- comments -->
    {{-- <Comments :comments="task.comments" :url="task.url" /> --}}
  </div>

  <!-- right -->
  <div>
    <div class="rounded-lg shadow">
      <!-- assignees -->
      {{-- <div class="rounded-t-lg border-b bg-white px-6 py-4">
        <p class="mb-2 text-xs">{{ __('Assigned to') }}</p>

        <!-- list of assignees -->
        <div v-if="task.assignees.length > 0">
          <div
            v-for="assignee in localAssignees"
            :key="assignee.id"
            class="group mb-4 flex items-center justify-between rounded-lg px-2 py-1 hover:bg-gray-100">
            <div class="flex items-center">
              <Avatar
                v-tooltip="assignee.name"
                :data="assignee.avatar"
                :url="assignee.url"
                class="h-6 w-6 cursor-pointer rounded-full" />

              <Link
                :href="assignee.url"
                class="ml-2 text-sm text-blue-700 underline hover:rounded-sm hover:bg-blue-700 hover:text-white">
                {{ assignee.name }}
              </Link>
            </div>

            <XMarkIcon
              @click="unassign(assignee)"
              class="hidden h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block" />
          </div>
        </div>

        <!-- links to add assignees -->
        <ul class="text-sm">
          <li
            @click="showSearch()"
            v-if="!searchShown"
            class="mr-2 inline cursor-pointer text-gray-600 hover:underline">
            {{ __('Add someone') }}
          </li>
          <li
            @click="assign(loggedUser)"
            v-if="!isSelfAssigned"
            class="inline cursor-pointer text-gray-600 hover:underline">
            {{ __('Assign yourself') }}
          </li>
        </ul>

        <!-- search and add assignee -->
        <div v-if="searchShown">
          <!-- search field -->
          <div class="relative">
            <TextInput
              type="text"
              autocomplete="off"
              :placeholder="__('Type a few letters')"
              class="mt-2 block w-full"
              v-model="form.term"
              autofocus
              @input="searchUsers()"
              @keydown.esc="searchShown = false"
              required />

            <MagnifyingGlassIcon
              v-if="!form.term"
              class="absolute right-3 top-3 h-5 w-5 text-gray-400 transition ease-in-out" />
            <XMarkIcon
              @click="cancelSearch()"
              v-else
              class="absolute right-3 top-3 h-5 w-5 cursor-pointer text-gray-400 transition ease-in-out" />
          </div>

          <!-- search results -->
          <div v-if="searchResults.length > 0" class="mt-3 rounded-lg border">
            <div
              v-for="result in searchResults"
              :key="result.id"
              class="item-list flex items-center border-b border-gray-200 px-5 py-2 hover:bg-slate-50">
              <Avatar
                v-tooltip="result.name"
                :data="result.avatar"
                class="mr-2 h-6 w-6 cursor-pointer rounded-full" />

              <span
                @click="assign(result)"
                class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200">
                {{ result.name }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="prose rounded-b-lg bg-gray-50 px-6 py-4 text-sm">
        <span
          @click="destroy()"
          class="cursor-pointer font-medium text-red-700 underline hover:rounded-sm hover:bg-red-700 hover:text-white">
          {{ __('Delete') }}
        </span>
      </div> --}}
    </div>
  </div>
</div>

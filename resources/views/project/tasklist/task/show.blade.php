<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <div class="grid grid-cols-[3fr_1fr] gap-4 px-4">
      <!-- left -->
      <div>
        <!-- task -->
        <div class="relative mb-4 bg-white shadow sm:rounded-lg">
          <!-- body of the task  -->
          <div class="border-b px-6 py-6" x-data="{
                isEditing: false,
                title: '{{ $view['title'] }}',
                focus: function() {
                    const textInput = this.$refs.textInput;
                    textInput.focus();
                    textInput.select();
                }
            }" x-cloak>
            <!-- task header -->
            <div x-show="!isEditing" class="flex cursor-pointer items-start rounded-lg border border-transparent px-2 py-2 hover:border-gray-200">

              <input wire:click="checkTask({{ $view['id'] }})"
                     {{ $view['is_completed'] ? 'checked="checked"' : '' }}
                     class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 checkbox-title relative mr-3 h-6 w-6"
                     style="top: 3px;"
                     type="checkbox">

              <p class="text-xl" @click="isEditing = true">{{ $view['title'] }}</p>
            </div>

            <!-- edit title box -->
            <form x-show="isEditing" class="flex items-center justify-between">
              <x-text-input class="mr-3 w-full"
                  id="title"
                  name="title"
                  type="text"
                  wire:model="title"
                  x-model="title"
                  x-ref="textInput"
                  required
                  x-on:keydown.escape="isEditing = false"
                  :value="old('title')" />

              <!-- actions -->
              <div class="flex items-center">
                <x-primary-button class="mr-2" x-on:click="isEditing = false">
                  {{ __('Save') }}
                </x-primary-button>

                <span class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200" x-on:click="isEditing = false">
                  {{ __('Cancel') }}
                </span>
              </div>
            </form>

            <!-- description -->
            {{-- <div v-if="description && !editDescriptionShown" class="ml-3 rounded-lg p-2 hover:bg-gray-100"> --}}
            <div class="ml-3 rounded-lg p-2 hover:bg-gray-100">
              <div class="prose">{!! $view['description'] !!}</div>
            </div>
            {{-- <div
              v-if="!description && !editDescriptionShown"
              @click="editDescription()"
              class="mt-4 cursor-pointer text-sm text-gray-600 hover:underline">
              {{ $t('+ add description') }}
            </div> --}}

            <!-- edit description -->
            {{-- <form v-if="editDescriptionShown" @submit.prevent="update()" class="mt-6">
              <ul v-if="form.body" class="mb-5 inline-block text-sm">
                <li
                  @click="showWriteTab"
                  class="inline cursor-pointer rounded-l-md border px-3 py-1 pr-2"
                  :class="{ 'border-blue-600 text-blue-600': activeTab === 'write' }">
                  {{ $t('Write') }}
                </li>
                <li
                  @click="showPreviewTab"
                  class="inline cursor-pointer rounded-r-md border-b border-r border-t px-3 py-1"
                  :class="{ 'border-l border-blue-600 text-blue-600': activeTab === 'preview' }">
                  {{ $t('Preview') }}
                </li>
              </ul>

              <!-- write mode -->
              <div v-if="activeTab === 'write'">
                <TextArea
                  @esc-key-pressed="editDescriptionShown = false"
                  id="description"
                  ref="bodyInput"
                  class="block w-full"
                  required
                  autogrow
                  v-model="form.body" />

                <div v-if="form.body" class="mt-4 flex justify-start">
                  <PrimaryButton class="mr-2" :loading="loadingState" :disabled="loadingState">
                    {{ $t('Save') }}
                  </PrimaryButton>

                  <span
                    @click="editDescriptionShown = false"
                    class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200">
                    {{ $t('Cancel') }}
                  </span>
                </div>
              </div>

              <!-- preview mode -->
              <div v-if="activeTab === 'preview'" class="w-full rounded-lg border bg-gray-50 p-4">
                <div v-html="formattedDescription" class="prose"></div>
              </div>
            </form> --}}
          </div>

          <!-- message footer -->
          <div class="rounded-b-lg bg-gray-50 p-3">
            {{-- <Reactions :reactions="task.reactions" :url="task.url" /> --}}
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
            <p class="mb-2 text-xs">{{ $t('Assigned to') }}</p>

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
                {{ $t('Add someone') }}
              </li>
              <li
                @click="assign(loggedUser)"
                v-if="!isSelfAssigned"
                class="inline cursor-pointer text-gray-600 hover:underline">
                {{ $t('Assign yourself') }}
              </li>
            </ul>

            <!-- search and add assignee -->
            <div v-if="searchShown">
              <!-- search field -->
              <div class="relative">
                <TextInput
                  type="text"
                  autocomplete="off"
                  :placeholder="$t('Type a few letters')"
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
              {{ $t('Delete') }}
            </span>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

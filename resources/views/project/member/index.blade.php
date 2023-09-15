<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- project header -->
    <x-project.header :data="$header" />

    <!-- help -->
    <div class="mx-auto flex max-w-2xl bg-white px-4 py-2 text-sm shadow sm:rounded-lg">
      <x-heroicon-o-question-mark-circle class="h-6 w-6 shrink-0 pe-2 text-gray-600" />
      <p>
        {{
          __(
            'If the project is public, anyone can take part without having to be a formal member. On the other hand, private projects are only accessible and open to members.',
          )
        }}
      </p>
    </div>

    <!-- list of potential members -->
    {{-- <div v-if="potentialMembersShown" class="mx-auto max-w-2xl bg-white shadow sm:rounded-lg">
      <!-- header -->
      <div class="flex items-center justify-between border-b px-4 py-2">
        <p class="font-bold">{{ __('Add a user to this project') }}</p>
        <XMarkIcon
          @click="potentialMembersShown = false"
          class="h-5 w-5 cursor-pointer rounded text-gray-400 hover:bg-gray-300 hover:text-gray-600 group-hover:block" />
      </div>
      <div v-if="loadingUsers">{{ __('Loading users...') }}</div>

      <!-- list -->
      <ul class="max-h-40 overflow-auto">
        <li
          v-for="user in localPotentialMembers"
          :key="user.id"
          class="flex items-center justify-between py-4 pl-4 pr-6 hover:bg-slate-50 last:hover:rounded-b-lg">
          <!-- user name -->
          <div>{{ user.name }}</div>

          <!-- add button -->
          <span
            @click="store(user)"
            class="flex cursor-pointer rounded-md border border-gray-300 bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:border-solid hover:border-gray-500 hover:bg-gray-200">
            {{ __('Add') }}
          </span>
        </li>
      </ul>
    </div> --}}

    <div class="mx-auto max-w-2xl bg-white shadow sm:rounded-lg">
      <!-- header -->
      <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2">
        <h2 class="text-lg font-medium text-gray-900">
          {{ __('Project members') }}
        </h2>

        <div>
          {{-- <PrimaryButton v-if="!potentialMembersShown" @click.prevent="showPotentialMembers()">
            {{ __('Add member') }}
          </PrimaryButton> --}}
        </div>
      </div>

      <!-- list of users -->
      <ul class="w-full">
        @foreach ($view['members'] as $member)
        <li wire:key="{{ $member['id'] }}"
          class="flex items-center justify-between py-4 pl-4 pr-6 hover:bg-slate-50 last:hover:rounded-b-lg">
          <div class="group mr-4 flex items-center">
            <x-avatar class="mr-2 h-6 w-6 rounded" :data="$member['avatar']" />

            <x-link :href="'member.url.show'">
              {{ $member['name'] }}
            </x-link>
          </div>
        </li>
        @endforeach
      </ul>

      <!-- blank state -->
      <div v-else class="px-4 py-6 text-center">
        <h3 class="mb-2 text-lg font-medium text-gray-900">{{ __("You haven't written a message yet.") }}</h3>
        <p class="mb-5 text-gray-500">{{ __('Get started by adding your first message.') }}</p>
        <img src="/img/messages.png" class="mx-auto block h-60 w-60" alt="" />
      </div>
    </div>
  </div>
</x-app-layout>

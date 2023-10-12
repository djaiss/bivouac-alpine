<x-app-layout>
  <!-- header -->
  <div class="mx-auto mb-6 max-w-4xl px-12 pt-6 sm:px-6 lg:px-8">
    <div class="flex justify-center bg-white px-4 shadow sm:rounded-lg">
      <div class="flex items-center">
        <img class="mr-6 h-24 w-24" src="/img/settings.png" alt="settings" />
        <p class="text-lg font-bold">{{ __('Account settings') }}</p>
      </div>
    </div>
  </div>

  <div class="pb-12">
    <div class="mx-auto flex max-w-4xl sm:px-6 lg:px-8">
      <div class="w-full space-y-6">
        <div class="bg-white shadow sm:rounded-lg">
          <ul>
            <li class="flex items-center border-b border-gray-200 px-4 py-2 hover:rounded-t-lg hover:bg-slate-50">
              <span class="mr-4 rounded border border-yellow-400 bg-yellow-100 px-1">👥</span>
              <x-link href="{{ route('settings.user.index') }}">{{ __('Add or remove users') }}</x-link>
            </li>
            <li class="flex items-center border-b border-gray-200 px-4 py-2 hover:bg-slate-50">
              <span class="mr-4 rounded border border-yellow-400 bg-yellow-100 px-1">🏣</span>
              <x-link href="{{ route('settings.organization.index') }}">
                {{ __("Update organization's name") }}</x-link>
            </li>
            <li class="flex items-center border-b border-gray-200 px-4 py-2 hover:bg-slate-50">
              <span class="mr-4 rounded border border-yellow-400 bg-yellow-100 px-1">🏢</span>
              <x-link href="{{ route('settings.office.index') }}">{{ __('Manage offices') }}</x-link>
            </li>
            <li class="flex items-center border-b border-gray-200 px-4 py-2 hover:bg-slate-50">
              <span class="mr-4 rounded border border-yellow-400 bg-yellow-100 px-1">👮‍♂️</span>
              <x-link href="{{ route('settings.role.index') }}">{{ __('Manage roles') }}</x-link>
            </li>
            <li class="flex items-center px-4 py-2 hover:rounded-b-lg hover:bg-slate-50">
              <span class="mr-4 rounded border border-yellow-400 bg-yellow-100 px-1">🗑️</span>
              <x-link href="{{ route('settings.organization.delete') }}">{{ __('Delete organization') }}</x-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

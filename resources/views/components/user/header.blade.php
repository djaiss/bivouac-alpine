@props(['data'])

<div>
  <div class="bg-white shadow sm:rounded-lg">
    <!-- avatar, name, description -->
    <div class="flex border-b border-gray-200 p-4">
      <!-- avatar -->
      <x-avatar class="mr-4 h-24 w-24 rounded"
                :data="$data['avatar']" />

      <div class="w-full">
        <h1 class="text-xl font-bold">{{ $data['name'] }}</h1>
      </div>
    </div>

    <!-- menu -->
    <div class="px-4">
      <div class="text-center font-medium text-gray-500 dark:text-gray-400">
        <ul class="-mb-px flex flex-wrap">
          <li class="mr-2">
            <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300"
               href="#">
              {{ __('Presentation') }}
            </a>
          </li>
          <li class="mr-2">
            <a class="active inline-block rounded-t-lg border-b-2 border-blue-600 p-4 text-blue-600 dark:border-blue-500 dark:text-blue-500"
               href="#">
              {{ __('Work') }}
            </a>
          </li>
          <li class="mr-2">
            <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300"
               href="#">
              {{ __('Performance') }}
            </a>
          </li>
          <li class="mr-2">
            <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300"
               href="#">
              {{ __('Administration') }}
            </a>
          </li>
          <li class="mr-2">
            <a class="inline-block rounded-t-lg border-b-2 border-transparent p-4 hover:border-blue-300 hover:text-blue-600 dark:hover:text-gray-300"
               href="#">
              {{ __('Settings') }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

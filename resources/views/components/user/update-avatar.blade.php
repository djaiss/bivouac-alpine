@props(['data'])

<section>
  <header class="w-full">
    <h2 class="border-b border-gray-200 px-4 py-2 text-lg font-medium text-gray-900">
      {{ __('Profile picture') }}
    </h2>
  </header>

  <div class="flex">
    <!-- instructions -->
    <div class="mr-8 w-96 p-4 text-sm">
      {{ __(
          'You can choose to display an avatar either by using the default one based on your nickname or by uploading a photo.',
      ) }}
    </div>

    <div class="p-4">
      <form class="max-w-3xl space-y-6"
            method="post"
            action="{{ route('user.avatar.update', ['user' => $data['id']]) }}">
        @csrf
        @method('PUT')

        <x-primary-button>
          {{ __('Generate new avatar') }}
        </x-primary-button>
      </form>
    </div>
  </div>
</section>

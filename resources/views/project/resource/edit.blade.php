<form hx-post="{{ $view['url']['update'] }}"
  hx-target="#resources"
  class="flex items-end justify-between w-full">

  @csrf
  @method('PUT')

  <div class="mr-2 flex w-full">
    <!-- label -->
    <div class="mr-2 w-full">
      <x-input-label class="mb-1"
                      for="label"
                      :optional="true"
                      :value="__('Label')" />

      <x-text-input class="block w-full"
                    id="label"
                    name="label"
                    type="text"
                    autofocus
                    required
                    :value="old('label', $view['label'])" />

      <x-input-error class="mt-2" :messages="$errors->get('label')" />
    </div>

    <!-- link -->
    <div class="w-full">
      <x-input-label class="mb-1" for="link" :value="__('URL/link')" />

      <x-text-input class="block w-full"
                    id="link"
                    name="link"
                    type="text"
                    :value="old('link', $view['link'])"
                    required />

      <x-input-error class="mt-2" :messages="$errors->get('link')" />
    </div>
  </div>

  <!-- actions -->
  <div class="flex items-center">
    <x-primary-button>
      {{ __('Save') }}
    </x-primary-button>

    <x-secondary-button hx-target="#resources" hx-get="{{ $view['url']['index'] }}">
      {{ __('Cancel') }}
    </x-secondary-button>
  </div>
</form>

<x-app-layout>
  <div class="mx-auto mb-6 max-w-7xl space-y-6 px-12 pt-6 sm:px-6 lg:px-8">
    <!-- user header -->
    <x-user.header :data="$header" />

    <!-- body -->
    <div class="pb-12">
      <div class="mx-auto flex max-w-7xl sm:px-6 lg:px-8">
        <div class="w-full space-y-6">
          <div class="bg-white shadow sm:rounded-lg">
            {{-- <UpdateProfileInformationForm :data="data" /> --}}
          </div>

          <!-- update avatar -->
          <div class="bg-white shadow sm:rounded-lg">
            {{-- <UpdateAvatarForm :data="data" /> --}}
            <x-user.update-avatar :data="$view"></x-user.update-avatar>
          </div>

          <div class="bg-white shadow sm:rounded-lg">
            {{-- <UpdateDateOfBirthForm :data="data" /> --}}
          </div>

          <div class="bg-white shadow sm:rounded-lg">
            {{-- <UpdatePasswordForm /> --}}
          </div>

          <div class="bg-white shadow sm:rounded-lg">
            {{-- <DeleteUserForm class="max-w-xl" /> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

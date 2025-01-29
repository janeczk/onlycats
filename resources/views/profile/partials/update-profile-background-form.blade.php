{{--
<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
  <div class="max-w-xl">
      <h3 class="text-lg font-medium text-gray-900">{{ __('Update Background Image') }}</h3>

      <!-- Wyświetlanie aktualnego tła -->

<div
  id="background-container"
  class="relative bg-gray-200 h-48 rounded flex items-center justify-center mb-4"
  style="background-size: cover; background-position: center; {{ isset($background) ? 'background-image: url('.$background.');' : '' }}"
>
  <p class="text-gray-500">
      {{ isset($background) ? __('Background image set successfully!') : __('No background image set.') }}
  </p>
</div>


        <!-- Formularz przesyłania -->
        <form action="{{ route('profile.updateBackground') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="background_image" :value="__('Choose an image')" />
                <x-text-input id="background_image" name="background_image" type="file" accept="image/*" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('background_image')" />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Upload Image') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
--}}

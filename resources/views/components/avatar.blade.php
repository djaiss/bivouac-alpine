@props(['data', 'url' => null, 'hover' => true])

<div class="relative"
     x-data="{
         hoverCardHovered: false,
         hoverCardDelay: 200,
         hoverCardLeaveDelay: 500,
         hoverCardTimout: null,
         hoverCardLeaveTimeout: null,
         hoverCardEnter() {
             clearTimeout(this.hoverCardLeaveTimeout);
             if (this.hoverCardHovered) return;
             clearTimeout(this.hoverCardTimout);
             this.hoverCardTimout = setTimeout(() => {
                 this.hoverCardHovered = true;
             }, this.hoverCardDelay);
         },
         hoverCardLeave() {
             clearTimeout(this.hoverCardTimout);
             if (!this.hoverCardHovered) return;
             clearTimeout(this.hoverCardLeaveTimeout);
             this.hoverCardLeaveTimeout = setTimeout(() => {
                 this.hoverCardHovered = false;
             }, this.hoverCardLeaveDelay);
         }
     }"
     @mouseover="hoverCardEnter()"
     @mouseleave="hoverCardLeave()">

  <!-- the actual avatar -->
  @if ($url)
    <x-link :href="url">
      @if ($data['type'] === 'svg')
        <div {{ $attributes->merge(['class' => 'rounded cursor-pointer']) }}>
          {!! $data['content'] !!}
        </div>
      @else
        <img src="{{ $data['content'] }}"
             alt="avatar"
             {{ $attributes->merge(['class' => 'rounded cursor-pointer']) }} />
      @endif
    </x-link>
  @else
    <div>
      @if ($data['type'] === 'svg')
        <div {{ $attributes->merge(['class' => 'rounded cursor-pointer']) }}>
          {!! $data['content'] !!}
        </div>
      @else
        <img src="{{ $data['content'] }}"
             alt="avatar"
             {{ $attributes->merge(['class' => 'rounded cursor-pointer']) }} />
      @endif
    </div>
  @endif

  <div class="absolute left-1/2 top-0 z-30 mt-5 w-[365px] max-w-lg -translate-x-1/2 translate-y-3"
       x-show="hoverCardHovered"
       x-cloak>
    <div class="flex h-auto w-[full] items-start space-x-3 rounded-md border border-neutral-200/70 bg-white p-5 shadow-sm"
         x-show="hoverCardHovered"
         x-transition>
      @if ($data['type'] === 'svg')
        <div {{ $attributes->merge(['class' => 'rounded-full w-20 h-20']) }}>
          {!! $data['content'] !!}
        </div>
      @else
        <img src="{{ $data['content'] }}"
             alt="avatar"
             {{ $attributes->merge(['class' => 'rounded-full w-20 h-20']) }} />
      @endif

      <div class="relative">
        <p class="mb-1 font-bold">{{ $data['name'] }}</p>
        <p class="mb-1 text-sm text-gray-600">The creative platform for developers. Community, tools, products, and more
        </p>
        <p class="flex items-center space-x-1 text-xs text-gray-400">
          <svg class="h-5 w-5"
               xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
          </svg>
          <span>Joined June 2020</span>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="relative"
     x-data="{
         tooltipVisible: false,
         tooltipText: 'The project is private',
         tooltipArrow: true,
         tooltipPosition: 'top',
     }"
     x-init="$refs.content.addEventListener('mouseenter', () => { tooltipVisible = true; });
     $refs.content.addEventListener('mouseleave', () => { tooltipVisible = false; });">

  <div class="absolute w-auto text-sm"
       x-ref="tooltip"
       x-show="tooltipVisible"
       :class="{
           'top-0 left-1/2 -translate-x-1/2 -mt-0.5 -translate-y-full': tooltipPosition ==
               'top',
           'top-1/2 -translate-y-1/2 -ml-0.5 left-0 -translate-x-full': tooltipPosition ==
               'left',
           'bottom-0 left-1/2 -translate-x-1/2 -mb-0.5 translate-y-full': tooltipPosition ==
               'bottom',
           'top-1/2 -translate-y-1/2 -mr-0.5 right-0 translate-x-full': tooltipPosition == 'right'
       }"
       x-cloak>
    <div class="relative rounded bg-black bg-opacity-90 px-2 py-1 text-white"
         x-show="tooltipVisible"
         x-transition>
      <p class="block flex-shrink-0 whitespace-nowrap text-xs"
         x-text="tooltipText"></p>
      <div class="absolute inline-flex items-center justify-center overflow-hidden"
           x-ref="tooltipArrow"
           x-show="tooltipArrow"
           :class="{
               'bottom-0 -translate-x-1/2 left-1/2 w-2.5 translate-y-full': tooltipPosition ==
                   'top',
               'right-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px translate-x-full': tooltipPosition ==
                   'left',
               'top-0 -translate-x-1/2 left-1/2 w-2.5 -translate-y-full': tooltipPosition ==
                   'bottom',
               'left-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px -translate-x-full': tooltipPosition == 'right'
           }">
        <div class="h-1.5 w-1.5 transform bg-black bg-opacity-90"
             :class="{
                 'origin-top-left -rotate-45': tooltipPosition == 'top',
                 'origin-top-left rotate-45': tooltipPosition ==
                     'left',
                 'origin-bottom-left rotate-45': tooltipPosition ==
                     'bottom',
                 'origin-top-right -rotate-45': tooltipPosition == 'right'
             }">
        </div>
      </div>
    </div>
  </div>

  <x-heroicon-s-lock-closed class="mr-2 h-4 w-4 text-blue-500"
                            x-ref="content" />
</div>

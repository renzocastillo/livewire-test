@props([
    'leadingAddon'=>false,
])
<div class="flex rounded-md shadow-sm">
    @if($leadingAddon)
        <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
            {{ $leadingAddon }}
        </span>
    @endif
    <input
       {{$attributes}}
       class="{{$leadingAddon ?'rounded-none rounded-r-md': ''}} flex-1 form-input block w-full min-w-0 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
</div>

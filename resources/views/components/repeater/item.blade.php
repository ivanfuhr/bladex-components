@push($stackName)
    <div @class([$itemClasses]) data-repeater-item>{{ $slot }}</div>
@endpush

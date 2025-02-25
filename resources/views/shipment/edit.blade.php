@extends('layouts.main')

@section('content')
    <form method="POST" action="{{ route('shipment.store', ['delivery' => $delivery ?? 1]) }}" id="shipmentInfo">
        @csrf
        <div class="card">
            <div class="card-header">
                Packages
            </div>
            <div id="parcel-list" class="card-body gap-2">
                @forelse($parcels ?? [] as $key => $parcel)
                    @include('shipment.components.parcel', ['key' => $key, 'order' => $order])
                @empty
                    @include('shipment.components.parcel', ['key' => 1, 'order' => $order])
                @endforelse

                <button type="button" id="addParcel" class="btn btn-primary mt-1">
                    Add parcel
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            submit
        </button>
    </form>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            const parcelTemplate = $('.parcel').clone();
            let parcelIndex = $('#parcel-list').find('.parcel').length + 1;

            $(document).on('click', '#addParcel', function () {
                let newParcel = parcelTemplate.clone();
                newParcel.find('.parcel-index').text(parcelIndex);
                newParcel = $('<div>').append(newParcel).html().replace(/parcel-\d+/g, 'parcel-' + parcelIndex);
                $('#addParcel').before(newParcel);
                parcelIndex++;
            });

            $(document).on('click', '.removeParcel', function () {
                $(this).parents('.parcel').remove();
            });

            $(document).on('submit', '#shipmentInfo', function (e) {
                // e.preventDefault();

            });
        });
    </script>
@endpush

<div class="card parcel mb-2">
    <div class="card-header d-flex justify-content-between">
                    <span class="fw-bold">
                        Parcel <span class="parcel-index">{{ $key + 1 }}</span>
                    </span>
        <button class="btn btn-danger btn-sm removeParcel">Remove</button>
    </div>
    <div class="card-body container">
        <div class="row">
            <div class="col-4">
                <span class="text-secondary">Add to pallet:</span>
                <select class="form-select mt-1" name="parcels[parcel-{{$key}}][pallet]">
                    @foreach($pallets ?? [] as $key => $pallet)
                        <option value="{{ $key }}"
                                @if($parcel->pallet->id === $pallet->id) selected @endif>{{ $key }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-8">
                <span class="text-secondary">Select products to add:</span>
                <ul class="list-group mt-1">
                    @foreach($order->orderContents as $contentKey => $content)
                        <li class="list-group-item py-1 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input parcel-{{ $key }}-selected" type="checkbox"
                                       name="parcels[parcel-{{$key}}][contents][{{$contentKey}}][selected]">
                                <label class="form-check-label"
                                       for="product1">{{ $content->product->name }}</label>
                            </div>
                            <div class="input-group" style="width: 150px;">
                                <input type="number" class="form-control" value="1"
                                       name="parcels[parcel-{{$key}}][contents][{{$contentKey}}][quantity]">
                                <input type="hidden" class="form-control" value="{{ $content->product->weight }}"
                                       name="parcels[parcel-{{$key}}][contents][{{$contentKey}}][weight]">
                                <span class="input-group-text">/{{ $content->quantity }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

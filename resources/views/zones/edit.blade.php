@extends('layouts.main')

@section('content')

    <!-- Create shipment parcel -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="length" class="form-label">Length (cm)</label>
                                <input type="number" class="form-control" id="length" placeholder="Enter length"
                                       step="0.1" min="0" required>
                            </div>
                            <div class="col">
                                <label for="width" class="form-label">Width (cm)</label>
                                <input type="number" class="form-control" id="width" placeholder="Enter width"
                                       step="0.1" min="0" required>
                            </div>
                            <div class="col">
                                <label for="height" class="form-label">Height (cm)</label>
                                <input type="number" class="form-control" id="height" placeholder="Enter height"
                                       step="0.1" min="0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control" id="weight" placeholder="Enter weight" step="0.01"
                                   min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-primary">Generate Label</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

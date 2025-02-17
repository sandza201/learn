<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel and Pallet Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Parcel and Pallet Management</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Single Form -->
    <form method="post" action="{{ route('shipment.store', [$delivery->id]) }}">
        @csrf

        <!-- Add Parcel Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Add Parcel</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="parcelWeight" class="form-label">Parcel Weight (kg)</label>
                    <input type="number" class="form-control" id="parcelWeight">
                </div>
                <button type="button" class="btn btn-primary" id="addParcel">Add Parcel</button>
            </div>
        </div>

        <!-- Display Parcels -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Parcels</h5>
            </div>
            <div class="card-body">
                <ul id="parcelList" class="list-group">
                    @foreach($parcels as $key => $parcel)
                        <li class="list-group-item d-flex justify-content-between align-items-center parcel-{{ $parcel->id }}">
                            <span class="title">
                                Parcel {{ $key + 1 }} - {{ $parcel->weight }} kg
                            </span>
                            <input type="hidden" name="parcels[{{ $parcel->id }}][weight]"
                                   value="{{ $parcel->weight }}" class="parcel-weight">
                            <button type="button" class="btn btn-danger btn-sm removeParcel">Remove</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Add Pallet Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Add Pallet</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="palletType" class="form-label">Select Pallet Type</label>
                    <select class="form-control" id="palletType" name="palletType">
                        <option value="standard">Standard</option>
                        <option value="custom">Custom</option>
                        <option value="heavy-duty">Heavy Duty</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="parcelsInPallet" class="form-label">Select Parcels</label>
                    <select multiple class="form-control" id="parcelsInPallet" name="parcelsInPallet[]">
                        <!-- Parcels will be dynamically added here -->
                        @php
                            $p = []; // Initialize a global counter for parcels
                        @endphp
                        @foreach($parcels as $key => $parcel)
                            {{ $p[$parcel->id] = $key }}
                            <option value="{{ $parcel->id }}" class="parcel-{{ $parcel->id }}"
                                    @if($parcel->pallet) disabled @endif>
                                Parcel {{ $key + 1 }} - {{ $parcel->weight }} kg
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="button" class="btn btn-primary" id="addPallet">Add Pallet</button>
            </div>
        </div>

        <!-- Display Pallets -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Pallets</h5>
            </div>
            <div class="card-body">
                <ul id="palletList" class="list-group">
                    @foreach($pallets as $palletKey => $pallet)
                        <li class="list-group-item pallet">
                            <div class="d-flex justify-content-between align-items-center">
                                Pallet {{ $palletKey + 1 }} (Total Weight: {{ $pallet->weight }} kg)
                                <input type="hidden" name="pallets[{{ $pallet->id }}][weight]"
                                       value="{{ $pallet->weight }}">
                                <button type="button" class="btn btn-danger btn-sm removePallet">Remove</button>
                            </div>

                            <ul>
                                @foreach($pallet->parcels as $parcelKey => $parcel)
                                    <li class="pallet-parcels parcel-{{ $parcel->id }}">
                                        <span class="title">
                                            Parcel {{ $p[$parcel->id] + 1 }} - {{ $parcel->weight }} kg
                                        </span>
                                        <input type="hidden"
                                               name="pallets[{{ $pallet->id }}][parcels][{{ $parcel->id }}][weight]"
                                               value="{{ $parcel->weight }}">
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Hidden Inputs for Parcels and Pallets -->
        <div id="hiddenInputs"></div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Save Shipment</button>
    </form>
</div>

<script>
    $(document).ready(function () {

        // Add Parcel
        $('#addParcel').click(function () {

            const weight = $('#parcelWeight').val();
            if (weight) {
                const key = $('#parcelList').find('.removeParcel').length;
                $('#parcelList').append(
                    `<li class="list-group-item d-flex justify-content-between align-items-center parcel-new_${key}">
                        <span class="title">
                            Parcel ${key + 1} - ${weight} kg
                        </span>
                        <input type="hidden" name="parcels[new_${key}][weight]" value="${weight}" class="parcel-weight">
                        <button type="button" class="btn btn-danger btn-sm removeParcel">Remove</button>
                    </li>`
                );
                $('#parcelWeight').val('');
                updateParcelDropdown(weight, `new_${key}`)
            }
        });

        // Add Pallet
        $('#addPallet').click(function () {
            const selectedParcels = $('#parcelsInPallet').find(':selected');

            if (selectedParcels.length > 0) {
                let totalWeight = 0;
                const selectedParcelValues = [];

                const key = $('#palletList .removePallet').length;

                selectedParcels.each(function () {
                    const parcelWeight = parseFloat($(this).val());
                    const parcelKey = $(this).attr('class').match(/parcel-[\w-]+/)[0];
                    const id = parseInt(parcelKey.replace('parcel-', '').replace('new_', ''));

                    totalWeight += parcelWeight;

                    selectedParcelValues.push(
                        `<li class="pallet-parcels ${parcelKey}">
                            Parcel ${id + 1} - ${parcelWeight} kg
                            <input type="hidden" name="pallets[new_${key}][parcels][${id}][weight]" value="${parcelWeight}">
                        </li>`
                    );

                    $(this).prop('disabled', true);
                });


                $('#palletList').append(
                    `<li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            Pallet ${key + 1} (Total Weight: ${totalWeight} kg)
                             <input type="hidden" name="pallets[new_${key}][weight]" value="${totalWeight}">
                            <button class="btn btn-danger btn-sm removePallet">Remove</button>
                        </div>
                        <ul>
                            ${selectedParcelValues.join('')}
                        </ul>
                    </li>`
                );
            }

            unselectParcels();
        });

        // Remove Parcel
        $(document).on('click', '.removeParcel', function (e) {
            e.preventDefault();
            const parcelId = $(this).parent('li').attr('class').match(/parcel-[\w-]+/)[0];
            $("." + parcelId).remove();

            $("#parcelList").find('li').each(function (key) {
                const weight = $(this).find(".parcel-weight").val();
                const text = `Parcel ${key + 1} - ${weight} kg`;
                $(this).find('.title').text(text);
                const pId = $(this).attr('class').match(/parcel-[\w-]+/)[0];
                console.log(pId);
                $("option." + pId).each(function () {
                    console.log($(this));
                    $(this).text(text);
                })
            })

            $('#palletList').find('.pallet').each(function () {
                if ($(this).find(".pallet-parcels").length < 1) {
                    $(this).remove();
                }
            })
        });

        // Remove Pallet
        $(document).on('click', '.removePallet', function (e) {
            e.preventDefault();
            const pallet = $(this).parents('li');
            pallet.find('li.pallet-parcels').each(function () {
                const parcelId = $(this).attr('class').match(/parcel-[\w-]+/)[0];
                $('#parcelsInPallet').find("option." + parcelId).each(function () {
                    $(this).prop('disabled', false);
                })
            });
            pallet.remove();
            unselectParcels();
        });

        function unselectParcels() {
            $('#parcelsInPallet').find('option').each(function () {
                $(this).prop('selected', false);
            });
        }

        // Update Parcel Dropdown
        function updateParcelDropdown(weight, key) {
            $('#parcelsInPallet').append(
                `<option value="${weight}" class="parcel-${key}">
                   Parcel ${parseInt(key.replace('new_', '')) + 1} - ${weight} kg
                </option>`
            );
        }
    });
</script>
</body>
</html>

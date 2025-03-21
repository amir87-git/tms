@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-5">
  <div class="text-center mb-5">
    <h3 class="fw-bold text-primary">Start Trip for Shipment No.{{ $shipment->id }}</h3>
  </div>

  <div class="form-container border border-2 border-primary rounded p-4 shadow-sm bg-white">
    <form action="{{ route('trips.store') }}" method="POST" id="tripForm">
      @csrf
      <input type="hidden" name="shipment_id" value="{{ $shipment->id }}">

      <div class="mb-3">
        <label for="start_time" class="form-label">Start Time</label>
        <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
      </div>

      <!-- Shipment Details -->
      <div class="row mb-4">
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <div><strong>Client Name:</strong> {{ $shipment->client_name }}</div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <div><strong>Phone:</strong> {{ $shipment->phone }}</div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <div><strong>Vehicle No:</strong> {{ $shipment->vehicle->vehicle_typ ?? 'N/A' }} {{ $shipment->vehicle->vehicle_no ?? 'N/A' }}</div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <div><strong>Trailer No:</strong> {{ $shipment->vehicle->trailer_no ?? 'N/A' }}</div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <div><strong>Start Meter Reading:</strong> {{ $str_mtr_rdng ?? 'Not Available' }}</div>
          <input type="hidden" name="str_mtr_rdng" value="{{ $str_mtr_rdng ?? 0 }}">
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <label for="end_mtr_rdng"><strong>End Meter Reading:</strong></label>
          <input type="number" class="form-control form-control-sm" id="end_mtr_rdng" name="end_mtr_rdng" placeholder="Enter reading" required onchange="calculateTotalKm()">
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <div><strong>Total Kilometers:</strong></div>
          <div id="total_km_display" class="fs-5 fw-bold text-success">0</div>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3">
          <label for="fuel" class="form-label"><strong>Fuel Needed</strong></label>
          <select class="form-select form-select-sm" name="fuel" id="fuel" required onchange="toggleFuelInput()">
            <option value="" disabled selected>Fuel Needed</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select>
        </div>
        <div class="col-12 col-md-6 col-lg-3 mb-3" id="qty_container" style="display: none;">
          <label for="qty" class="form-label"><strong>Qty Ltr</strong></label>
          <input type="number" class="form-control form-control-sm" id="qty" name="qty" placeholder="Enter quantity in Liters" min="0" step="any">
        </div>
      </div>

      <!-- Hidden fields -->
      <input type="hidden" name="overall_time" id="overall_time">
      <input type="hidden" name="total_km" id="total_km">
      <input type="hidden" name="end_time" id="end_time">

      <!-- Shipment Details Table -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle" id="shipments">
          <thead class="table-secondary">
            <tr>
              <th>Location</th>
              <th>In Date & Time</th>
              <th>Out Date & Time</th>
              <th>Total Time</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input class="form-control" name="location[]" placeholder="Enter location" required></td>
              <td>
                <div class="d-flex gap-2 flex-wrap">
                  <input type="date" class="form-control" name="in_date[]" required onchange="calculateTotalTime(this)">
                  <input type="time" class="form-control" name="in_time[]" required onchange="calculateTotalTime(this)">
                  <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('in', event)">In</button>
                </div>
              </td>
              <td>
                <div class="d-flex gap-2 flex-wrap">
                  <input type="date" class="form-control" name="out_date[]" required onchange="calculateTotalTime(this)">
                  <input type="time" class="form-control" name="out_time[]" required onchange="calculateTotalTime(this)">
                  <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('out', event)">Out</button>
                </div>
              </td>
              <td>
                <span class="total-time-display">00:00:00</span>
                <input type="hidden" name="total_time[]" class="total-time-input" value="00:00:00">
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                  <i class="bi bi-trash me-1"></i> Remove
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Button Group -->
      <div class="text-end mt-3">
        <div class="d-flex justify-content-end gap-3 flex-wrap">
          <button type="submit" class="btn btn-primary btn-md px-4 py-2 shadow-sm rounded">
            <i class="bi bi-check-circle me-1"></i> Submit
          </button>
          <button type="button" class="btn btn-success btn-md px-4 py-2 shadow-sm rounded" onclick="addTripDetails()">
            <i class="bi bi-plus-circle me-1"></i> Add Trip
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  let startTime = new Date().getTime();
  let saveTimeout;
    let pendingRequest = null;

    function debounceSaveDraft() {
      clearTimeout(saveTimeout);
      saveTimeout = setTimeout(saveDraft, 500);
    }

    function saveDraft() {
      const formData = $('#tripForm').serialize();
      if (pendingRequest) pendingRequest.abort();

      pendingRequest = $.ajax({
        url: '/save-draft',
        method: 'POST',
        data: formData,
        success: function(response) {
          console.log('Draft saved:', response.message);
        },
        error: function(xhr) {
          if (xhr.statusText !== 'abort') {
            console.error('Error saving draft:', xhr.responseText);
          }
        },
        complete: function() {
          pendingRequest = null;
        }
      });
    }

  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#tripForm').on('input change', 'input, select', debounceSaveDraft);

    // Load draft
    const shipmentId = $('input[name="shipment_id"]').val();
    $.ajax({
      url: `/get-draft/${shipmentId}`,
      method: 'GET',
      success: function(response) {
        if (response && response.message !== 'No incomplete drafts found.') {
          $('#end_mtr_rdng').val(response.end_mtr_rdng || '');
          $('#fuel').val(response.fuel || '');
          $('#qty').val(response.qty || '');
          toggleFuelInput();
          calculateTotalKm();

          if (response.start_time) {
            $('#start_time').val(response.start_time);
          } else {
            console.warn("Start time not found in response");
          }

          if (response.trips && response.trips.length > 0) {
            $('#shipments tbody').empty();
            response.trips.forEach(trip => {
              addTripDetails(trip);
            });
          }
        }
      },
      error: function(xhr) {
        console.error('Error loading draft:', xhr.responseText);
      }
    });

    $('#tripForm').on('submit', function(e) {
      e.preventDefault();
      if ($('#shipments tbody tr').length === 0) {
        alert('At least one trip is required.');
        return;
      }
      finalizeDataAndSubmit();
    });
  });

  function finalizeDataAndSubmit() {
    const endTime = new Date();
    const overallDuration = endTime - startTime;
    const hours = Math.floor(overallDuration / (1000 * 60 * 60));
    const minutes = Math.floor((overallDuration % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((overallDuration % (1000 * 60)) / 1000);
    const formattedDuration = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    const endTimeFormatted = endTime.toLocaleString('en-US', {hour12: false}).slice(0, 19).replace('T', ' ');

    $('#overall_time').val(formattedDuration);
    $('#end_time').val(endTimeFormatted);
    calculateTotalKm();

    $.ajax({
      url: $('#tripForm').attr('action'),
      method: 'POST',
      data: $('#tripForm').serialize(),
      success: function(response) {
        alert(response.message);
        if (response.redirect) window.location.href = response.redirect;
      },
      error: function(xhr) {
        if (xhr.status === 422) {
          const errors = xhr.responseJSON.errors;
          let errorMessage = 'Please fix the following errors:\n';
          for (const field in errors) {
            if (field.includes('.')) {
              const [fieldName, index] = field.split('.');
              const row = $('#shipments tbody tr').eq(parseInt(index));
              row.find(`[name="${fieldName}[]"]`).addClass('is-invalid');
              errorMessage += `${field}: ${errors[field].join(', ')}\n`;
            } else {
              $(`[name="${field}"]`).addClass('is-invalid');
              errorMessage += `${field}: ${errors[field].join(', ')}\n`;
            }
          }
          alert(errorMessage);
        } else {
          alert('An error occurred: ' + xhr.responseText);
        }
      }
    });
  }

  function calculateTotalKm() {
    const startMeter = parseFloat($('input[name="str_mtr_rdng"]').val()) || 0;
    const endMeter = parseFloat($('#end_mtr_rdng').val()) || 0;
    if (endMeter >= startMeter) {
      const totalKm = endMeter - startMeter;
      $('#total_km').val(totalKm);
      $('#total_km_display').text(totalKm);
    } else {
      alert('End meter reading must be greater than or equal to start meter reading.');
      $('#end_mtr_rdng').val('');
      $('#total_km').val(0);
      $('#total_km_display').text('0');
    }
  }

  function calculateTotalTime(input) {
    const row = input.closest('tr');
    const inDate = row.querySelector('input[name="in_date[]"]').value;
    const inTime = row.querySelector('input[name="in_time[]"]').value;
    const outDate = row.querySelector('input[name="out_date[]"]').value;
    const outTime = row.querySelector('input[name="out_time[]"]').value;

    if (inDate && inTime && outDate && outTime) {
      const inDateTime = new Date(`${inDate}T${inTime}`);
      const outDateTime = new Date(`${outDate}T${outTime}`);
      if (outDateTime > inDateTime) {
        const timeDiff = outDateTime - inDateTime;
        const hours = Math.floor(timeDiff / (1000 * 60 * 60));
        const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
        const formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        row.querySelector('.total-time-display').textContent = formattedTime;
        row.querySelector('.total-time-input').value = formattedTime;
      } else {
        alert('Out time must be later than In time.');
        row.querySelector('input[name="out_time[]"]').value = '';
        row.querySelector('.total-time-display').textContent = '00:00:00';
        row.querySelector('.total-time-input').value = '00:00:00';
      }
    }
  }

  function addTripDetails(trip = {}) {
    const tbody = $('#shipments tbody')[0];
    const newRow = tbody.insertRow();
    newRow.innerHTML = `
      <td><input class="form-control" name="location[]" value="${trip.location || ''}" placeholder="Enter location" required></td>
      <td>
        <div class="d-flex gap-2 flex-wrap">
          <input type="date" class="form-control" name="in_date[]" value="${trip.in_date || ''}" required onchange="calculateTotalTime(this)">
          <input type="time" class="form-control" name="in_time[]" value="${trip.in_time || ''}" required onchange="calculateTotalTime(this)">
          <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('in', event)">In</button>
        </div>
      </td>
      <td>
        <div class="d-flex gap-2 flex-wrap">
          <input type="date" class="form-control" name="out_date[]" value="${trip.out_date || ''}" required onchange="calculateTotalTime(this)">
          <input type="time" class="form-control" name="out_time[]" value="${trip.out_time || ''}" required onchange="calculateTotalTime(this)">
          <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('out', event)">Out</button>
        </div>
      </td>
      <td>
        <span class="total-time-display">${trip.total_time || '00:00:00'}</span>
        <input type="hidden" name="total_time[]" class="total-time-input" value="${trip.total_time || '00:00:00'}">
      </td>
      <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
          <i class="bi bi-trash me-1"></i> Remove
        </button>
      </td>
      <input type="hidden" name="trip_id[]" value="${trip.id || ''}">
    `;
    if (trip.in_date && trip.in_time && trip.out_date && trip.out_time) {
      calculateTotalTime(newRow.querySelector('input[name="in_date[]"]'));
    }
  }

  function removeRow(button) {
    if ($('#shipments tbody tr').length > 1) {
      button.closest('tr').remove();
      debounceSaveDraft();
    } else {
      alert('At least one trip is required.');
    }
  }

  function setCurrentDateTime(type, event) {
    const currentDate = new Date();
    const dateString = currentDate.toISOString().split('T')[0];
    const timeString = currentDate.toTimeString().split(':').slice(0, 2).join(':');
    const row = event.target.closest('tr');

    if (type === 'in') {
      row.querySelector('input[name="in_date[]"]').value = dateString;
      row.querySelector('input[name="in_time[]"]').value = timeString;
    } else {
      row.querySelector('input[name="out_date[]"]').value = dateString;
      row.querySelector('input[name="out_time[]"]').value = timeString;
    }
    calculateTotalTime(row.querySelector(`input[name="${type}_date[]"]`));
    debounceSaveDraft();
  }

  function toggleFuelInput() {
    const fuelSelection = $('#fuel').val();
    const qtyContainer = $('#qty_container');
    if (fuelSelection === 'yes') {
      qtyContainer.show();
      $('#qty').prop('required', true);
    } else {
      qtyContainer.hide();
      $('#qty').prop('required', false).val('');
    }
  }
</script>

@endsection

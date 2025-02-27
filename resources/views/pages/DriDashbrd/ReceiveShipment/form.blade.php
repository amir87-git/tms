@extends('layouts.app')

@section('content')

<div class="container py-5">
  <div class="text-center mb-5">
    <h3 class="fw-bold text-primary">Start Trip for Shipment No.{{ $shipment->id }}</h3>
  </div>

  <div class="form-container border border-2 border-primary rounded p-4 shadow-sm bg-white">
    <form action="{{ route('trips.store') }}" method="POST" onsubmit="finalizeData()">
      @csrf
      <input type="hidden" name="shipment_id" value="{{ $shipment->id }}">

      <!-- Timer Display -->
      <div class="text-start mb-4">
        <span class="badge bg-primary p-2">
          <strong>Trip Duration:</strong> <span id="timer">00:00:00</span>
          <span id="start_time" class="ms-2 text-white fw-bold">Started</span>
        </span>
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
          <select class="form-select form-select-sm" name="fuel" id="fuel" required aria-label="select" onchange="toggleFuelInput()">
            <option selected disabled>Fuel Needed</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select>
        </div>

        <!-- Quantity in Liters (Initially Hidden) -->
        <div class="col-12 col-md-6 col-lg-3 mb-3" id="qty" style="display: none;">
          <label for="qty" class="form-label"><strong>Qty Ltr</strong></label>
          <input type="number" class="form-control form-control-sm" id="qty" name="qty" placeholder="Enter quantity in Liters" min="0" step="any">
        </div>

        <script>
          function toggleFuelInput() {
            const fuelSelection = document.getElementById('fuel').value;
            const quantityContainer = document.getElementById('qty');
            
            if (fuelSelection === 'yes') {
              quantityContainer.style.display = 'block';  // Show input
            } else {
              quantityContainer.style.display = 'none';  // Hide input
            }
          }
        </script>

      </div>

      <!-- Hidden fields for total time and total kilometers -->
      <input type="hidden" name="overall_time" id="overall_time">
      <input type="hidden" name="total_km" id="total_km">

      <!-- Shipment Details (Input fields for each trip) -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle" id="shipments">
          <thead class="table-secondary">
            <tr>
              <th>Location</th>
              <th>In Date & Time</th>
              <th>Out Date & Time</th>
              <th>Total Time</th> <!-- New Column -->
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
                  <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('in')">In</button>
                </div>
              </td>
              <td>
                <div class="d-flex gap-2 flex-wrap">
                  <input type="date" class="form-control" name="out_date[]" required onchange="calculateTotalTime(this)">
                  <input type="time" class="form-control" name="out_time[]" required onchange="calculateTotalTime(this)">
                  <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('out')">Out</button>
                </div>
              </td>
              <td>
                <span class="total-time-display">00:00:00</span> <!-- Display total time here -->
                <input type="hidden" name="total_time[]" class="total-time-input" value="00:00:00"> <!-- Hidden input for form submission -->
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
  let timerInterval;
  let startTime;

  window.onload = function() {
    startTime = new Date().getTime();
    timerInterval = setInterval(updateTimer, 1000);
  };

  function updateTimer() {
    const currentTime = new Date().getTime();
    const elapsedTime = currentTime - startTime;

    const hours = Math.floor(elapsedTime / (1000 * 60 * 60));
    const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

    document.getElementById('timer').textContent =
      `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
  }

  function stopTimer() {
    clearInterval(timerInterval);
    const endTime = new Date().getTime();
    const overallDuration = Math.floor((endTime - startTime) / 1000);

    const hours = Math.floor(overallDuration / 3600);
    const minutes = Math.floor((overallDuration % 3600) / 60);
    const seconds = overallDuration % 60;

    const formattedDuration = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    document.getElementById('overall_time').value = formattedDuration;
  }

  function calculateTotalKm() {
    const startMeter = parseFloat(document.querySelector('input[name="str_mtr_rdng"]').value);
    const endMeter = parseFloat(document.getElementById('end_mtr_rdng').value);

    if (!isNaN(startMeter) && !isNaN(endMeter)) {
      if (endMeter >= startMeter) {
        const totalKm = endMeter - startMeter;
        document.getElementById('total_km').value = totalKm;
        document.getElementById('total_km_display').textContent = totalKm;
      } else {
        alert("End meter reading must be greater than start meter reading.");
        document.getElementById('end_mtr_rdng').value = '';
        document.getElementById('total_km_display').textContent = 0;
      }
    } else {
      alert("Please enter valid numeric values for both start and end meter readings.");
    }
  }

  function calculateTotalTime(input) {
    const row = input.closest("tr"); // Get the current row
    const inDate = row.querySelector('input[name="in_date[]"]').value;
    const inTime = row.querySelector('input[name="in_time[]"]').value;
    const outDate = row.querySelector('input[name="out_date[]"]').value;
    const outTime = row.querySelector('input[name="out_time[]"]').value;

    if (inDate && inTime && outDate && outTime) {
      const inDateTime = new Date(`${inDate}T${inTime}`);
      const outDateTime = new Date(`${outDate}T${outTime}`);

      if (outDateTime > inDateTime) {
        const timeDiff = outDateTime - inDateTime; // Difference in milliseconds
        const hours = Math.floor(timeDiff / (1000 * 60 * 60));
        const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

        const formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        // Update the display and hidden input
        row.querySelector('.total-time-display').textContent = formattedTime;
        row.querySelector('.total-time-input').value = formattedTime;
      } else {
        alert("Out time must be later than In time.");
        row.querySelector('.total-time-display').textContent = "00:00:00";
        row.querySelector('.total-time-input').value = "00:00:00";
      }
    }
  }

  function finalizeData() {
    stopTimer();
    calculateTotalKm();
  }

  function addTripDetails() {
    const table = document.getElementById("shipments").getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    newRow.innerHTML = `
      <td><input class="form-control" name="location[]" placeholder="Enter location" required></td>
      <td>
        <div class="d-flex gap-2 flex-wrap">
          <input type="date" class="form-control" name="in_date[]" required onchange="calculateTotalTime(this)">
          <input type="time" class="form-control" name="in_time[]" required onchange="calculateTotalTime(this)">
          <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('in')">In</button>
        </div>
      </td>
      <td>
        <div class="d-flex gap-2 flex-wrap">
          <input type="date" class="form-control" name="out_date[]" required onchange="calculateTotalTime(this)">
          <input type="time" class="form-control" name="out_time[]" required onchange="calculateTotalTime(this)">
          <button type="button" class="btn btn-secondary btn-sm" onclick="setCurrentDateTime('out')">Out</button>
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
    `;
  }

  function removeRow(button) {
    const row = button.closest("tr");
    row.remove();
  }

  function setCurrentDateTime(type) {
      const currentDate = new Date();
      const dateString = currentDate.toISOString().split('T')[0]; // YYYY-MM-DD
      const timeString = currentDate.toTimeString().split(':').slice(0, 2).join(':');; // HH:MM

      // Get the row where the button was clicked
      const row = event.target.closest("tr");

      if (row) {
          if (type === 'in') {
              // Target inputs for 'in_date' and 'in_time' in the same row
              const inDateInput = row.querySelector('input[name="in_date[]"]');
              const inTimeInput = row.querySelector('input[name="in_time[]"]');
              if (inDateInput) inDateInput.value = dateString;
              if (inTimeInput) inTimeInput.value = timeString;
          } else {
              // Target inputs for 'out_date' and 'out_time' in the same row
              const outDateInput = row.querySelector('input[name="out_date[]"]');
              const outTimeInput = row.querySelector('input[name="out_time[]"]');
              if (outDateInput) outDateInput.value = dateString;
              if (outTimeInput) outTimeInput.value = timeString;
          }
      } else {
          console.error('Row not found!');
      }
  }

</script>

@endsection

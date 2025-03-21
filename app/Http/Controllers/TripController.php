<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TripController extends Controller
{
    public function create($shipmentId)
    {
        $shipment = Shipment::with('vehicle')->findOrFail($shipmentId);
        
        return view('pages.DriDashbrd.ReceiveShipment.form', [
            'shipment' => $shipment,
            'vehicle' => $shipment->vehicle,
            'str_mtr_rdng' => $shipment->vehicle?->end_mtr_rdng ?? null,
        ]);
    }

    public function saveDraft(Request $request)
    {
        try {
            $shipment = Shipment::findOrFail($request->input('shipment_id'));
            $startMeter = $shipment->vehicle?->end_mtr_rdng ?? 0;

            $validatedData = $request->validate([
                'shipment_id' => 'required|integer|exists:shipments,id',
                'end_mtr_rdng' => "nullable|numeric|gte:{$startMeter}",
                'location' => 'nullable|array',
                'location.*' => 'nullable|string',
                'in_date' => 'nullable|array',
                'in_date.*' => 'nullable|date',
                'in_time' => 'nullable|array',
                'in_time.*' => 'nullable|string',
                'out_date' => 'nullable|array',
                'out_date.*' => 'nullable|date',
                'out_time' => 'nullable|array',
                'out_time.*' => 'nullable|string',
                'total_time' => 'nullable|array',
                'total_time.*' => 'nullable|string',
                'trip_id' => 'nullable|array',
                'trip_id.*' => 'nullable|integer|exists:trips,id',
                'start_time' => 'nullable|date',
                'end_time' => 'nullable|date',
                'overall_time' => 'nullable|string',
                'total_km' => 'nullable|numeric',
                'fuel' => 'nullable|in:yes,no',
                'qty' => 'nullable|numeric',
            ]);

            $shipmentData = array_filter($validatedData, function ($key) {
                return !in_array($key, ['location', 'in_date', 'in_time', 'out_date', 'out_time', 'total_time', 'trip_id']);
            }, ARRAY_FILTER_USE_KEY);

            $shipment = Shipment::updateOrCreate(
                ['id' => $validatedData['shipment_id']],
                $shipmentData
            );

            if ($shipment->vehicle && isset($validatedData['end_mtr_rdng'])) {
                $shipment->vehicle->update(['end_mtr_rdng' => $validatedData['end_mtr_rdng']]);
            }

            $submittedTripIds = array_filter($validatedData['trip_id'] ?? [], fn($id) => !empty($id));

            if (!empty($validatedData['location'])) {
                $submittedLocations = array_filter($validatedData['location'], fn($loc) => !empty($loc));

                Trip::where('shipment_id', $shipment->id)
                    ->whereNotIn('id', $submittedTripIds)
                    ->delete();

                foreach ($validatedData['location'] as $index => $location) {
                    if (!empty($location)) {
                        $tripData = [
                            'shipment_id' => $shipment->id,
                            'location' => $location,
                            'in_date' => $validatedData['in_date'][$index] ?? null,
                            'in_time' => $validatedData['in_time'][$index] ?? null,
                            'out_date' => $validatedData['out_date'][$index] ?? null,
                            'out_time' => $validatedData['out_time'][$index] ?? null,
                            'total_time' => $validatedData['total_time'][$index] ?? '00:00:00',
                        ];

                        Trip::updateOrCreate(
                            [
                                'id' => $validatedData['trip_id'][$index] ?? null,
                                'shipment_id' => $shipment->id,
                            ],
                            $tripData
                        );
                    }
                }
            } else {
                Trip::where('shipment_id', $shipment->id)->delete();
            }

            return response()->json([
                'id' => $shipment->id,
                'message' => 'Draft saved successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Draft save error: ' . $e->getMessage());
            return response()->json(['error' => 'Save failed: ' . $e->getMessage()], 500);
        }
    }

    public function getDraft($shipmentId)
    {
        $shipment = Shipment::with(['trips', 'vehicle'])
            ->where('id', $shipmentId)
            ->whereNull('end_time')
            ->first();

        if ($shipment) {
            return response()->json([
                'end_mtr_rdng' => $shipment->vehicle?->end_mtr_rdng ?? null,
                'total_km' => $shipment->total_km,
                'start_time' => $shipment->start_time,
                'fuel' => $shipment->fuel,
                'qty' => $shipment->qty,
                'trips' => $shipment->trips
            ]);
        }

        return response()->json(['message' => 'No incomplete drafts found.'], 404);
    }

    public function store(Request $request)
    {
        try {
            $shipment = Shipment::findOrFail($request->input('shipment_id'));
            $startMeter = $shipment->vehicle?->end_mtr_rdng ?? 0;

            $validatedData = $request->validate([
                'shipment_id' => 'required|integer|exists:shipments,id',
                'end_mtr_rdng' => "required|numeric|gte:{$startMeter}",
                'location' => 'required|array',
                'location.*' => 'required|string',
                'in_date' => 'required|array',
                'in_date.*' => 'required|date',
                'in_time' => 'required|array',
                'in_time.*' => 'required|string',
                'out_date' => 'required|array',
                'out_date.*' => 'required|date',
                'out_time' => 'required|array',
                'out_time.*' => 'required|string',
                'total_time' => 'required|array',
                'total_time.*' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date',
                'overall_time' => 'required|string',
                'total_km' => 'required|numeric',
                'fuel' => 'required|in:yes,no',
                'qty' => 'required_if:fuel,yes|nullable|numeric',
            ]);

            $shipment->update([
                'overall_time' => $validatedData['overall_time'],
                'total_km' => $validatedData['total_km'],
                'fuel' => $validatedData['fuel'],
                'qty' => $validatedData['qty'] ?? null,
                'start_time' => Carbon::parse($validatedData['start_time']),
                'end_time' => Carbon::parse($validatedData['end_time']),
            ]);

            if ($shipment->vehicle) {
                $shipment->vehicle->update(['end_mtr_rdng' => $validatedData['end_mtr_rdng']]);
            }

            Trip::where('shipment_id', $shipment->id)->delete();

            foreach ($validatedData['location'] as $index => $location) {
                Trip::create([
                    'shipment_id' => $shipment->id,
                    'location' => $location,
                    'in_date' => $validatedData['in_date'][$index],
                    'in_time' => $validatedData['in_time'][$index],
                    'out_date' => $validatedData['out_date'][$index],
                    'out_time' => $validatedData['out_time'][$index],
                    'total_time' => $validatedData['total_time'][$index] ?? '00:00:00',
                ]);
            }

            return response()->json([
                'message' => 'Trip submitted successfully!',
                'redirect' => route('receive-shipments.index'),
            ]);
        } catch (\Exception $e) {
            Log::error('Submission error: ' . $e->getMessage());
            return response()->json(['error' => 'Submission failed: ' . $e->getMessage()], 500);
        }
    }
}
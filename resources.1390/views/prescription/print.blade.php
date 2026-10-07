<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 20px; }
        }
        .prescription-box {
            border: 2px solid #333;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }
        .hospital-header {
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="prescription-box">
            <div class="hospital-header">
                <h2>🏥 City Hospital</h2>
                <p>123, Main Street, Delhi | Phone: 011-12345678</p>
                <h4>Medical Prescription</h4>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <strong>Patient Name:</strong> {{ $prescription->patient->name ?? 'N/A' }}<br>
                    <strong>Date:</strong> {{ $prescription->created_at->format('d M Y') }}
                </div>
                <div class="col-6">
                    <strong>Doctor:</strong> Dr. {{ $prescription->doctor->name ?? 'N/A' }}<br>
                    <strong>Specialization:</strong> {{ $prescription->doctor->specialization ?? 'N/A' }}
                </div>
            </div>
            
            <div class="mt-4">
                <h5>Symptoms / Observations:</h5>
                <p>{{ $prescription->symptoms_observations }}</p>
            </div>
            
            <div class="mt-3">
                <h5>Treatment Plan:</h5>
                <p>{{ $prescription->prescribed_treatment }}</p>
            </div>
            
            <div class="mt-3">
                <h5>Medicines:</h5>
                <p>{{ $prescription->prescribed_medicines }}</p>
            </div>
            
            @if($prescription->prescribed_pathology)
            <div class="mt-3">
                <h5>Pathology Tests:</h5>
                <p>{{ $prescription->prescribed_pathology }}</p>
            </div>
            @endif
            
            @if($prescription->notes)
            <div class="mt-3">
                <h5>Additional Notes:</h5>
                <p>{{ $prescription->notes }}</p>
            </div>
            @endif
            
            <hr>
            <div class="text-center mt-4">
                <p><strong>Follow up after 7 days if needed</strong></p>
                <p>_____________________<br>Doctor's Signature</p>
            </div>
        </div>
        
        <div class="text-center no-print mt-3">
            <button onclick="window.print()" class="btn btn-primary">🖨️ Print Prescription</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>
</body>
</html>
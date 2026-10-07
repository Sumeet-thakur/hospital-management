<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        @media print {
            .no-print { display: none; }
            body { padding: 20px; background: white; }
            .prescription-box {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
        
        body {
            background: #f5f7fa;
            padding: 30px;
        }
        
        .prescription-box {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .hospital-header {
            background: linear-gradient(135deg, #1a2a3a 0%, #0f1a24 100%);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        .hospital-header img {
            height: 55px;
            width: auto;
            border-radius: 12px;
            background: white;
            padding: 5px;
            margin-bottom: 12px;
        }
        
        .hospital-header h2 {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: 1px;
        }
        
        .hospital-header p {
            margin: 5px 0 0;
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        .prescription-title {
            background: #eef2f7;
            padding: 10px;
            text-align: center;
            border-bottom: 2px solid #0d6efd;
        }
        
        .prescription-title h4 {
            margin: 0;
            color: #1a2a3a;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 2px;
        }
        
        .info-section {
            padding: 25px 30px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .info-label {
            color: #64748b;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
        }
        
        .detail-section {
            padding: 20px 30px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .detail-section h5 {
            color: #0d6efd;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .detail-section p {
            color: #334155;
            line-height: 1.5;
            margin: 0;
            font-size: 0.9rem;
        }
        
        .signature-section {
            padding: 20px 30px 30px;
            text-align: right;
        }
        
        .signature-line {
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
            width: 250px;
            margin-left: auto;
        }
        
        .signature-line p {
            margin: 0;
            color: #64748b;
            font-size: 0.75rem;
        }
        
        .footer-note {
            background: #f1f5f9;
            padding: 12px;
            text-align: center;
            font-size: 0.7rem;
            color: #64748b;
        }
        
        .btn-print {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-print:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="prescription-box">
        <!-- Header with Logo -->
        <div class="hospital-header">
            <img src="{{ asset('images/logobg.jpeg') }}" alt="Logo">
            <h2>New Beginnings</h2>
            <p>DHA Main Street, Karachi | Phone: (021) 1234-5678</p>
        </div>
        
        <div class="prescription-title">
            <h4>MEDICAL PRESCRIPTION</h4>
        </div>
        
        <!-- Patient & Doctor Info -->
        <div class="info-section">
            <div class="row">
                <div class="col-6">
                    <div class="info-label">Patient Name</div>
                    <div class="info-value">{{ $prescription->patient->name ?? 'N/A' }}</div>
                </div>
                <div class="col-6">
                    <div class="info-label">Date</div>
                    <div class="info-value">{{ $prescription->created_at->format('d M Y') }}</div>
                </div>
                <div class="col-6 mt-3">
                    <div class="info-label">Doctor</div>
                    <div class="info-value">Dr. {{ $prescription->doctor->name ?? 'N/A' }}</div>
                </div>
                <div class="col-6 mt-3">
                    <div class="info-label">Specialization</div>
                    <div class="info-value">{{ $prescription->doctor->specialization ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Symptoms -->
        <div class="detail-section">
            <h5><i class="fas fa-stethoscope me-2"></i> Symptoms & Observations</h5>
            <p>{{ $prescription->symptoms_observations }}</p>
        </div>
        
        <!-- Treatment -->
        <div class="detail-section">
            <h5><i class="fas fa-notes-medical me-2"></i> Treatment Plan</h5>
            <p>{{ $prescription->prescribed_treatment }}</p>
        </div>
        
        <!-- Medicines -->
        <div class="detail-section">
            <h5><i class="fas fa-capsules me-2"></i> Prescribed Medicines</h5>
            <p>{{ $prescription->prescribed_medicines }}</p>
        </div>
        
        @if($prescription->prescribed_pathology)
        <div class="detail-section">
            <h5><i class="fas fa-flask me-2"></i> Pathology Tests</h5>
            <p>{{ $prescription->prescribed_pathology }}</p>
        </div>
        @endif
        
        @if($prescription->notes)
        <div class="detail-section">
            <h5><i class="fas fa-pen me-2"></i> Additional Notes</h5>
            <p>{{ $prescription->notes }}</p>
        </div>
        @endif
        
        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-line">
                <p>Doctor's Signature</p>
            </div>
        </div>
        
        <div class="footer-note">
            <p>Follow up after 7 days if needed | This is a computer generated prescription</p>
        </div>
    </div>
    
    <div class="text-center no-print mt-4">
        <button onclick="window.print()" class="btn btn-print btn-primary">
            <i class="fas fa-print me-2"></i> Print Prescription
        </button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>
    
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
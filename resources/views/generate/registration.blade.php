<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Registration Form</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 25px;
        }

        .section-title {
            background-color: #252958;
            color: #fff;
            font-weight: bold;
            padding: 4px 8px;
            font-size: 11px;
            margin: 10px 0 5px 0;
        }

        .info-block {
            margin-bottom: 12px;
        }

        .info-item {
            display: block;
            margin-bottom: 2px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            min-width: 150px;
        }

        .info-value {
            display: inline-block;
        }

        .bg_img {
            position: absolute;
            opacity: 0.1;
            background-repeat: no-repeat;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <div class="bg_img">
        <img src="{{ public_path('storage/' . application('image')) }}" alt="{{ application('name') }}" width="300px">
    </div>

    <table width="100%">
        <tr>
            <td width="15%" align="left">
                <img src="{{ public_path('storage/' . application('image')) }}" style="height: 70px;">
            </td>
            <td width="70%" align="center">
                <h2 style="margin: 0; font-size: 18px; font-weight: bold; text-transform: uppercase;">
                    {{ strtoupper(application('name')) }}
                </h2>
                <p style="margin: 0; font-size: 12px;">
                    {{ application('address') }}
                </p>
            </td>
            <td width="15%" align="right">
                @if($data->image)
                <img src="{{ public_path('storage/' . $data->image) }}"
                    style="height: 80px; width: 80px; object-fit: cover; border: 1px solid #ccc;">
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">Student Information</div>
    <div class="info-block">
        <div class="info-item"><span class="info-label">Full Name:</span> <span
                class="info-value">{{ $data->last_name }} {{ $data->first_name }} {{ $data->other_name }}</span></div>
        <div class="info-item"><span class="info-label">Gender:</span> <span
                class="info-value">{{ ucfirst($data->gender) }}</span></div>
        <div class="info-item"><span class="info-label">Date of Birth:</span> <span
                class="info-value">{{ $data->dob }}</span></div>
        <div class="info-item"><span class="info-label">Nationality:</span> <span
                class="info-value">{{ $data->nationality }}</span></div>
        <div class="info-item"><span class="info-label">State of Origin:</span> <span
                class="info-value">{{ $data->state_of_origin }}</span></div>
        <div class="info-item"><span class="info-label">Local Government:</span> <span
                class="info-value">{{ $data->local_government }}</span></div>
        <div class="info-item"><span class="info-label">Home Address:</span> <span
                class="info-value">{{ $data->address }}</span></div>
        <div class="info-item"><span class="info-label">Previous School:</span> <span
                class="info-value">{{ $data->prev_school }}</span></div>
        <div class="info-item"><span class="info-label">Previous Class:</span> <span
                class="info-value">{{ $data->prev_class }}</span></div>
        <div class="info-item"><span class="info-label">Applying For:</span> <span
                class="info-value">{{ $data->grade->title ?? '' }}</span></div>
    </div>

    <div class="section-title">Medical Information</div>
    <div class="info-block">
        <div class="info-item"><span class="info-label">Blood Group:</span> <span
                class="info-value">{{ $data->blood_group }}</span></div>
        <div class="info-item"><span class="info-label">Genotype:</span> <span
                class="info-value">{{ $data->genotype }}</span></div>
        <div class="info-item"><span class="info-label">Speech Development:</span> <span
                class="info-value">{{ $data->speech_development }}</span></div>
        <div class="info-item"><span class="info-label">Sight:</span> <span class="info-value">{{ $data->sight }}</span>
        </div>
        <div class="info-item"><span class="info-label">Known Allergies:</span> <span
                class="info-value">{{ $data->allergics }}</span></div>
        <div class="info-item"><span class="info-label">Medical History:</span> <span
                class="info-value">{{ $data->medical_history }}</span></div>
    </div>

    <div class="section-title">Parent / Guardian Information</div>
    <div class="info-block">
        <div class="info-item"><span class="info-label">Father's Name:</span> <span
                class="info-value">{{ $data->father_name }}</span></div>
        <div class="info-item"><span class="info-label">Father Phone:</span> <span
                class="info-value">{{ $data->father_phone }}</span></div>
        <div class="info-item"><span class="info-label">Father Email:</span> <span
                class="info-value">{{ $data->father_email }}</span></div>
        <div class="info-item"><span class="info-label">Father Occupation:</span> <span
                class="info-value">{{ $data->father_occupation }}</span></div>
        <div class="info-item"><span class="info-label">Father Office Address:</span> <span
                class="info-value">{{ $data->father_office_address }}</span></div>

        <div class="info-item"><span class="info-label">Mother's Name:</span> <span
                class="info-value">{{ $data->mother_name }}</span></div>
        <div class="info-item"><span class="info-label">Mother Phone:</span> <span
                class="info-value">{{ $data->mother_phone }}</span></div>
        <div class="info-item"><span class="info-label">Mother Email:</span> <span
                class="info-value">{{ $data->mother_email }}</span></div>
        <div class="info-item"><span class="info-label">Mother Occupation:</span> <span
                class="info-value">{{ $data->mother_occupation }}</span></div>
        <div class="info-item"><span class="info-label">Mother Office Address:</span> <span
                class="info-value">{{ $data->mother_office_address }}</span></div>

        <div class="info-item"><span class="info-label">Guardian Name:</span> <span
                class="info-value">{{ $data->guardian_full_name }}</span></div>
        <div class="info-item"><span class="info-label">Guardian Phone:</span> <span
                class="info-value">{{ $data->guardian_phone_number }}</span></div>
        <div class="info-item"><span class="info-label">Guardian Email:</span> <span
                class="info-value">{{ $data->guardian_email }}</span></div>
        <div class="info-item"><span class="info-label">Relationship:</span> <span
                class="info-value">{{ $data->guardian_relationship }}</span></div>
        <div class="info-item"><span class="info-label">Guardian Occupation:</span> <span
                class="info-value">{{ $data->guardian_occupation }}</span></div>
        <div class="info-item"><span class="info-label">Guardian Office Address:</span> <span
                class="info-value">{{ $data->guardian_office_address }}</span></div>
        <div class="info-item"><span class="info-label">Guardian Home Address:</span> <span
                class="info-value">{{ $data->guardian_home_address }}</span></div>
    </div>

    <p style="font-size: 10px; text-align: right;">Generated on {{ now()->format('F j, Y g:i A') }}</p>
</body>

</html>
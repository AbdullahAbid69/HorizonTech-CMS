@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Student Applications</h3>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">HORIZON INSTITUTE OF HEALTH SCIENCES</h4>
                <h5 class="text-center">ADMISSION FORM</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>PROGRAM APPLIED FOR:</strong> {{ $application->studentsDetails->program->name ?? '' }}


                    </div>
                    <div class="col-md-6 text-right">
                        <strong>Application#:</strong> {{ $application->id }}
                    </div>
                </div>

                <div class="text-center mb-4">
                    @if($application->profile_image)
                        <img src="{{ asset($application->profile_image) }}" width="150" height="150" class="img-thumbnail">
                    @else
                        <div class="border p-2" style="width:150px; height:150px; margin:0 auto;">PHOTOGRAPH</div>
                    @endif
                </div>

                <h5 class="mb-3">1. PERSONAL DETAILS</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="30%"><strong>Name of Applicant</strong></td>
                                <td>{{ $application->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Father's Name</strong></td>
                                <td>{{ $application->studentsDetails->fatherName ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nationality</strong></td>
                                <td>{{ $application->studentsDetails->nationality ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date of Birth</strong></td>
                                <td>{{ $application->studentsDetails->dateOfBirth ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>CNIC #</strong></td>
                                <td>{{ $application->studentsDetails->cnic ?? '' }}</td>
                            </tr>
                            @if ($application->studentsDetails->cnic_file)
                                <tr>
                                    <td><strong>CNIC file</strong></td>
                                    {{-- <td>{{ $application->studentsDetails->cnic ?? '' }}</td> --}}
                                    <td><a target="_blank"
                                            href="{{asset($application->studentsDetails->cnic_file)}}">Download</a>
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td><strong>Marital Status</strong></td>
                                <td>{{ $application->studentsDetails->maritalStatus ?? '' }}</td>
                            </tr>

                            <tr>
                                <td><strong>Religion</strong></td>
                                <td>{{ $application->studentsDetails->religion ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gender</strong></td>
                                <td>{{ $application->studentsDetails->gender ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Home Address (Present)</strong></td>
                                <td>{{ $application->studentsDetails->homeAddress ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tel No.</strong></td>
                                <td>{{ $application->studentsDetails->mobileNumber ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Mobile</strong></td>
                                <td>{{ $application->phone ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Home Address (as mentioned in NIC)</strong></td>
                                <td>{{ $application->studentsDetails->permanent_address ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>E-mail</strong></td>
                                <td>{{ $application->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="mb-3 mt-4">2. EDUCATION AND ACADEMIC DEGREES</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Academic Degree</th>
                                <th>Major Subject</th>
                                <th>School/University/Board</th>
                                <th>Country</th>
                                <th>Degree</th>
                                <th>Duration</th>
                                <th>Result (% / GPA)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($application->studentQualifications as $qualification)
                                <tr>
                                    <td>{{ $qualification->degreeType }}</td>
                                    <td>{{ $qualification->Majors }}</td>
                                    <td>{{ $qualification->institute }}</td>

                                    <td>{{ $qualification->country }}</td>
                                    @if ($qualification->qualification_file)
                                        <td>
                                            <a target="_blank" href="{{asset($qualification->qualification_file)}}">Download</a>
                                        </td>
                                    @endif
                                    <td>{{ $qualification->duration }}</td>
                                    <td>{{ $qualification->result }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                <h5 class="mb-3 mt-4">PARTICULARS OF FATHER/MOTHER/GUARDIAN</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="30%"><strong>Name</strong></td>
                                <td>{{ $application->studentsDetails->fatherName ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Occupation</strong></td>
                                <td>{{ $application->studentsDetails->fatherOccupation ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Designation</strong></td>
                                <td>{{ $application->studentsDetails->designation ?? '' }}</td>
                            </tr>
                            {{-- <tr>
                                <td><strong>Place of work</strong></td>
                                <td>{{ $application->studentsDetails->guardian_work_place ?? '' }}</td>
                            </tr> --}}
                            <tr>
                                <td><strong>Name of organization</strong></td>
                                <td>{{ $application->studentsDetails->NameOfOrg ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Office Address</strong></td>
                                <td>{{ $application->studentsDetails->officeAddress ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Present Residential Address</strong></td>
                                <td>{{ $application->studentsDetails->homeAddress ?? '' }}</td>
                            </tr>
                            {{-- <tr>
                                <td><strong>Permanent Address</strong></td>
                                <td>{{ $application->studentsDetails->guardian_permanent_address ?? '' }}</td>
                            </tr> --}}
                            {{-- <tr>
                                <td><strong>Email address</strong></td>
                                <td>{{ $application->studentsDetails->guardian_email ?? '' }}</td>
                            </tr> --}}
                            <tr>
                                <td><strong>Office Phone</strong></td>
                                <td>{{ $application->studentsDetails->fatherOfficePhone ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Mobile Phone</strong></td>
                                <td>{{ $application->studentsDetails->fatherOfficePhone ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Res. Phone</strong></td>
                                <td>{{ $application->studentsDetails->guardian_res_phone ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Any Other Contact Number</strong></td>
                                <td>{{ $application->studentsDetails->AnyOtherContactNumber ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Annual Income</strong></td>
                                <td>{{ $application->studentsDetails->guardian_income ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Religion</strong></td>
                                <td>{{ $application->studentsDetails->fatherReligion ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nationality</strong></td>
                                <td>{{ $application->studentsDetails->fatherNationality ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>NADRA NIC No.</strong></td>
                                <td>{{ $application->studentsDetails->fatherCnic ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
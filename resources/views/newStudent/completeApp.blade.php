@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Student Application</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form action="{{ route('student.save') }}" enctype="multipart/form-data" method="POST" id="studentForm">
                    @csrf
                    <h3 class="text-center mb-4">Student Registration Form</h3>

                    <!-- Progress Bar -->
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 0%" id="formProgress"></div>
                    </div>

                    <!-- Step Indicators -->
                    <ul class="nav nav-pills mb-4 justify-content-center" id="stepTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="step1-tab" data-bs-toggle="pill" data-bs-target="#step1"
                                type="button" role="tab">Personal Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="step2-tab" data-bs-toggle="pill" data-bs-target="#step2" type="button"
                                role="tab">Parent Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="step3-tab" data-bs-toggle="pill" data-bs-target="#step3" type="button"
                                role="tab">Qualifications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="step4-tab" data-bs-toggle="pill" data-bs-target="#step4" type="button"
                                role="tab">Review</button>
                        </li>
                    </ul>

                    <!-- Form Steps -->
                    <div class="tab-content" id="stepContent">
                        <!-- Step 1: Personal Information -->
                        <div class="tab-pane fade show active" id="step1" role="tabpanel">
                            <h4 class="text-center mb-4">Personal Information</h4>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="program" class="form-label">Program</label>
                                    <select name="program" id="program" class="form-control" required>
                                        <option value="">Select Program</option>
                                        @foreach ($programs as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="dateOfBirth" class="form-label">Date Of Birth</label>
                                    <input type="date" name="dateOfBirth" id="dateOfBirth" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="mobileNumber" class="form-label">Mobile Number</label>
                                    <input type="text" name="mobileNumber" id="mobileNumber" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="cnic" class="form-label">CNIC</label>
                                    <input type="text" name="cnic" id="cnic" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="CNICPdf" class="form-label">Upload CNIC (PDF)</label>
                                    <input type="file" name="CNICPdf" id="CNICPdf" accept=".pdf" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="religion" class="form-label">Religion</label>
                                    <input type="text" name="religion" id="religion" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" name="nationality" id="nationality" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="maritalStatus" class="form-label">Marital Status</label>
                                    <select name="maritalStatus" id="maritalStatus" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="true">Married</option>
                                        <option value="false">Unmarried</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="homeAddress" class="form-label">Home Address</label>
                                    <input type="text" name="homeAddress" id="homeAddress" class="form-control" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary" disabled>Previous</button>
                                <button type="button" class="btn btn-primary next-step" data-next="step2">Next</button>
                            </div>
                        </div>

                        <!-- Step 2: Parent Information -->
                        <div class="tab-pane fade" id="step2" role="tabpanel">
                            <h4 class="text-center mb-4">Parent Information</h4>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fatherName" class="form-label">Father's Name</label>
                                    <input type="text" name="fatherName" id="fatherName" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="fatherOccupation" class="form-label">Father's Occupation</label>
                                    <input type="text" name="fatherOccupation" id="fatherOccupation" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" name="designation" id="designation" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="NameOfOrg" class="form-label">Name of Organization</label>
                                    <input type="text" name="NameOfOrg" id="NameOfOrg" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="officeAddress" class="form-label">Office Address</label>
                                    <input type="text" name="officeAddress" id="officeAddress" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="fatherOfficePhone" class="form-label">Office Phone</label>
                                    <input type="text" name="fatherOfficePhone" id="fatherOfficePhone" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="AnyOtherContactNumber" class="form-label">Other Contact Number</label>
                                    <input type="text" name="AnyOtherContactNumber" id="AnyOtherContactNumber"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="AnnualIncome" class="form-label">Annual Income</label>
                                    <input type="text" name="AnnualIncome" id="AnnualIncome" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="fatherReligion" class="form-label">Father's Religion</label>
                                    <input type="text" name="fatherReligion" id="fatherReligion" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="fatherNationality" class="form-label">Father's Nationality</label>
                                    <input type="text" name="fatherNationality" id="fatherNationality" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="fatherCnic" class="form-label">Father's CNIC</label>
                                    <input type="text" name="fatherCnic" id="fatherCnic" class="form-control">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step" data-prev="step1">Previous</button>
                                <button type="button" class="btn btn-primary next-step" data-next="step3">Next</button>
                            </div>
                        </div>

                        <!-- Step 3: Qualifications -->
                        <div class="tab-pane fade" id="step3" role="tabpanel">
                            <h4 class="text-center mb-4">Qualifications</h4>

                            <div id="qualificationsContainer"></div>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="addQualification()">
                                    <i class="fas fa-plus"></i> Add Qualification
                                </button>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step" data-prev="step2">Previous</button>
                                <button type="button" class="btn btn-primary next-step" data-next="step4">Next</button>
                            </div>
                        </div>

                        <!-- Step 4: Review and Submit -->
                        <div class="tab-pane fade" id="step4" role="tabpanel">
                            <h4 class="text-center mb-4">Review Your Information</h4>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5>Personal Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="reviewPersonalInfo">
                                        <!-- Filled by JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5>Parent Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="reviewParentInfo">
                                        <!-- Filled by JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5>Qualifications</h5>
                                </div>
                                <div class="card-body" id="reviewQualifications">
                                    <!-- Filled by JavaScript -->
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="confirmInfo" required>
                                <label class="form-check-label" for="confirmInfo">
                                    I confirm that all the information provided is accurate
                                </label>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step" data-prev="step3">Previous</button>
                                <button type="submit" class="btn btn-success">Submit Application</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Qualification Block Template -->
                <template id="qualification-template">
                    <div class="qualification-block border p-3 mb-3">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label class="form-label">Degree Type</label>
                                <select name="qualifications[__index__][degreeType]" class="form-control" required>
                                    <option value="">Select Degree Type</option>
                                    <option value="metric">Metric</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="diplomaInNursing">Diploma in Nursing</option>
                                    <option value="postBasicDiploma">Post Basic Diploma</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Major</label>
                                <input type="text" name="qualifications[__index__][Majors]" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Institute</label>
                                <input type="text" name="qualifications[__index__][institute]" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="qualifications[__index__][country]" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Duration</label>
                                <input type="text" name="qualifications[__index__][duration]" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Result</label>
                                <input type="text" name="qualifications[__index__][result]" class="form-control" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">Attach File (optional)</label>
                                <input type="file" name="qualifications[__index__][file]" class="form-control">
                            </div>
                        </div>
                        <div class="text-end mt-2">
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="this.closest('.qualification-block').remove()">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            let qualificationIndex = 0;

            // Add qualification block
            function addQualification() {
                const template = document.getElementById('qualification-template').innerHTML;
                const html = template.replace(/__index__/g, qualificationIndex++);
                const container = document.getElementById('qualificationsContainer');
                container.insertAdjacentHTML('beforeend', html);
            }

            // Form navigation
            document.addEventListener('DOMContentLoaded', function () {
                // Add first qualification block
                addQualification();

                // Step navigation
                document.querySelectorAll('.next-step').forEach(button => {
                    button.addEventListener('click', function () {
                        const nextStep = this.getAttribute('data-next');
                        const currentTab = this.closest('.tab-pane');

                        // Validate current step before proceeding
                        let isValid = true;
                        const inputs = currentTab.querySelectorAll('input[required], select[required], textarea[required]');

                        inputs.forEach(input => {
                            if (!input.value) {
                                input.classList.add('is-invalid');
                                isValid = false;
                            } else {
                                input.classList.remove('is-invalid');
                            }
                        });

                        if (isValid) {
                            // Switch to next step
                            document.getElementById(`${nextStep}-tab`).click();
                            updateProgressBar();
                            updateReviewSection();
                        } else {
                            toastr.error('Please fill all required fields before proceeding.', 'Validation Error', {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-right',
                                timeOut: 5000
                            });
                        }
                    });
                });

                // Previous step navigation
                document.querySelectorAll('.prev-step').forEach(button => {
                    button.addEventListener('click', function () {
                        const prevStep = this.getAttribute('data-prev');
                        document.getElementById(`${prevStep}-tab`).click();
                        updateProgressBar();
                    });
                });

                // Update progress bar
                function updateProgressBar() {
                    const activeTab = document.querySelector('#stepTabs .nav-link.active');
                    const tabs = document.querySelectorAll('#stepTabs .nav-link');
                    const currentIndex = Array.from(tabs).indexOf(activeTab);
                    const progress = (currentIndex / (tabs.length - 1)) * 100;

                    document.getElementById('formProgress').style.width = `${progress}%`;
                }

                // Update review section
                function updateReviewSection() {
                    // Personal Info
                    const personalInfoFields = [
                        { id: 'program', label: 'Program' },
                        { id: 'dateOfBirth', label: 'Date of Birth' },
                        { id: 'mobileNumber', label: 'Mobile Number' },
                        { id: 'cnic', label: 'CNIC' },
                        { id: 'religion', label: 'Religion' },
                        { id: 'nationality', label: 'Nationality' },
                        { id: 'gender', label: 'Gender' },
                        { id: 'maritalStatus', label: 'Marital Status' },
                        { id: 'homeAddress', label: 'Home Address' }
                    ];

                    let personalInfoHtml = '';
                    personalInfoFields.forEach(field => {
                        const element = document.getElementById(field.id);
                        if (element) {
                            let value = element.value;
                            if (element.tagName === 'SELECT') {
                                value = element.options[element.selectedIndex].text;
                            }
                            personalInfoHtml += `
                                                <div class="col-md-6 mb-2">
                                                    <strong>${field.label}:</strong>
                                                    <div>${value || 'Not provided'}</div>
                                                </div>
                                            `;
                        }
                    });
                    document.getElementById('reviewPersonalInfo').innerHTML = personalInfoHtml;

                    // Parent Info
                    const parentInfoFields = [
                        { id: 'fatherName', label: 'Father\'s Name' },
                        { id: 'fatherOccupation', label: 'Occupation' },
                        { id: 'designation', label: 'Designation' },
                        { id: 'NameOfOrg', label: 'Organization' },
                        { id: 'officeAddress', label: 'Office Address' },
                        { id: 'fatherOfficePhone', label: 'Office Phone' },
                        { id: 'AnyOtherContactNumber', label: 'Other Contact' },
                        { id: 'AnnualIncome', label: 'Annual Income' },
                        { id: 'fatherReligion', label: 'Religion' },
                        { id: 'fatherNationality', label: 'Nationality' },
                        { id: 'fatherCnic', label: 'CNIC' }
                    ];

                    let parentInfoHtml = '';
                    parentInfoFields.forEach(field => {
                        const element = document.getElementById(field.id);
                        if (element) {
                            parentInfoHtml += `
                                                <div class="col-md-6 mb-2">
                                                    <strong>${field.label}:</strong>
                                                    <div>${element.value || 'Not provided'}</div>
                                                </div>
                                            `;
                        }
                    });
                    document.getElementById('reviewParentInfo').innerHTML = parentInfoHtml;

                    // Qualifications
                    const qualificationBlocks = document.querySelectorAll('.qualification-block');
                    let qualificationsHtml = '';

                    qualificationBlocks.forEach((block, index) => {
                        const degreeType = block.querySelector('[name*="degreeType"]').value;
                        const majors = block.querySelector('[name*="Majors"]').value;
                        const institute = block.querySelector('[name*="institute"]').value;
                        const country = block.querySelector('[name*="country"]').value;
                        const duration = block.querySelector('[name*="duration"]').value;
                        const result = block.querySelector('[name*="result"]').value;

                        qualificationsHtml += `
                                            <div class="mb-3 p-3 border-bottom">
                                                <h6>Qualification #${index + 1}</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <strong>Degree:</strong> ${degreeType || 'Not provided'}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Major:</strong> ${majors || 'Not provided'}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Institute:</strong> ${institute || 'Not provided'}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Country:</strong> ${country || 'Not provided'}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Duration:</strong> ${duration || 'Not provided'}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Result:</strong> ${result || 'Not provided'}
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                    });

                    document.getElementById('reviewQualifications').innerHTML = qualificationsHtml || '<p>No qualifications added</p>';
                }

                // Initialize progress bar
                updateProgressBar();
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('studentForm');

                const fields = {
                    program: {
                        element: document.getElementById('program'),
                        message: 'Please select a program.'
                    },
                    dateOfBirth: {
                        element: document.getElementById('dateOfBirth'),
                        message: 'Date of Birth is required.'
                    },
                    mobileNumber: {
                        element: document.getElementById('mobileNumber'),
                        message: 'Mobile Number is required and must contain only digits.'
                    },
                    cnic: {
                        element: document.getElementById('cnic'),
                        message: 'CNIC is required and must be in the correct format (e.g., 12345-1234567-1).'
                    },
                    CNICPdf: {
                        element: document.getElementById('CNICPdf'),
                        message: 'Please upload a valid CNIC PDF file.'
                    },
                    religion: {
                        element: document.getElementById('religion'),
                        message: 'Religion is required.'
                    },
                    nationality: {
                        element: document.getElementById('nationality'),
                        message: 'Nationality is required.'
                    },
                    gender: {
                        element: document.getElementById('gender'),
                        message: 'Please select a gender.'
                    },
                    maritalStatus: {
                        element: document.getElementById('maritalStatus'),
                        message: 'Please select a marital status.'
                    },
                    homeAddress: {
                        element: document.getElementById('homeAddress'),
                        message: 'Home Address is required.'
                    }
                };

                Object.keys(fields).forEach(key => {
                    const field = fields[key];

                    field.element.addEventListener('blur', function () {
                        validateField(key);
                    });
                });

                form.addEventListener('submit', function (event) {
                    let isValid = true;

                    Object.keys(fields).forEach(key => {
                        if (!validateField(key)) {
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        event.preventDefault();
                    }
                });

                function validateField(key) {
                    const field = fields[key];
                    const value = field.element.value.trim();
                    let isValid = true;

                    if (!value) {
                        isValid = false;
                        field.element.placeholder = field.message;
                    } else {
                        if (key === 'mobileNumber' && !/^[0-9]+$/.test(value)) {
                            isValid = false;
                            field.element.placeholder = 'Mobile Number must contain only digits.';
                        }
                        if (key === 'cnic' && !/^\d{5}-\d{7}-\d{1}$/.test(value)) {
                            isValid = false;
                            field.element.placeholder = 'CNIC must be in the format 12345-1234567-1.';
                        }
                        if (key === 'CNICPdf' && !/\.pdf$/i.test(value)) {
                            isValid = false;
                            field.element.placeholder = 'Please upload a valid PDF file.';
                        }
                    }

                    if (!isValid) {
                        field.element.classList.add('is-invalid');
                        field.element.style.backgroundColor = '#f8d7da'; // Light red background
                    } else {
                        field.element.classList.remove('is-invalid');
                        field.element.style.backgroundColor = ''; // Reset background color
                    }

                    return isValid;
                }
            });
        </script>

        <style>
            .progress {
                height: 10px;
                border-radius: 5px;
            }

            .nav-pills .nav-link {
                border-radius: 0;
                padding: 10px 20px;
                margin: 0 5px;
                border: 1px solid #dee2e6;
            }

            .nav-pills .nav-link.active {
                background-color: #0d6efd;
                color: white;
            }

            .tab-pane {
                padding: 20px;
                border: 1px solid #dee2e6;
                border-top: none;
                border-radius: 0 0 5px 5px;
            }

            .qualification-block {
                border-radius: 5px;
                background-color: #f8f9fa;
            }

            #reviewPersonalInfo,
            #reviewParentInfo,
            #reviewQualifications {
                padding: 15px;
            }
        </style>
@endsection
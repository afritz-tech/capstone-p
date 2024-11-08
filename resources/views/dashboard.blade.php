@extends('layouts.dashboard_app')
@section('title', 'HealthHub Connect')
@section('content')

<!-- MAIN CONTENT -->
<div class="mt-5 pt-3">
    <!-- Alert Section -->
    <div class="container my-3">
        <div class="alert alert-info text-center" role="alert">
            In an effort to provide the most efficient and effective patient care, please update your information prior to your visit.
        </div>
    </div>

<!-- Main / Body -->
<div class="container my-4">
    <div class="accordion" id="medicalAccordion">
        <!-- PERSONAL INFORMATION SECTION -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingPersonal">
                <button class="accordion-button bg-light text-dark fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                    <i class="bi bi-person-badge me-2"></i>Personal Information
                </button>
            </h2>
            <div id="collapsePersonal" class="accordion-collapse collapse show" aria-labelledby="headingPersonal" data-bs-parent="#medicalAccordion">
                <div class="accordion-body">
                    <!-- Profile Picture and Personal Details -->
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <!-- Profile Picture Upload -->
                            <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data" id="profilePictureForm">
                                @csrf
                                <img id="profilePicture" src="{{ auth()->user()->profile_picture ?? 'https://via.placeholder.com/150' }}" 
                                     class="rounded-circle img-fluid mb-3 mb-md-0" alt="Profile Picture">
                                <div class="mt-2">
                                    <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-outline-secondary" id="uploadButton">
                                        <i class="bi bi-upload me-1"></i>Upload Photo
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="firstName" value="{{ auth()->user()->firstName }}" placeholder="First Name">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="lastName" value="{{ auth()->user()->lastName }}" placeholder="Last Name">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="birthDate" class="form-label">Date of Birth *</label>
                                    <input type="date" class="form-control" id="birthDate" value="{{ auth()->user()->birthDate?->format('Y-m-d') }}" placeholder="DD-MM-YYYY">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Address and Phone Sections -->
                    <hr class="my-4">
                    <div class="row">
                        <!-- Address Section -->
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#addressModal">+ Add Address</button>

                            <!-- Address Modal -->
                            <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addressModalLabel">Add New Address</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="addressAlert" class="alert alert-danger d-none" role="alert"></div>
                                            <input type="text" id="addressInput" class="form-control" placeholder="Enter your address">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="saveAddressButton">Save Address</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Table -->
                            <div class="table-responsive mt-3">
                                <div id="addressList" class="mt-3">
                                <table id="addressesTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(auth()->user()->addresses)
                                            @foreach(auth()->user()->addresses as $address)
                                            <tr>
                                                <td>{{ $address->address }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger delete-address" data-id="{{ $address->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center">No addresses found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <!-- Phone Section -->
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#phoneModal">+ Add Phone Number</button>

                            <!-- Phone Number Modal -->
                            <div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="phoneModalLabel">Add New Phone Number</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="phoneAlert" class="alert alert-danger d-none" role="alert"></div>
                                            <input type="text" id="phoneInput" class="form-control" placeholder="Enter your phone number">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="savePhoneButton">Save Phone Number</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone Table -->
                            <div class="table-responsive mt-3">
                                <table id="phonesTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Phone Number</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(auth()->user()->phone_numbers)
                                            @foreach(auth()->user()->phone_numbers as $phone)
                                            <tr>
                                                <td>{{ $phone->phone_number }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger delete-phone" data-id="{{ $phone->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center">No phone numbers found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Save Changes Button -->
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" id="saveChangesButton">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Personal Information Section -->

        <!-- INSURANCE SECTION -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingInsurance">
                <button class="accordion-button collapsed bg-light text-dark fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInsurance" aria-expanded="false" aria-controls="collapseInsurance">
                    <i class="bi bi-shield-check me-2"></i>Insurance
                </button>
            </h2>
            <div id="collapseInsurance" class="accordion-collapse collapse" aria-labelledby="headingInsurance" data-bs-parent="#medicalAccordion">
                <div class="accordion-body">
                    <p>If you don’t have any insurance policy on file, please add primary insurance or set to “Self-pay” by confirming “I am Self-pay”.</p>
                    <div class="d-flex flex-wrap mb-3">
                        <button class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#insuranceModal" id="addInsuranceButton">Add Primary Insurance</button>
                        <button class="btn btn-success me-2 mb-2" id="selfPayButton">I am Self-pay</button>
                        <button class="btn btn-secondary mb-2 d-none" id="resetSelfPayButton">Reset Self-Pay Status</button>
                    </div>

                    <!-- Insurance Modal -->
                    <div class="modal fade" id="insuranceModal" tabindex="-1" aria-labelledby="insuranceModalLabel" aria-hidden="true">
                        <!-- [Modal content remains the same as before] -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header and Body -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="insuranceModalLabel">Add Insurance Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="insuranceAlert" class="alert alert-danger d-none" role="alert"></div>
                                    <div class="mb-3">
                                        <label for="insuranceProvider" class="form-label">Insurance Provider *</label>
                                        <input type="text" id="insuranceProvider" class="form-control" placeholder="Insurance Provider">
                                    </div>
                                    <div class="mb-3">
                                        <label for="policyNumber" class="form-label">Policy Number *</label>
                                        <input type="text" id="policyNumber" class="form-control" placeholder="Policy Number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="coverageType" class="form-label">Coverage Type *</label>
                                        <input type="text" id="coverageType" class="form-control" placeholder="Coverage Type">
                                    </div>
                                    <div class="mb-3">
                                        <label for="validUntil" class="form-label">Valid Until *</label>
                                        <input type="date" id="validUntil" class="form-control">
                                    </div>
                                </div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="saveInsuranceButton">Save Insurance</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Insurance Details Table -->
                    <div class="mt-3">
                        <h4>Insurance Details</h4>
                        <div class="table-responsive">
                            <table id="insuranceTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Insurance Provider</th>
                                        <th>Policy Number</th>
                                        <th>Coverage Type</th>
                                        <th>Valid Until</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Insurance rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Self-Pay Status -->
                    <div class="mt-3">
                        <h4>Self-Pay Status</h4>
                        <div id="selfPayStatus">
                            <!-- Self-Pay status message will be displayed here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Insurance Section -->

        <!-- APPOINTMENTS SECTION -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingAppointments">
                <button class="accordion-button collapsed bg-light text-dark fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAppointments" aria-expanded="false" aria-controls="collapseAppointments">
                    <i class="bi bi-calendar-event me-2"></i>Appointments
                </button>
            </h2>
            <div id="collapseAppointments" class="accordion-collapse collapse" aria-labelledby="headingAppointments" data-bs-parent="#medicalAccordion">
                <div class="accordion-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="appointmentsTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">History</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="appointmentsTabContent">
                        <!-- Upcoming Appointments -->
                        <div class="tab-pane fade show active p-3" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                            <!-- Buttons -->
                            <div class="d-flex flex-wrap mb-3">
                                <button class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#appointmentModal">Schedule an Appointment</button>
                                <button class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#cancelAppointmentModal">Cancel an Appointment</button>
                            </div>

                            <!-- Appointment Modal -->
                            <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="appointmentForm">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="appointmentModalLabel">Schedule an Appointment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="appointmentAlert" class="alert alert-danger d-none" role="alert"></div>
                                                <div class="mb-3">
                                                    <label for="appointmentDate" class="form-label">Date *</label>
                                                    <input type="date" id="appointmentDate" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="doctorName" class="form-label">Doctor *</label>
                                                    <input type="text" id="doctorName" class="form-control" placeholder="Doctor's name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="appointmentReason" class="form-label">Reason *</label>
                                                    <input type="text" id="appointmentReason" class="form-control" placeholder="Reason for visit" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Request Appointment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancel Appointment Modal -->
                            <div class="modal fade" id="cancelAppointmentModal" tabindex="-1" aria-labelledby="cancelAppointmentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="cancelAppointmentForm">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cancelAppointmentModalLabel">Cancel an Appointment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="cancelAppointmentAlert" class="alert alert-danger d-none" role="alert"></div>
                                                <div class="mb-3">
                                                    <label for="cancelAppointmentDate" class="form-label">Date *</label>
                                                    <input type="date" id="cancelAppointmentDate" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cancelDoctorName" class="form-label">Doctor *</label>
                                                    <input type="text" id="cancelDoctorName" class="form-control" placeholder="Doctor's name" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Cancel Appointment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Appointments Table -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="appointmentsTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Doctor</th>
                                            <th>Reason</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Upcoming appointment rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Appointment History Tab -->
                        <div class="tab-pane fade p-3" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <h3>Appointment History</h3>
                            <div class="table-responsive">
                                <table class="table table-striped" id="appointmentHistoryTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Doctor</th>
                                            <th>Reason</th>
                                            <th>Outcome</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Historical appointment rows will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Appointments Section -->

        <!-- MEDICAL INFORMATION SECTION -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingMedical">
                <button class="accordion-button collapsed bg-light text-dark fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMedical" aria-expanded="false" aria-controls="collapseMedical">
                    <i class="bi bi-file-medical me-2"></i>Medical Information
                </button>
            </h2>
            <div id="collapseMedical" class="accordion-collapse collapse" aria-labelledby="headingMedical" data-bs-parent="#medicalAccordion">
                <div class="accordion-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="medicalTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="medical-history-tab" data-bs-toggle="tab" data-bs-target="#medical-history" type="button" role="tab" aria-controls="medical-history" aria-selected="true">Medical History</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="laboratory-tests-tab" data-bs-toggle="tab" data-bs-target="#laboratory-tests" type="button" role="tab" aria-controls="laboratory-tests" aria-selected="false">Laboratory and Tests</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="medicalTabContent">
                        <!-- Medical History Tab -->
                        <div class="tab-pane fade show active p-3" id="medical-history" role="tabpanel" aria-labelledby="medical-history-tab">
                            <!-- Button to trigger the modal -->
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRecordModal">New Medical Record</button>

                            <!-- Add Record Modal -->
                            <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="addRecordForm">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addRecordModalLabel">New Medical Record</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="recordAlert" class="alert alert-danger d-none" role="alert"></div>
                                                <div class="mb-3">
                                                    <label for="recordDate" class="form-label">Date *</label>
                                                    <input type="date" id="recordDate" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="condition" class="form-label">Condition *</label>
                                                    <input type="text" id="condition" class="form-control" placeholder="Condition" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="treatment" class="form-label">Treatment *</label>
                                                    <input type="text" id="treatment" class="form-control" placeholder="Treatment" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Add Record</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Medical History Table -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="medicalHistoryTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Condition</th>
                                            <th>Treatment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Entries will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Laboratory and Tests Tab -->
                        <div class="tab-pane fade p-3" id="laboratory-tests" role="tabpanel" aria-labelledby="laboratory-tests-tab">

                            <!-- Button to trigger the modal -->
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadLabModal">Upload Laboratory Test</button>

                            <!-- Upload Laboratory Test Modal -->
                            <div class="modal fade" id="uploadLabModal" tabindex="-1" aria-labelledby="uploadLabModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="uploadLabForm" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="uploadLabModalLabel">Upload Laboratory Test</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="labAlert" class="alert alert-danger d-none" role="alert"></div>
                                                <div class="mb-3">
                                                    <label for="labTestName" class="form-label">Lab Test Name *</label>
                                                    <input type="text" id="labTestName" class="form-control" placeholder="e.g., Blood Test" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="labFile" class="form-label">Select File *</label>
                                                    <input type="file" id="labFile" class="form-control" accept=".pdf,.jpg,.png" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Laboratory Tests Table -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="laboratoryTestsTable">
                                    <thead>
                                        <tr>
                                            <th>Date Uploaded</th>
                                            <th>Lab Test</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Laboratory test entries will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End of Tab Content -->
                </div>
            </div>
        </div>
        <!-- End of Medical Information Section -->
        </div> <!-- End of Accordion -->
    </div> <!-- End of Container -->     
</div>

@endsection
</body>
</html>
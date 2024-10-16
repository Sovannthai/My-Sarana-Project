@extends('backends.master')
@section('title', 'Utilities Management')
@section('contents')
    <style>
        .nav-link.active {
            background-color: #1572e8;
            color: white;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Utilities Management</label>
            <a href="#" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="fas fa-plus"> @lang('Add Utility Rate')</i>
            </a>
        </div>
        <ul class="nav nav-tabs mb-2" id="utilityTabs">
            @foreach ($utilityTypes as $index => $utilityType)
                <li class="nav-item">
                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                        data-url="{{ route('get-rate-by-utilities_type', ['id' => $utilityType->id]) }}"
                        data-bs-toggle="tab" data-bs-target="#utilityRates{{ $utilityType->id }}"
                        data-utility-id="{{ $utilityType->id }}" onclick="setUtilityTypeId({{ $utilityType->id }})">
                        {{ $utilityType->type }}
                    </a>
                </li>
                @include('backends.utilities.create_rate')
            @endforeach
        </ul>

        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('Utility Rate')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody id="utilityRatesTableBody">
                    <!-- Rates will be show here -->
                    @include('backends.utilities.edit_rate')
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // document.addEventListener('DOMContentLoaded', () => {
        //     const tabs = document.querySelectorAll('#utilityTabs .nav-link');
        //     if (tabs.length > 0) {
        //         tabs[0].classList.add('bg-primary', 'text-white');
        //     }
        //     tabs.forEach(tab => {
        //         tab.addEventListener('click', function() {
        //             tabs.forEach(t => t.classList.remove('bg-primary', 'text-white'));
        //             this.classList.add('bg-primary', 'text-white');
        //         });
        //     });
        // });

        document.getElementById('editUtilityForm').addEventListener('submit', function(e) {
            const id = document.getElementById('editRateId').value;
            this.action = `{{ route('utilities.updateRate', ':id') }}`.replace(':id', id);
        });

        function setUtilityTypeId(utilityTypeId) {
            const form = document.querySelector('#utilityRateForm');
            form.action = `{{ route('utilities.storeRate', ['utilityType' => '__UTILITY_TYPE_ID__']) }}`.replace(
                '__UTILITY_TYPE_ID__', utilityTypeId);
            form.querySelector('input[name="utilityTypeId"]').value = utilityTypeId;
        }
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('#utilityTabs .nav-link');
            const tableBody = document.getElementById('utilityRatesTableBody');
            const storedUtilityTypeId = sessionStorage.getItem('activeUtilityTypeId');
            if (storedUtilityTypeId) {
                const activeTab = Array.from(tabs).find(tab => tab.dataset.utilityId === storedUtilityTypeId);
                if (activeTab) {
                    activateTab(activeTab);
                    loadUtilityRates(activeTab.dataset.url);
                }
            } else if (tabs.length > 0) {
                activateTab(tabs[0]);
                loadUtilityRates(tabs[0].dataset.url);
            }

            // Handle tab clicks
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    activateTab(this);
                    loadUtilityRates(this.dataset.url);
                    sessionStorage.setItem('activeUtilityTypeId', this.dataset.utilityId);
                });
            });

            // Function to activate the clicked tab
            function activateTab(tab) {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            }

            // Function to load utility rates via AJAX
            function loadUtilityRates(data_url) {
                fetch(data_url)
                    .then(response => response.json())
                    .then(data => {
                        if ($.fn.DataTable.isDataTable('#basic-datatables')) {
                            $('#basic-datatables').DataTable().clear().destroy();
                        }
                        tableBody.innerHTML = '';

                        if (data.length === 0) {
                            tableBody.innerHTML = `<tr><td colspan="3">@lang('No rates found.')</td></tr>`;
                        } else {
                            data.forEach(rate => {
                                const deleteRoute = `{{ route('utilities.destroyRate', ':id') }}`
                                    .replace(':id', rate.id);
                                const isChecked = rate.status == '1' ? 'checked' : ''; // Set status

                                const row = `
                        <tr>
                            <td>${rate.rate_per_unit}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        role="switch" id="switch${rate.id}"
                                        data-id="${rate.id}" ${isChecked}>
                                    <label class="form-check-label" for="switch${rate.id}"></label>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-btn"
                                    data-id="${rate.id}"
                                    data-rate="${rate.rate_per_unit}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUtilityModal">
                                    Edit
                                </button>
                                &nbsp;&nbsp;
                                <form action="${deleteRoute}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                        title="@lang('Delete Rate')">
                                        <i class="fa fa-trash"></i> @lang('Delete')
                                    </button>
                                </form>
                            </td>
                        </tr>`;
                                tableBody.insertAdjacentHTML('beforeend', row);
                            });

                            // Add click event to edit buttons
                            document.querySelectorAll('.edit-btn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const rateId = this.dataset.id;
                                    const ratePerUnit = this.dataset.rate;

                                    // Populate modal inputs
                                    document.getElementById('editRateId').value = rateId;
                                    document.getElementById('editRatePerUnit').value =
                                        ratePerUnit;
                                });
                            });
                        }

                        // Reinitialize DataTable with new data
                        $('#basic-datatables').DataTable({
                            responsive: true,
                            pageLength: 5,
                            lengthMenu: [5, 10, 20, 100],
                            language: {
                                search: "@lang('Search'):",
                                lengthMenu: "@lang('Show _MENU_ entries')",
                                info: "@lang('Showing _START_ to _END_ of _TOTAL_ entries')",
                                infoEmpty: "@lang('No entries available')",
                                paginate: {
                                    next: "@lang('Next')",
                                    previous: "@lang('Previous')"
                                }
                            }
                        });

                        function setupEditButtons() {
                            document.querySelectorAll('.edit-btn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const rateId = this.dataset.id;
                                    const ratePerUnit = this.dataset.rate;
                                    document.getElementById('editRateId').value = rateId;
                                    document.getElementById('editRatePerUnit').value =
                                        ratePerUnit;
                                });
                            });
                        }

                        function setupStatusToggles() {
                            document.querySelectorAll('.status-toggle').forEach(toggle => {
                                toggle.addEventListener('change', function() {
                                    const status = this.checked ? 'true' : 'false';
                                    const id = this.dataset.id;
                                    updateStatus(id, status);
                                });
                            });
                        }
                        // Handle switch toggle event
                        document.querySelectorAll('.status-toggle').forEach(switchElement => {
                            switchElement.addEventListener('change', function() {
                                const status = this.checked ? 'true' : 'false';
                                const id = this.getAttribute('data-id');

                                updateStatus(id, status);
                            });
                        });
                    })
                    .catch(error => console.error('Error fetching rates:', error));
            }

            //Update Status
            function updateStatus(id, status) {
                fetch('{{ route('update-status-utilities') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id,
                            status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000,
                            extendedTimeOut: 2000,
                            positionClass: "toast-top-right"
                        };

                        if (data.success) {
                            toastr.success(data.msg || 'Status updated successfully.');
                            location.reload();
                        } else {
                            toastr.error(data.msg || 'An error occurred while updating the status.');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000,
                            extendedTimeOut: 2000,
                            positionClass: "toast-top-right"
                        };
                        toastr.error('An unexpected error occurred.');
                    });
            }
            // Handle form submission
            const form = document.querySelector('#staticBackdrop form');
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(form); // Create FormData object
                const actionUrl = form.action;

                fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json()) // Parse JSON response
                    .then(data => {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000,
                            extendedTimeOut: 2000,
                            positionClass: "toast-top-right"
                        };

                        if (data.success) {
                            toastr.success(data.message || 'Utility rate created successfully.');

                            form.reset();
                            sessionStorage.setItem('activeUtilityTypeId', formData.get(
                                'utilityTypeId'));
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'staticBackdrop'));
                            modal.hide();
                            const activeTab = document.querySelector('#utilityTabs .nav-link.active');
                            if (activeTab) {
                                loadUtilityRates(activeTab.dataset.url);
                            }
                        } else {
                            toastr.error(data.message ||
                                'An error occurred while creating the utility rate.');
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting form:', error);
                        toastr.error('An unexpected error occurred while submitting the form.');
                    });
            });
        });
    </script>
@endsection

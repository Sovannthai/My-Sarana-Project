@extends('backends.master')
@section('title', 'Utilities Management')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Utilities Management</label>
            <a href="#" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="fas fa-plus"> @lang('Add Utility Type')</i>
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
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody id="utilityRatesTableBody">
                    <!-- Rates will be populated here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function setUtilityTypeId(utilityTypeId) {
            const form = document.querySelector('#staticBackdrop form');
            form.action = "{{ route('utilities.storeRate', ['utilityType' => '__UTILITY_TYPE_ID__']) }}".replace(
                '__UTILITY_TYPE_ID__', utilityTypeId);

            // Set the utilityTypeId in the hidden input
            form.querySelector('input[name="utilityTypeId"]').value = utilityTypeId;
        }
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('#utilityTabs .nav-link');
            const tableBody = document.getElementById('utilityRatesTableBody');

            // Retrieve the stored tab ID from session storage
            const storedUtilityTypeId = sessionStorage.getItem('activeUtilityTypeId');

            // If there's a stored ID, set the corresponding tab as active
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
                    // Store the active tab ID in session storage
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
                        // Destroy the existing DataTable if it exists
                        if ($.fn.DataTable.isDataTable('#basic-datatables')) {
                            $('#basic-datatables').DataTable().clear().destroy();
                        }

                        // Clear table body
                        tableBody.innerHTML = '';

                        if (data.length === 0) {
                            // Display message if no data found
                            tableBody.innerHTML = `<tr><td colspan="2">@lang('No rates found.')</td></tr>`;
                        } else {
                            // Insert rows with new data
                            data.forEach(rate => {
                                const row = `
                            <tr>
                                <td>${rate.rate_per_unit}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">@lang('Edit')</button>
                                    <button class="btn btn-sm btn-danger">@lang('Delete')</button>
                                </td>
                            </tr>
                        `;
                                tableBody.insertAdjacentHTML('beforeend', row);
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
                    })
                    .catch(error => console.error('Error fetching rates:', error));
            }
            // Handle form submission
            const form = document.querySelector('#staticBackdrop form');
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(form); // Collect form data
                const actionUrl = form.action; // Get the form action URL

                // Send the form data via fetch
                fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success toast using Toastr
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "timeOut": "3000",
                                "extendedTimeOut": "2000",
                                "positionClass": "toast-top-right"
                            };
                            toastr.success(data.message);

                            // Clear the form inputs
                            form.reset();

                            // Store the utility type ID to be active after refresh
                            sessionStorage.setItem('activeUtilityTypeId', formData.get(
                            'utilityTypeId')); // Adjust based on your form field name

                            // Optionally close the modal
                            $('#staticBackdrop').modal('hide');

                            // Reload utility rates for the currently active tab
                            const activeTab = document.querySelector('#utilityTabs .nav-link.active');
                            loadUtilityRates(activeTab.dataset.url);
                        } else {
                            // Show error toast if applicable
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "timeOut": "3000",
                                "extendedTimeOut": "2000",
                                "positionClass": "toast-top-right"
                            };
                            toastr.error(data.message ||
                                'An error occurred while creating the utility rate.');
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting form:', error);
                        toastr.error('An error occurred while submitting the form.');
                    });
            });


        });
    </script>
@endsection

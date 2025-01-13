@extends('backends.master')
@section('title', __('Utilities Management'))
@section('contents')
    <style>
        .nav-link.active {
            background-color: #1572e8;
            color: white;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Utilities Management')</label>
            @can('create utility')
            <a href="#" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="fas fa-plus"></i> @lang('Add Utility Rate')
            </a>
            @endcan
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
                <thead class="table-dark">
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
        const form = document.querySelector('#editUtilityForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(form);
            const actionUrl = form.action.replace(':id', document.getElementById('editRateId').value);

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
                        toastr.success('Utility rate updated successfully.');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);

                        form.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editUtilityModal'));
                        modal.hide();

                        const activeTab = document.querySelector('#utilityTabs .nav-link.active');
                        if (activeTab) {
                            loadUtilityRates(activeTab.dataset.url);
                        }
                    } else {
                        toastr.error('An error occurred while updating the utility rate.');
                    }
                })
        });

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
            const exchangeRate = @json($baseExchangeRate);
            const currencySymbol = @json($currencySymbol);

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

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    activateTab(this);
                    loadUtilityRates(this.dataset.url);
                    sessionStorage.setItem('activeUtilityTypeId', this.dataset.utilityId);
                });
            });

            function activateTab(tab) {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            }

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
                                const convertedRate = rate.rate_per_unit * exchangeRate;
                                const isChecked = rate.status == '1' ? 'checked' : '';

                                const row = `
                        <tr>
                            <td>${currencySymbol} ${convertedRate.toFixed(2)}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        role="switch" id="switch${rate.id}"
                                        data-id="${rate.id}" ${isChecked}>
                                    <label class="form-check-label" for="switch${rate.id}"></label>
                                </div>
                            </td>
                            <td>
                                @can('update utility')
                                <button class="btn btn-sm btn-outline-primary edit-btn"
                                    data-id="${rate.id}"
                                    data-rate="${convertedRate.toFixed(2)}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUtilityModal">
                                    Edit
                                </button>
                                &nbsp;&nbsp;
                                @endcan
                                @can('delete utility')
                                <form action="${deleteRoute}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                        title="@lang('Delete Rate')">
                                        <i class="fa fa-trash"></i> @lang('Delete')
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>`;
                                tableBody.insertAdjacentHTML('beforeend', row);
                            });

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
            }
            // Handle Modal Create
            const form = document.querySelector('#staticBackdrop form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const actionUrl = form.action;

                fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
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
            });
        });
    </script>
@endsection

@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">

    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li><a href="{{ route('dashboard.residentsgraph') }}" class="text-primary hover:underline">Dashboard</a></li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <a href="{{ route('households.index') }}" class="text-primary hover:underline">Household Records</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <a href="{{ route('households.show', $household) }}" class="text-primary hover:underline">{{ $household->household_number }}</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <span>Add Member</span>
        </li>
    </ul>

    <div class="pt-5">
        <div class="mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">Add Member to Household: <strong>{{ $household->household_number }}</strong></h5>
        </div>

        <div class="panel">
            
            <div class="mb-6 p-5 border rounded-lg bg-gray-50">
                <h6 class="font-semibold text-lg mb-3">
                    <i class="fas fa-search mr-2"></i> Search Existing Residents
                </h6>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-12">
                    <div class="sm:col-span-8">
                        <div class="search-container relative">
                            <input type="text" 
                                   class="form-input" 
                                   id="resident-search" 
                                   placeholder="Type resident's name to search and auto-fill..."
                                   autocomplete="off">
                            <div id="resident-search-results" class="absolute w-full bg-white border border-gray-300 rounded-b shadow-lg" style="z-index: 1000; max-height: 300px; overflow-y: auto; display: none; top: 100%;"></div>
                        </div>
                    </div>
                        <div class="flex items-center justify-end space-x-2 rtl:space-x-reverse">
                            <button type="button" class="btn btn-secondary" id="clear-form">
                                <i class="fas fa-refresh mr-1"></i> Clear Form
                            </button>
                            <button type="button" class="btn btn-warning" id="enable-editing" style="display: none;">
                                <i class="fas fa-edit mr-1"></i> Enable Manual Editing
                            </button>
                        </div>
                    </div>
                <p class="text-sm text-gray-600 mt-2">
                    Search for an existing resident to auto-fill their information, or fill the form manually.
                </p>
            </div>

            <form action="{{ route('households.store-member', $household) }}" method="POST">
                @csrf
                
                
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-12">
                    <div class="sm:col-span-4">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input id="last_name" name="last_name" type="text" placeholder="Enter last name" 
                               class="form-input @error('last_name') border-red-500 @enderror" 
                               value="{{ old('last_name') }}" required />
                        @error('last_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-4">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input id="first_name" name="first_name" type="text" placeholder="Enter first name" 
                               class="form-input @error('first_name') border-red-500 @enderror" 
                               value="{{ old('first_name') }}" required />
                        @error('first_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input id="middle_name" name="middle_name" type="text" placeholder="Middle name" 
                               class="form-input @error('middle_name') border-red-500 @enderror" 
                               value="{{ old('middle_name') }}" />
                        @error('middle_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-1">
                        <label for="extension" class="form-label">Ext</label>
                        <input id="extension" name="extension" type="text" placeholder="Jr., Sr." 
                               class="form-input @error('extension') border-red-500 @enderror" 
                               value="{{ old('extension') }}" />
                        @error('extension')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

               
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div>
                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                        <input id="place_of_birth" name="place_of_birth" type="text" placeholder="Place of birth" 
                               class="form-input @error('place_of_birth') border-red-500 @enderror" 
                               value="{{ old('place_of_birth') }}" />
                        @error('place_of_birth')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" 
                               class="form-input @error('date_of_birth') border-red-500 @enderror" 
                               value="{{ old('date_of_birth') }}" />
                        @error('date_of_birth')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                        <select id="sex" name="sex" class="form-select @error('sex') border-red-500 @enderror" required>
                            <option value="">Select Sex</option>
                            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="civil_status" class="form-label">Civil Status <span class="text-danger">*</span></label>
                        <select id="civil_status" name="civil_status" class="form-select @error('civil_status') border-red-500 @enderror" required>
                            <option value="">Select Status</option>
                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                        @error('civil_status')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div>
                        <label for="citizenship" class="form-label">Citizenship</label>
                        <input id="citizenship" name="citizenship" type="text" placeholder="e.g. Filipino" 
                               class="form-input @error('citizenship') border-red-500 @enderror" 
                               value="{{ old('citizenship') }}" />
                        @error('citizenship')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="occupation" class="form-label">Occupation</label>
                        <input id="occupation" name="occupation" type="text" placeholder="Occupation" 
                               class="form-input @error('occupation') border-red-500 @enderror" 
                               value="{{ old('occupation') }}" />
                        @error('occupation')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="labor_employment_status" class="form-label">Labor/Employment Status</label>
                        <select id="labor_employment_status" name="labor_employment_status" class="form-select @error('labor_employment_status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="Labor/employed" {{ old('labor_employment_status') == 'Labor/employed' ? 'selected' : '' }}>Labor/employed</option>
                            <option value="Unemployed" {{ old('labor_employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                            <option value="PWD" {{ old('labor_employment_status') == 'PWD' ? 'selected' : '' }}>PWD</option>
                            <option value="Solo Parent" {{ old('labor_employment_status') == 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                            <option value="Out of School Youth (OSY)" {{ old('labor_employment_status') == 'Out of School Youth (OSY)' ? 'selected' : '' }}>Out of School Youth (OSY)</option>
                            <option value="Out of School Children (OSC)" {{ old('labor_employment_status') == 'Out of School Children (OSC)' ? 'selected' : '' }}>Out of School Children (OSC)</option>
                            <option value="IP" {{ old('labor_employment_status') == 'IP' ? 'selected' : '' }}>IP</option>
                        </select>
                        @error('labor_employment_status')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="relationship_to_head" class="form-label">Relationship to Head</label>
                        <input id="relationship_to_head" name="relationship_to_head" type="text" placeholder="e.g. Spouse, Child" 
                               class="form-input @error('relationship_to_head') border-red-500 @enderror" 
                               value="{{ old('relationship_to_head') }}" />
                        @error('relationship_to_head')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                
                <div class="mb-5">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_head" value="1" class="form-checkbox" {{ old('is_head') ? 'checked' : '' }} />
                        <span class="text-white-dark ml-2">This person is the household head</span>
                    </label>
                    <div class="text-xs text-white-dark mt-1">Check this if this person is the head of the household. This will unmark any existing household head.</div>
                </div>

                <div class="mt-8 flex items-center justify-end">
                    <a href="{{ route('households.show', $household) }}" class="btn btn-outline-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<style>
.auto-filled-field {
    background-color: #f8f9fa !important;
    border: 1px solid #28a745 !important;
    position: relative;
}

.auto-filled-field:disabled {
    background-color: #e9ecef !important;
    cursor: not-allowed !important;
    opacity: 0.8;
}

.resident-result:hover {
    background-color: #f8f9fa !important;
}

.search-container {
    position: relative;
}

#resident-search-results {
    max-height: 300px;
    overflow-y: auto;
    border-top: none !important;
}

.auto-filled-indicator {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #28a745;
    color: white;
    font-size: 10px;
    padding: 2px 4px;
    border-radius: 3px;
    pointer-events: none;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('resident-search');
    const searchResults = document.getElementById('resident-search-results');
    const clearFormBtn = document.getElementById('clear-form');
    const enableEditingBtn = document.getElementById('enable-editing');
    let searchTimeout;
    let isAutoFilled = false;

    
    const formFields = {
        last_name: document.getElementById('last_name'),
        first_name: document.getElementById('first_name'),
        middle_name: document.getElementById('middle_name'),
        extension: document.getElementById('extension'),
        place_of_birth: document.getElementById('place_of_birth'),
        date_of_birth: document.getElementById('date_of_birth'),
        sex: document.getElementById('sex'),
        civil_status: document.getElementById('civil_status'),
        citizenship: document.getElementById('citizenship'),
        occupation: document.getElementById('occupation')
    };

 
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            hideResults();
            return;
        }

        searchTimeout = setTimeout(() => {
            searchResidents(query);
        }, 300);
    });

    
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            hideResults();
        }
    });

   
    clearFormBtn.addEventListener('click', function() {
        clearForm();
        searchInput.value = '';
        hideResults();
    });

    
    enableEditingBtn.addEventListener('click', function() {
        enableFormEditing();
        showNotification('Manual editing enabled! You can now modify the form fields.', 'info');
    });

    function searchResidents(query) {
        fetch(`{{ route('resident.search') }}?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displayResults(data);
            })
            .catch(error => {
                console.error('Error searching residents:', error);
                hideResults();
            });
    }

    function displayResults(residents) {
        if (residents.length === 0) {
            searchResults.innerHTML = '<div class="p-3 text-muted">No residents found</div>';
            searchResults.style.display = 'block';
            return;
        }

        const resultsHtml = residents.map(resident => `
            <div class="resident-result p-3 border-bottom cursor-pointer hover:bg-gray-50" 
                 data-resident='${JSON.stringify(resident)}' 
                 style="cursor: pointer;">
                <div class="fw-bold">${resident.full_name}</div>
                <small class="text-muted">
                    ${resident.sex || 'N/A'} • ${resident.birth_date || 'N/A'} • ${resident.occupation || 'N/A'}
                </small>
            </div>
        `).join('');

        searchResults.innerHTML = resultsHtml;
        searchResults.style.display = 'block';

       
        searchResults.querySelectorAll('.resident-result').forEach(result => {
            result.addEventListener('click', function() {
                const resident = JSON.parse(this.dataset.resident);
                fillForm(resident);
                disableFormFields();
                hideResults();
                searchInput.value = resident.full_name;
                isAutoFilled = true;
                enableEditingBtn.style.display = 'inline-block';
            });
        });
    }

    function fillForm(resident) {
        if (formFields.last_name) formFields.last_name.value = resident.last_name || '';
        if (formFields.first_name) formFields.first_name.value = resident.first_name || '';
        if (formFields.middle_name) formFields.middle_name.value = resident.middle_name || '';
        if (formFields.extension) formFields.extension.value = resident.suffix || '';
        if (formFields.place_of_birth) formFields.place_of_birth.value = resident.birth_place || '';
        if (formFields.date_of_birth) formFields.date_of_birth.value = resident.birth_date || '';
        if (formFields.citizenship) formFields.citizenship.value = resident.citizenship || '';
        if (formFields.occupation) formFields.occupation.value = resident.occupation || '';

        
        if (formFields.sex && resident.sex) {
            formFields.sex.value = resident.sex;
        }
        
        if (formFields.civil_status && resident.civil_status) {
            formFields.civil_status.value = resident.civil_status;
        }

      
        Object.values(formFields).forEach(field => {
            if (field && field.value) {
                field.style.backgroundColor = '#e8f5e8';
                field.style.border = '2px solid #28a745';
                setTimeout(() => {
                    if (isAutoFilled) {
                        field.style.backgroundColor = '#f8f9fa';
                        field.style.border = '1px solid #28a745';
                    } else {
                        field.style.backgroundColor = '';
                        field.style.border = '';
                    }
                }, 2000);
            }
        });

       
        showNotification('Resident information auto-filled successfully! Fields are now locked for data integrity.', 'success');
    }

    function clearForm() {
        Object.values(formFields).forEach(field => {
            if (field) {
                field.value = '';
                field.style.backgroundColor = '';
                field.style.border = '';
                field.disabled = false;
                field.classList.remove('auto-filled-field');
                field.title = '';
                
               
                const indicator = field.parentNode.querySelector('.auto-filled-indicator');
                if (indicator) {
                    indicator.remove();
                }
            }
        });
        
        
        const allInputs = document.querySelectorAll('form input, form select');
        allInputs.forEach(input => {
            if (input.type !== 'hidden' && input.name !== '_token' && input.name !== 'is_head' && !input.classList.contains('auto-filled-hidden')) {
                input.value = '';
                if (input.tagName === 'SELECT') {
                    input.disabled = false;
                } else {
                    input.readOnly = false;
                }
                input.classList.remove('auto-filled-field');
                input.style.backgroundColor = '';
                input.style.border = '';
                input.title = '';
                if (input.type === 'checkbox') {
                    input.checked = false;
                }
                
                
                const indicator = input.parentNode.querySelector('.auto-filled-indicator');
                if (indicator) {
                    indicator.remove();
                }
            }
        });

        
        const hiddenInputs = document.querySelectorAll('.auto-filled-hidden');
        hiddenInputs.forEach(input => input.remove());

        isAutoFilled = false;
        enableEditingBtn.style.display = 'none';
        showNotification('Form cleared successfully! All fields are now available for manual input.', 'info');
    }

    function disableFormFields() {
        Object.values(formFields).forEach(field => {
            if (field && field.value) {
                if (field.tagName === 'SELECT') {
                    field.disabled = true;
                    let hiddenInput = field.parentNode.querySelector('.auto-filled-hidden');
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = field.name;
                        hiddenInput.className = 'auto-filled-hidden';
                        field.parentNode.appendChild(hiddenInput);
                    }
                    hiddenInput.value = field.value;
                } else {
                    field.readOnly = true;
                }
                
                field.classList.add('auto-filled-field');
                field.style.cursor = 'not-allowed';
                field.title = 'This field was auto-filled from resident data. Click "Enable Manual Editing" to modify.';
                
                
                if (!field.parentNode.querySelector('.auto-filled-indicator')) {
                    const indicator = document.createElement('span');
                    indicator.className = 'auto-filled-indicator';
                    indicator.textContent = 'AUTO';
                    indicator.title = 'Auto-filled from resident database';
                    field.parentNode.style.position = 'relative';
                    field.parentNode.appendChild(indicator);
                }
            }
        });
    }

    function enableFormEditing() {
        
        Object.values(formFields).forEach(field => {
            if (field) {
                if (field.tagName === 'SELECT') {
                    field.disabled = false;
                    const hiddenInput = field.parentNode.querySelector('.auto-filled-hidden');
                    if (hiddenInput) {
                        hiddenInput.remove();
                    }
                } else {
                    field.readOnly = false;
                }
                
                field.classList.remove('auto-filled-field');
                field.style.cursor = '';
                field.style.backgroundColor = '';
                field.style.border = '';
                field.title = '';
                
                
                const indicator = field.parentNode.querySelector('.auto-filled-indicator');
                if (indicator) {
                    indicator.remove();
                }
            }
        });

        const allInputs = document.querySelectorAll('form input, form select');
        allInputs.forEach(input => {
            if (input.type !== 'hidden' && input.name !== '_token' && !input.classList.contains('auto-filled-hidden')) {
                if (input.tagName === 'SELECT') {
                    input.disabled = false;
                } else {
                    input.readOnly = false;
                }
                input.classList.remove('auto-filled-field');
                input.style.cursor = '';
                input.title = '';
                
              
                const indicator = input.parentNode.querySelector('.auto-filled-indicator');
                if (indicator) {
                    indicator.remove();
                }
            }
        });

        isAutoFilled = false;
        enableEditingBtn.style.display = 'none';
    }

    function hideResults() {
        searchResults.style.display = 'none';
    }

    function showNotification(message, type = 'info') {
       
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }
});
</script>
@endpush

@extends('layouts.admin')

@section('title', 'Create New Project')

@section('content')
<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <div>
            <!-- ... Previous Basic Info and Stages cards ... (I will keep them but focus on adding new sections) -->
            <div class="card-premium">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1.5rem;">Project Basic Information</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Project Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Modern Villa Interior" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Project Type</label>
                        <select name="type" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                            <option value="Interior Design">Interior Design</option>
                            <option value="Civil Construction">Civil Construction</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <label style="font-size: 0.9rem; font-weight: 500;">Site Address</label>
                        <button type="button" id="open-map-picker" class="btn-premium" style="padding: 4px 10px; font-size: 0.75rem; background: #f8fafc; color: var(--primary); border: 1px solid var(--border);">
                            <i class="fas fa-map-marker-alt"></i> Pick on Map
                        </button>
                    </div>
                    <textarea id="site_address" name="site_address" rows="3" class="form-control" placeholder="Full address of the construction site" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);"></textarea>
                </div>

                <!-- Map Preview Container -->
                <div id="map-preview-container" style="margin-bottom: 1.5rem; display: none;">
                    <div style="width: 100%; height: 200px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border);">
                        <iframe id="google-map-iframe" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Map Picker Modal (hidden by default) -->
                <div id="map-modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
                    <div class="card-premium" style="width: 90%; max-width: 800px; height: 600px; position: relative;">
                        <button type="button" id="close-map-modal" style="position: absolute; top: 10px; right: 10px; border: none; background: #fff; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; z-index: 10001;"><i class="fas fa-times"></i></button>
                        <h3 style="margin-bottom: 1rem;">Select Site Location</h3>
                        <div id="map-picker-div" style="width: 100%; height: calc(100% - 100px); border-radius: 12px;"></div>
                        <div style="margin-top: 1rem; text-align: right;">
                            <button type="button" id="confirm-location" class="btn-premium">Confirm Location</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-premium">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1.5rem;">Supervisors Assignment</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                    @php $supervisors = \App\Models\User::where('role', 'supervisor')->get(); @endphp
                    @forelse($supervisors as $supervisor)
                    <label style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid var(--border); border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                        <input type="checkbox" name="supervisor_ids[]" value="{{ $supervisor->id }}" style="width: 18px; height: 18px; accent-color: var(--primary);">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600; color: var(--primary);">
                            {{ substr($supervisor->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; font-weight: 600;">{{ $supervisor->name }}</div>
                            <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $supervisor->is_active ? 'Active' : 'Inactive' }}</div>
                        </div>
                    </label>
                    @empty
                    <p style="grid-column: 1/-1; text-align: center; color: var(--text-muted); font-size: 0.85rem;">No supervisors found. <a href="{{ route('admin.users.create') }}" style="color: var(--primary);">Add one here.</a></p>
                    @endforelse
                </div>
            </div>

            <div class="card-premium">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1.5rem;">Project Documents</h2>
                <div style="padding: 2rem; border: 2px dashed var(--border); border-radius: 12px; text-align: center;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                    <p style="margin-bottom: 1rem; color: var(--text-muted);">Upload project contracts, drawings, or site plans (Multiple files allowed)</p>
                    <input type="file" name="documents[]" multiple class="form-control" style="width: 100%; max-width: 300px; margin: 0 auto;">
                </div>
            </div>

            <div class="card-premium">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.2rem; font-weight: 600; margin: 0;">Project Stages</h2>
                    <button type="button" id="add-stage" class="btn-premium" style="background: #f1f5f9; color: #475569; padding: 5px 12px; font-size: 0.8rem;">
                        <i class="fas fa-plus"></i> Add Stage
                    </button>
                </div>
                <div id="stages-container">
                    <!-- Default Stage remains here -->
                    <div class="stage-row card-premium" style="background: #f8fafc; padding: 1rem; border-style: dashed;">
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 1rem;">
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 500;">Stage Name</label>
                                <input type="text" name="stages[0][name]" value="Initial Stage / Mobilization" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 500;">Budget (Int.)</label>
                                <input type="number" step="0.001" name="stages[0][budget]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 500;">Client Pay</label>
                                <input type="number" step="0.001" name="stages[0][client_payment_amount]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 500;">Weight %</label>
                                <input type="number" step="0.01" name="stages[0][weight_percentage]" class="stage-weight form-control" value="100" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 500;">Start Date</label>
                                <input type="date" name="stages[0][start_date]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 500;">End Date</label>
                                <input type="date" name="stages[0][end_date]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                            <div style="display: flex; align-items: flex-end; justify-content: flex-end;">
                                <span style="font-size: 0.8rem; color: var(--text-muted);">Total Weight: <span id="weight-total">100</span>%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card-premium">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1.5rem;">Client Details</h2>
                
                <div style="margin-bottom: 1.5rem; display: flex; gap: 10px; background: #f8fafc; padding: 5px; border-radius: 10px;">
                    <button type="button" id="btn-existing-client" class="btn-premium" style="flex: 1; justify-content: center; background: var(--primary); color: #fff;">Existing</button>
                    <button type="button" id="btn-new-client" class="btn-premium" style="flex: 1; justify-content: center; background: transparent; color: var(--text-muted);">New</button>
                    <input type="hidden" name="client_selection_type" id="client_selection_type" value="existing">
                </div>

                <div id="existing-client-section">
                    <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Select Existing Client</label>
                    @php $clients = \App\Models\User::where('role', 'client')->get(); @endphp
                    <select name="client_id" class="form-control" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                        <option value="">-- Choose Client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div id="new-client-section" style="display: none;">
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 0.3rem;">Client Name</label>
                        <input type="text" name="client_name" class="form-control" style="width: 100%; padding: 0.7rem; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 0.3rem;">Client Email</label>
                        <input type="email" name="client_email" class="form-control" style="width: 100%; padding: 0.7rem; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 0.3rem;">Client Phone</label>
                        <input type="text" name="client_phone" class="form-control" style="width: 100%; padding: 0.7rem; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #eff6ff; border-radius: 10px; margin-top: 1rem;">
                        <span style="font-size: 0.85rem; font-weight: 600; color: var(--primary);">Create Portal Account?</span>
                        <label class="switch" style="position: relative; display: inline-block; width: 44px; height: 22px;">
                            <input type="checkbox" name="create_account" value="1" style="opacity: 0; width: 0; height: 0;">
                            <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px;"></span>
                        </label>
                    </div>
                    <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 8px;">* Credentials: Email will be used as both username and password.</p>
                </div>
            </div>

            <div class="card-premium">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1.5rem;">Financial Foundation</h2>
                
                <div style="margin-bottom: 1.5rem; background: #f0f9ff; padding: 1rem; border-radius: 10px; border: 1px solid #bae6fd;">
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #0369a1; margin-bottom: 0.5rem;">Total Project Value (Sum of Stages)</label>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">BHD <span id="display-total-value">0.000</span></div>
                    <input type="hidden" name="project_value" id="hidden-project-value" value="0">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Est. Internal Cost</label>
                    <input type="number" step="0.001" name="estimated_internal_cost" placeholder="0.000" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">End Date</label>
                        <input type="date" name="end_date" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    </div>
                </div>
                <button type="submit" class="btn-premium" style="width: 100%; justify-content: center; padding: 1rem;">
                    <i class="fas fa-save"></i> Create Project
                </button>
            </div>
        </div>
    </div>
</form>

<style>
    .slider:before {
        position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%;
    }
    input:checked + .slider { background-color: var(--primary); }
    input:checked + .slider:before { transform: translateX(22px); }
</style>

<script>
    // Existing Client vs New Client Toggle
    const btnExisting = document.getElementById('btn-existing-client');
    const btnNew = document.getElementById('btn-new-client');
    const existingSection = document.getElementById('existing-client-section');
    const newSection = document.getElementById('new-client-section');
    const selectionInput = document.getElementById('client_selection_type');

    btnExisting.addEventListener('click', () => {
        btnExisting.style.background = 'var(--primary)';
        btnExisting.style.color = '#fff';
        btnNew.style.background = 'transparent';
        btnNew.style.color = 'var(--text-muted)';
        existingSection.style.display = 'block';
        newSection.style.display = 'none';
        selectionInput.value = 'existing';
    });

    btnNew.addEventListener('click', () => {
        btnNew.style.background = 'var(--primary)';
        btnNew.style.color = '#fff';
        btnExisting.style.background = 'transparent';
        btnExisting.style.color = 'var(--text-muted)';
        existingSection.style.display = 'none';
        newSection.style.display = 'block';
        selectionInput.value = 'new';
    });

    // ... Rest of the Stage JS logic (Total weight calculation, etc.) ...
</script>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Project Value (Client Pays)</label>
                    <input type="number" step="0.001" name="project_value" placeholder="0.000" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Est. Internal Cost</label>
                    <input type="number" step="0.001" name="estimated_internal_cost" placeholder="0.000" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">End Date</label>
                        <input type="date" name="end_date" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    </div>
                </div>

                <button type="submit" class="btn-premium" style="width: 100%; justify-content: center; padding: 1rem;">
                    <i class="fas fa-save"></i> Create Project
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    let stageCount = 1;
    const container = document.getElementById('stages-container');
    const addBtn = document.getElementById('add-stage');
    const totalWeightSpan = document.getElementById('weight-total');
    const weightError = document.getElementById('weight-error');

    const displayTotalValue = document.getElementById('display-total-value');
    const hiddenProjectValue = document.getElementById('hidden-project-value');

    function updateTotalWeight() {
        let total = 0;
        document.querySelectorAll('.stage-weight').forEach(input => {
            total += parseFloat(input.value || 0);
        });
        totalWeightSpan.textContent = total.toFixed(2);
        
        if (total !== 100) {
            weightError.style.display = 'block';
        } else {
            weightError.style.display = 'none';
        }
    }

    function updateTotalProjectValue() {
        let total = 0;
        document.querySelectorAll('input[name*="client_payment_amount"]').forEach(input => {
            total += parseFloat(input.value || 0);
        });
        displayTotalValue.textContent = total.toFixed(3);
        hiddenProjectValue.value = total;
    }

    addBtn.addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'stage-row card-premium';
        div.style.background = '#f8fafc';
        div.style.padding = '1rem';
        div.style.borderStyle = 'dashed';
        div.style.marginTop = '1rem';
        
        div.innerHTML = `
            <div style="display: flex; justify-content: flex-end; margin-bottom: 0.5rem;">
                <button type="button" class="remove-stage" style="color: #ef4444; background: none; border: none; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="font-size: 0.8rem; font-weight: 500;">Stage Name</label>
                    <input type="text" name="stages[${stageCount}][name]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 500;">Budget (Int.)</label>
                    <input type="number" step="0.001" name="stages[${stageCount}][budget]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 500;">Client Pay</label>
                    <input type="number" step="0.001" name="stages[${stageCount}][client_payment_amount]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 500;">Weight %</label>
                    <input type="number" step="0.01" name="stages[${stageCount}][weight_percentage]" class="stage-weight form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                <div>
                    <label style="font-size: 0.8rem; font-weight: 500;">Start Date</label>
                    <input type="date" name="stages[${stageCount}][start_date]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 500;">End Date</label>
                    <input type="date" name="stages[${stageCount}][end_date]" class="form-control" required style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border);">
                </div>
            </div>
        `;
        
        container.appendChild(div);
        
        div.querySelector('.remove-stage').addEventListener('click', () => {
            div.remove();
            updateTotalWeight();
            updateTotalProjectValue();
        });
        
        stageCount++;
        updateTotalWeight();
        updateTotalProjectValue();
    });

    // Delegate events for dynamic inputs
    container.addEventListener('input', (e) => {
        if (e.target.classList.contains('stage-weight')) {
            updateTotalWeight();
        }
        if (e.target.name.includes('client_payment_amount')) {
            updateTotalProjectValue();
        }
    });

    // Initial call
    updateTotalProjectValue();
    updateTotalWeight();

    // --- Map Logic ---
    const siteAddressTextarea = document.getElementById('site_address');
    const mapPreviewContainer = document.getElementById('map-preview-container');
    const googleMapIframe = document.getElementById('google-map-iframe');
    const openMapPickerBtn = document.getElementById('open-map-picker');
    const mapModal = document.getElementById('map-modal');
    const closeMapModal = document.getElementById('close-map-modal');
    const confirmLocationBtn = document.getElementById('confirm-location');

    let mapPicker;
    let marker;
    let selectedAddress = '';

    // Update Preview on typing
    siteAddressTextarea.addEventListener('input', function() {
        const address = this.value.trim();
        if (address.length > 5) {
            mapPreviewContainer.style.display = 'block';
            googleMapIframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(address)}&t=&z=13&ie=UTF8&iwloc=&output=embed`;
        } else {
            mapPreviewContainer.style.display = 'none';
        }
    });

    // Map Picker Initialization
    openMapPickerBtn.addEventListener('click', () => {
        mapModal.style.display = 'flex';
        if (!mapPicker) {
            mapPicker = L.map('map-picker-div').setView([26.0667, 50.5577], 11); // Default to Bahrain
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapPicker);

            mapPicker.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) mapPicker.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(mapPicker);

                // Reverse Geocoding using Nominatim (Free)
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        selectedAddress = data.display_name;
                    });
            });
        }
        setTimeout(() => mapPicker.invalidateSize(), 200);
    });

    closeMapModal.addEventListener('click', () => {
        mapModal.style.display = 'none';
    });

    confirmLocationBtn.addEventListener('click', () => {
        if (selectedAddress) {
            siteAddressTextarea.value = selectedAddress;
            siteAddressTextarea.dispatchEvent(new Event('input')); // Trigger preview update
        }
        mapModal.style.display = 'none';
    });
</script>
@endsection

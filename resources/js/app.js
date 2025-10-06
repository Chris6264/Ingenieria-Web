import './bootstrap';

// Esperar a que el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    // Verificar que estamos en la página correcta
    const prescriptionForm = document.getElementById('prescriptionForm');
    if (!prescriptionForm) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const pharmacyInput = document.getElementById('pharmacy');
    const branchInput = document.getElementById('branch');
    const branchIdInput = document.getElementById('branchId');
    const branchFarmInput = document.getElementById('branchFarm');
    const branchFarmDisplay = document.getElementById('branchFarmDisplay');
    const medicationInput = document.getElementById('medication');
    const quantityInput = document.getElementById('quantity');
    const inStockInput = document.getElementById('inStock');
    const btnAgregar = document.getElementById('btnAgregar');
    const prescriptionBody = document.getElementById('prescriptionDescription');
    const medicationsCountInput = document.getElementById('medications_count');
    const btnGenerar = document.getElementById('btnGenerar');

    let hasPending = false;

    function updateGenerateButton() {
        const hasMedications = prescriptionBody.querySelectorAll('tr:not(:has(td[colspan]))').length > 0;
        btnGenerar.disabled = !hasMedications;
    }

    function debounce(func, wait = 300) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    const enableMedicationFields = (enable) => {
        medicationInput.disabled = !enable;
        quantityInput.disabled = !enable;
        btnAgregar.disabled = !enable;
        if (!enable) {
            medicationInput.value = '';
            quantityInput.value = 0;
            inStockInput.value = 0;
            quantityInput.removeAttribute('max');
        }
    };

    pharmacyInput.addEventListener('input', () => {
        const pharmacyFilled = pharmacyInput.value.trim().length > 1;
        branchInput.disabled = !pharmacyFilled;
        if (!pharmacyFilled) {
            branchInput.value = '';
            branchIdInput.value = '';
            branchFarmInput.value = '';
            branchFarmDisplay.value = '';
            enableMedicationFields(false);
        }
    });

    const fetchBranch = debounce(() => {
        const pharmacy = pharmacyInput.value.trim();
        const branch = branchInput.value.trim();
        if (pharmacy.length < 2 || branch.length < 2) {
            branchIdInput.value = '';
            branchFarmInput.value = '';
            branchFarmDisplay.value = '';
            enableMedicationFields(false);
            return;
        }
        fetch(`/branch?pharmacy=${encodeURIComponent(pharmacy)}&branch=${encodeURIComponent(branch)}`)
            .then(res => res.json())
            .then(data => {
                branchIdInput.value = data.branchNum ?? '';
                branchFarmInput.value = data.branchFarm ?? '';
                branchFarmDisplay.value = data.branchFarm ?? '';
                enableMedicationFields(true);
                fetchStock();
            })
            .catch(() => {
                branchIdInput.value = '';
                branchFarmInput.value = '';
                branchFarmDisplay.value = '';
                enableMedicationFields(false);
            });
    }, 300);

    const fetchStock = debounce(() => {
        const name = medicationInput.value.trim();
        const branchNum = branchIdInput.value || '';
        const branchFarm = branchFarmInput.value || '';
        if (name.length < 3 || !branchNum || !branchFarm) {
            inStockInput.value = 0;
            quantityInput.value = 0;
            quantityInput.removeAttribute('max');
            btnAgregar.disabled = true;
            return;
        }
        fetch(`/stock?medication=${encodeURIComponent(name)}&branch_num=${encodeURIComponent(branchNum)}&branch_farm=${encodeURIComponent(branchFarm)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            const stock = data.stock ?? 0;
            inStockInput.value = stock;
            if (stock > 0) {
                quantityInput.value = 1;
                quantityInput.max = stock;
                btnAgregar.disabled = false;
            } else {
                quantityInput.value = 0;
                quantityInput.removeAttribute('max');
                btnAgregar.disabled = true;
            }
        })
        .catch(() => {
            inStockInput.value = 0;
            quantityInput.value = 0;
            quantityInput.removeAttribute('max');
            btnAgregar.disabled = true;
        });
    }, 300);

    branchInput.addEventListener('input', fetchBranch);
    medicationInput.addEventListener('input', fetchStock);

    quantityInput.addEventListener('input', (e) => {
        const val = parseInt(e.target.value);
        const max = parseInt(e.target.max) || Infinity;
        
        if (val < 1 || isNaN(val)) {
            e.target.value = 1;
        }
        else if (val > max) {
            e.target.value = max;
        }
    });

    quantityInput.addEventListener('keydown', (e) => {
        if (e.key === '-' || e.key === 'e' || e.key === 'E' || e.key === '+') {
            e.preventDefault();
        }
    });

    btnAgregar.addEventListener('click', () => {
        const medName = medicationInput.value.trim();
        const units = parseInt(quantityInput.value);
        const stock = parseInt(inStockInput.value);

        if (!medName || units <= 0 || units > stock) {
            alert('⚠️ Verifica el medicamento y las unidades');
            return;
        }

        const existingMeds = Array.from(prescriptionBody.querySelectorAll('tr td:nth-child(2)'))
            .map(td => td.textContent.trim())
            .filter(text => text !== ''); 
        
        if (existingMeds.includes(medName)) {
            alert(`⚠️ El medicamento "${medName}" ya fue agregado a la receta`);
            return;
        }

        if (prescriptionBody.querySelector('td[colspan]')) {
            prescriptionBody.innerHTML = '';
        }

        const rowCount = prescriptionBody.querySelectorAll('tr').length;
        const index = rowCount;
        
        const row = document.createElement('tr');
        row.setAttribute('data-index', index);
        row.innerHTML = `
            <td>${rowCount + 1}</td>
            <td>${medName}</td>
            <td>${units}</td>
            <td><button type="button" class="btn btn-danger btn-sm btn-remove">Eliminar</button></td>
        `;
        prescriptionBody.appendChild(row);

        const form = document.getElementById('prescriptionForm');
        const hiddenMed = document.createElement('input');
        hiddenMed.type = 'hidden';
        hiddenMed.name = `medication_${index}`;
        hiddenMed.value = medName;
        hiddenMed.classList.add('hidden-medication');
        hiddenMed.setAttribute('data-index', index);
        form.appendChild(hiddenMed);

        const hiddenUnits = document.createElement('input');
        hiddenUnits.type = 'hidden';
        hiddenUnits.name = `units_${index}`;
        hiddenUnits.value = units;
        hiddenUnits.classList.add('hidden-medication');
        hiddenUnits.setAttribute('data-index', index);
        form.appendChild(hiddenUnits);

        medicationsCountInput.value = rowCount + 1;

        updateGenerateButton();

        medicationInput.value = '';
        quantityInput.value = 0;
        inStockInput.value = 0;
        quantityInput.removeAttribute('max');
        btnAgregar.disabled = true;

        if (!hasPending) {
            hasPending = true;
        }

        row.querySelector('.btn-remove').addEventListener('click', () => {
            const rowIndex = row.getAttribute('data-index');
            
            document.querySelectorAll(`input.hidden-medication[data-index="${rowIndex}"]`).forEach(input => {
                input.remove();
            });

            row.remove();
            
            prescriptionBody.querySelectorAll('tr').forEach((tr, idx) => {
                tr.querySelector('td:first-child').textContent = idx + 1;
            });
            
            const remainingRows = prescriptionBody.querySelectorAll('tr').length;
            medicationsCountInput.value = remainingRows;
            
            if (remainingRows === 0) {
                prescriptionBody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No hay medicamentos agregados</td></tr>`;
                hasPending = false;
            }
            
            updateGenerateButton();
        });
    });

    prescriptionForm.addEventListener('submit', function(e) {
        hasPending = false; 
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('addEquipmentBtn');
    const container = document.getElementById('equipmentContainer');
    
    if (!addBtn || !container) {
        return; // Exit if elements don't exist
    }
    
    addBtn.addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'equipment-item mb-3';
        
        // Get the first select element to clone its options
        const firstSelect = container.querySelector('.equipment-select');
        if (!firstSelect) {
            return;
        }
        
        // Clone the options from the first select
        const optionsHTML = Array.from(firstSelect.options).map(option => {
            return `<option value="${option.value}">${option.text}</option>`;
        }).join('');
        
        newItem.innerHTML = `
            <div class="d-flex gap-2">
                <select name="equipment_id[]" class="form-select equipment-select" required>
                    ${optionsHTML}
                </select>
                <button type="button" class="btn btn-danger btn-sm remove-equipment">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        
        // Add remove functionality
        newItem.querySelector('.remove-equipment').addEventListener('click', function() {
            newItem.remove();
        });
    });
    
    // Remove equipment functionality for dynamically added items
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-equipment')) {
            e.target.closest('.equipment-item').remove();
        }
    });
});


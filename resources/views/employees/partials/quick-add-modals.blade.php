{{-- Quick Add Modals for Employee Form --}}
{{-- This partial contains modals for quickly adding related entities --}}

{{-- Quick Add Modal --}}
<div id="quickAddModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                            Quick Add
                        </h3>
                        <div class="mt-2">
                            <form id="quickAddForm" data-type="">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="quickAddName" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" id="quickAddName" name="name" required
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div id="additionalFields">
                                        {{-- Additional fields will be added dynamically based on the type --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="submitQuickAdd()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Add
                </button>
                <button type="button" onclick="closeQuickAdd()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Quick Add Modal Functions
function openQuickAdd(type) {
    const modal = document.getElementById('quickAddModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('quickAddForm');

    // Reset form
    form.reset();
    form.setAttribute('data-type', type);

    // Set title based on type
    const titles = {
        'company': 'Quick Add Company',
        'department': 'Quick Add Department',
        'position': 'Quick Add Position',
        'job_grade': 'Quick Add Job Grade',
        'branch': 'Quick Add Branch',
        'cost_center': 'Quick Add Cost Center',
        'work_schedule': 'Quick Add Work Schedule',
        'employment_status': 'Quick Add Employment Status'
    };

    title.textContent = titles[type] || 'Quick Add';
    modal.classList.remove('hidden');
}

function closeQuickAdd() {
    const modal = document.getElementById('quickAddModal');
    modal.classList.add('hidden');
}

function submitQuickAdd() {
    const form = document.getElementById('quickAddForm');
    const type = form.getAttribute('data-type');
    const name = document.getElementById('quickAddName').value;

    if (!name.trim()) {
        alert('Please enter a name');
        return;
    }

    // For now, just close the modal and show a message
    // In a full implementation, this would make an AJAX request to create the entity
    alert('Quick add functionality coming soon! For now, please use the full form to add new ' + type.replace('_', ' ') + '.');
    closeQuickAdd();
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('quickAddModal');
    if (e.target === modal) {
        closeQuickAdd();
    }
});
</script>
<!-- Confirm Modal Component -->
<div id="confirm-modal-container">
    <div id="confirm-modal-backdrop" class="fixed inset-0 z-50 bg-black/50 hidden" onclick="closeConfirmModal()"></div>
    <div id="confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="p-6 pb-0">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 id="confirm-modal-title" class="text-lg font-semibold text-gray-900">Confirm Action</h3>
                        <p id="confirm-modal-message" class="text-sm text-gray-500 mt-1">Are you sure you want to proceed?</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-6 flex items-center justify-end gap-3">
                <button type="button" onclick="closeConfirmModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="button" id="confirm-modal-confirm-btn"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let confirmCallback = null;

    function openConfirmModal(options) {
        document.getElementById('confirm-modal-title').textContent = options.title || 'Confirm Action';
        document.getElementById('confirm-modal-message').textContent = options.message || 'Are you sure you want to proceed?';
        document.getElementById('confirm-modal-confirm-btn').textContent = options.confirmText || 'Delete';
        confirmCallback = options.onConfirm;

        document.getElementById('confirm-modal-backdrop').classList.remove('hidden');
        document.getElementById('confirm-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeConfirmModal() {
        document.getElementById('confirm-modal-backdrop').classList.add('hidden');
        document.getElementById('confirm-modal').classList.add('hidden');
        document.body.style.overflow = '';
        confirmCallback = null;
    }

    document.getElementById('confirm-modal-confirm-btn').addEventListener('click', function() {
        if (confirmCallback) {
            confirmCallback();
        }
        closeConfirmModal();
    });
</script>
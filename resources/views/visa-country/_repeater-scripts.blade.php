<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('visaTypesWrapper');
        const template = document.getElementById('visaTypeTemplate');
        const addVisaTypeBtn = document.getElementById('addVisaTypeBtn');

        function reindexVisaTypes() {
            wrapper.querySelectorAll('.visa-type-block').forEach(function(block, i) {
                block.querySelectorAll('[name]').forEach(function(input) {
                    input.name = input.name.replace(/visa_types\[\d+\]|visa_types\[__INDEX__\]/,
                        'visa_types[' + i + ']');
                });
            });
        }

        if (addVisaTypeBtn) {
            addVisaTypeBtn.addEventListener('click', function() {
                const nextIndex = wrapper.querySelectorAll('.visa-type-block').length;
                const html = template.innerHTML.replaceAll('__INDEX__', nextIndex);
                const temp = document.createElement('div');
                temp.innerHTML = html.trim();
                wrapper.appendChild(temp.firstElementChild);
                reindexVisaTypes();
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-visa-type-btn')) {
                const blocks = wrapper.querySelectorAll('.visa-type-block');
                if (blocks.length <= 1) {
                    alert('At least one visa type is required.');
                    return;
                }
                e.target.closest('.visa-type-block').remove();
                reindexVisaTypes();
            }

            // Add requirement row
            if (e.target.closest('.add-requirement-btn')) {
                const block = e.target.closest('.visa-type-block');
                const reqWrapper = block.querySelector('.requirements-wrapper');
                const firstInput = reqWrapper.querySelector('input[name*="requirements"]');
                const name = firstInput ? firstInput.name : '';

                const row = document.createElement('div');
                row.className = 'input-group mb-2 requirement-row';
                row.innerHTML = `
                <input type="text" name="${name}" class="form-control" value="">
                <button type="button" class="btn btn-outline-danger remove-requirement-btn">&times;</button>
            `;
                reqWrapper.appendChild(row);
            }

            // Remove requirement row
            if (e.target.closest('.remove-requirement-btn')) {
                const row = e.target.closest('.requirement-row');
                const reqWrapper = row.parentElement;
                if (reqWrapper.querySelectorAll('.requirement-row').length <= 1) {
                    row.querySelector('input').value = '';
                    return;
                }
                row.remove();
            }
        });
    });
</script>

@push('js')
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush

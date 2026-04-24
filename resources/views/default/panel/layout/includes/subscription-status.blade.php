@if ($app_is_not_demo)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route('dashboard.user.check.payment') }}')
            .then(async response => {
                const contentType = response.headers.get('content-type') || '';

                if (!response.ok || !contentType.includes('application/json')) {
                    return null;
                }

                return response.json();
            })
            .catch(() => null);
    });
</script>
@endif

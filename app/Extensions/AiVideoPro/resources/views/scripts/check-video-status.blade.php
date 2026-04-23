<script>
	function checkVideoStatus() {
		fetch('{!! route('dashboard.user.ai-video-pro.check', ['ids' => $inProgress]) !!}')
			.then(response => response.json())
			.then(data => {
				for (const [id, item] of Object.entries(data.data)) {
					let videoElement = document.getElementById(item.divId);
					if (videoElement) {
						videoElement.innerHTML = item.html;
					}
				}
			})
			.catch(error => console.error('Error:', error));
	}

	document.addEventListener('DOMContentLoaded', function() {
		setInterval(checkVideoStatus, 5000);
	});
</script>

<script>
	function dropHandler(ev, id) {
		ev.preventDefault();
		$('#' + id)[0].files = ev.dataTransfer.files;
		if (typeof resizeImage === 'function') {
			resizeImage();
		}
		const fileName = ev.dataTransfer.files.length > 1
			? ev.dataTransfer.files.length + ' files selected'
			: ev.dataTransfer.files[0].name;
		$('#' + id).closest('label').find(".file-name").text(fileName);
	}

	function dragOverHandler(ev) {
		ev.preventDefault();
	}

	function handleFileSelect(id) {
		const files = $('#' + id)[0].files;
		const fileName = files.length > 1
			? files.length + ' files selected'
			: files[0].name;
		$('#' + id).closest('label').find(".file-name").text(fileName);
	}
</script>

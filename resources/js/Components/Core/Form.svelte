<script>
	import { setContext } from "svelte";

	let {
		children,
		class: className,
		endpoint = '/',
		form,
		method = 'post',
		onsubmit,
		onSuccess,
		onFinish,
		onError,
		oncancel,
		submitText = 'Save',
		...restProps
	} = $props()

	function handleSubmit(e) {
		if (onsubmit) {
			onsubmit(e)
		} else {
			e.preventDefault()
			if ($form && typeof $form[method] === 'function') {
				console.log('Form.handleSubmit', $form)
				$form[ method ]( endpoint, { onSuccess, onFinish, onError })
			} else {
				console.error(`Form method ${method} is not a function`)
			}
		}
	}

	function setData(key, value) {
		$form[key] = value
		console.log('Form.setData():', key, value, $form)
	}
	
	function clearData(key) {
		$form[key] = undefined
		console.log('Form.clearData():', key, $form)
	}

	setContext("form", { form, setData, clearData, method, endpoint });

</script>







<form class={className} onsubmit={handleSubmit} {...restProps}>
	{@render children?.()}
</form>
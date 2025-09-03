<script>
	import { setContext } from "svelte";
	import { page, router } from '@inertiajs/svelte'

	let {
		children,
		class: className,
		endpoint = '/',
		form,
		method = 'post',
		reloadPageProps,
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
				$form[ method ]( endpoint, {
					onSuccess: (res) => {
						onSuccess?.(res)
						console.log('Form.handleSubmit.onSuccess()', res)
						if (reloadPageProps) {
							router.visit( $page.url, {
								only: reloadPageProps,
							})
						}
					},
					onFinish,
					onError
				})
			} else {
				console.error(`Form method ${method} is not a function`)
			}
		}
	}

	function setData(key, value) {
		$form[key] = value
	}
	
	function clearData(key) {
		$form[key] = undefined
	}

	setContext("form", { form, setData, clearData, method, endpoint });

</script>







<form class={className} onsubmit={handleSubmit} {...restProps}>
	{@render children?.()}
</form>
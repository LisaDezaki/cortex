<script>
	import { setContext } from "svelte";
	import { page, useForm } from "@inertiajs/svelte";

	let {
		children,
		class: className,
		endpoint = '/',
		initialData = {},
		method = 'post',
		onsubmit,
		oncancel,
		submitText = 'Save',
		...restProps
	} = $props()

	const user = $page.props.auth.user

	const form = useForm(initialData);

	setContext("form", { form, endpoint, method });

	function handleSubmit(e) {
		if (onsubmit) {
			onsubmit(e)
		} else {
			e.preventDefault()
			// $form[method](endpoint)
		}
	}
</script>

<form class={className} onsubmit={handleSubmit} {...restProps}>

	{@render children?.()}

</form>
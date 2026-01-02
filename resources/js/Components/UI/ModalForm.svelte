<script>
	import { modalActions } from '@/stores/modalStore';

	import { Flex, Form, Grid } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Modal  from '@/Components/UI/Modal.svelte'

	let {
		children,
		form,
		size,
		title,
		submitProps,
		...restProps
	} = $props()

	let updatedSubmitProps = $state({
		style: 'hard',
		theme: 'accent',
		text: 'Submit',
		...submitProps
	})

</script>



<Modal title={title} maxWidth={size}>
	<Form class="relative"
		enctype="multipart/form-data"
		form={form}
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
		onFinish={modalActions.close}
	{...restProps}>

		{@render children?.()}

		<Flex align="center" justify="between" gap={1.5} class="flex-0 p-lg">
			<Button style="plain" theme="neutral"
				type="button"
				text="Cancel"
				onclick={modalActions.close}
			/>
			<Button
				type="submit"
				loading={$form.processing}
				disabled={$form.processing}
				{...updatedSubmitProps}
			/>
		</Flex>
	</Form>
</Modal>
<script>
	import { modalActions } from '@/stores/modalStore';

	import { Box, Flex, Form, Grid } from '@/Components/Core'
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
	<Form class="relative flex flex-col max-h-full overflow-hidden"
		enctype="multipart/form-data"
		form={form}
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
		onFinish={modalActions.close}
	{...restProps}>
		<Box class="content flex-1 max-h-[75vh] overflow-y-auto">
			{@render children?.()}
		</Box>

		<Flex justify="between" class="flex-none p-2">
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
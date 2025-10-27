<script>
	import { modalActions } from '@/stores/modalStore';

	import { Form, Grid } from '@/Components/Core'
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
		label: 'Submit',
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

		<Grid cols={2} gap={0} class="flex-0 min-h-12">
			<Button style="hard" theme="neutral"
				class="rounded-none grow"
				type="button"
				label="Cancel"
				onclick={modalActions.close}
			/>
			<Button
				class="rounded-none grow"
				type="submit"
				loading={$form.processing}
				disabled={$form.processing}
				{...updatedSubmitProps}
			/>
		</Grid>
	</Form>
</Modal>
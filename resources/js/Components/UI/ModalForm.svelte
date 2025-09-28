<script>
	import { modalActions } from '@/stores/modalStore';

	import { Flex, Form } from '@/Components/Core'
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
	<Form
		enctype="multipart/form-data"
		form={form}
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
		onFinish={modalActions.close}
	{...restProps}>

		{@render children?.()}

		<Flex gap={0} class="flex-0 min-h-12">
			<Button style="hard" theme="neutral"
				class="rounded-none grow"
				type="button"
				label="Cancel"
				onclick={modalActions.close}
			/>
			<Button
				class="rounded-none grow"
				type="submit"
				{...updatedSubmitProps}
			/>
		</Flex>
	</Form>
</Modal>
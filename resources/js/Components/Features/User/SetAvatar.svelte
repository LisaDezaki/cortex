<script>

	import { page, useForm } from '@inertiajs/svelte';
	import { route } from 'momentum-trail';

	import Avatar    from '@/Components/UI/Avatar.svelte';
	import Button    from '@/Components/UI/Button.svelte';
	import Heading   from '@/Components/UI/Heading.svelte';
	import Modal     from '@/Components/UI/Modal.svelte';
	import Thumbnail from '@/Components/UI/Thumbnail.svelte';

	const user = $page.props.auth.user.data
	const avatarForm = useForm({});

	let {
		id,
		class: className,
		disabled = false,
		src,
		...restProps
	} = $props()

	let input = null;
	let uploadingImage = $state(false)

	//	Handle the file change event
	async function handleFileChange(e) {
		const selectedFile = e.target.files?.[0];
		if (!selectedFile) return;
		$avatarForm.file = selectedFile;
		$avatarForm = { ...$avatarForm,
			blob: URL.createObjectURL(selectedFile),
		}
		await axios.post(
			route('upload.temp'),
			$avatarForm,
			{ headers: { 'Content-Type': 'multipart/form-data' } }
		).then(response => {
			$avatarForm = { ...$avatarForm,
				...response.data.file
			}
		}).catch(error => {
			console.error('Error:', error.response); // Check full error details
		});
	}

	async function submit(e) {
		await axios.patch(
			route('user.avatar.update'),
			$avatarForm,
		).then(response => {
			// console.log(response);
			if (response.data.success) {
				closeModal()
			}
			if (response.redirect) {
				window.location.href = response.redirect;
			}
		}).catch(error => {
			console.error('Error:', error.response); // Check full error details
		});
	}

	// function handleReplaceClick() {
	// 	input?.click();
	// }

	// function handleRemoveClick() {
	// 	previewUrl = null;
	// 	if (input) {
	// 		input.value = null;
	// 		value = null;
	// 	}
	// }

	function uploadImage() {
		uploadingImage = true
	}

	function closeModal() {
		uploadingImage = false
	}

	// onDestroy(() => {
	// 	if (previewUrl) {
	// 		URL.revokeObjectURL(previewUrl);
	// 	}
	// });

</script>

<button type="button" onclick={uploadImage}>
	<label for={id} class:disabled>
		<Avatar src={user?.avatar?.url} class="cursor-pointer w-48" />
		<input
			{...restProps}
			type="file"
			id={id}
			accept='image/*'
			class="invisible hidden"
			onchange={handleFileChange}
			bind:this={input}
			disabled={disabled}
		/>
	</label>
</button>

<Modal show={uploadingImage} onclose={closeModal} class="flex items-start p-6">

	<label for={id} class=" {className}" class:disabled>
		<Thumbnail
			src={$avatarForm.path || $avatarForm.blob || src}
			loading={$avatarForm.loading}
			class="aspect-square mr-6 rounded-full w-32 flex-shrink-0 transition-all {$avatarForm.loading ? 'blur-sm' : 'blur-none'}"
		/>
	</label>

	<div>
		<Heading is="h4" as="h5"
			heading="Set Avatar"
			subheading="Choose an avatar to represent you."
		/>
		<div class="mt-6">
			<Button style="hard" theme="neutral"
				onclick={closeModal}
				label="Cancel"
			/>
			<Button style="hard" theme="accent"
				onclick={submit}
				label="Confirm"
				disabled={$avatarForm.loading}
				loading={$avatarForm.loading}
			/>
		</div>
	</div>
</Modal>

{#if $page.props.flash?.success}
    <div class="alert">{$page.props.flash.success}</div>
{/if}

{#if $page.props.flash?.error}
    <div class="alert">{$page.props.flash.error}</div>
{/if}

{#if $page.props.flash?.message}
    <div class="alert">{$page.props.flash.message}</div>
{/if}





<style lang="postcss">

	.form-upload {
		@apply relative flex flex-col items-center justify-center min-h-20;
		@apply border rounded-lg cursor-pointer overflow-hidden;
		&.disabled {
			@apply cursor-not-allowed;
			background-color: var(--bg-disabled);
			border-color: var(--border-disabled);
			color: var(--text-disabled);
		}
		&:hover {
			.image-controls {
				opacity: 1;
			}
		}

		.preview-image {
			@apply block h-auto object-cover rounded w-full;
		}

		/* .image-controls {
			@apply absolute top-0 left-0 h-full w-full;
			@apply backdrop-blur-sm transition-all;
			opacity: 0;

			.image-replace {
				@apply absolute top-0 left-0 h-full w-full text-white;
			}

			:global(.image-remove) {
				@apply absolute top-1 right-1 h-8 w-8 z-10;
			}
		} */
	}

</style>
<script>

    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, ReorderableList, Stack } from '@/Components/Core'

	import Button          from '@/Components/UI/Button.svelte'
	import DragHandle      from '@/Components/UI/DragHandle.svelte'
	import Field           from '@/Components/UI/Field.svelte'
	import Icon            from '@/Components/UI/Icon.svelte'
	import Input           from '@/Components/UI/Input.svelte'
	import Label           from '@/Components/UI/Form/Label.svelte'

	//  Props
    let {
		class: className,
		field,
        oncancel = () => {}
    } = $props()

	//  State & Reactivity
	let blankData = {
		id: null,
		type: 'text',
		name: '',
		default: '',
		description: '',
		label: '',
		filetype: 'image',
		placeholder: '',
		required: false,
		options: [ "", "" ],
		min: '',
		max: '',
		rows: ''
	}

	let multiline = $state(false)
	let inputType = $state('text')

	//  The form object needs to be reactive to changes in the data prop
	let form = useForm(field || blankData)
	$effect(() => {
		for (const [key, value] of Object.entries(field || blankData)) {
			$form[key] = value
		}
	})

	

	//  Methods
    
	function setType(type) {
		inputType = type
	}

	function setData() {
		if (field == null) { resetData(); return }
		for (const [key, value] of Object.entries(field)) {
			$form[key] = value
		}
	}

	function resetData() {
		let freshData = {
			id: null,
			...blankData
		}
		for (const [key, value] of Object.entries(freshData)) {
			$form[key] = value
		}
	}

	function addOption() {
		$form.options = [
			...$form.options,
			""
		]
	}
	function removeOption(index) {
		$form.options = $form.options.filter((option,i) => i !== index)
	}

	function toggleMultiline() {
		multiline = !multiline
	}

	function submit(e) {
		e.preventDefault()

		console.log('submitting')

		//  Map prop data to form data
		if (field) {
			for (const [key, value] of Object.entries(field)) {
				$form[key] = value
			}
		}

		//  Map options to form data if applicable
		// $form.options = $form.type == 'select'
		// 	? $form.options
		// 	: null

		//  Post data to server and handle response
		// if (data.id) {
		// 	$form.post( route('customfields.update', { field: data.id }, {
		// 		onSuccess: () => {
		// 			oncancel()
		// 		}
		// 	}) )
		// } else {
		// 	$form.post( route('customfields.store'), {
		// 		onSuccess: (a,b) => {
		// 			oncancel()
		// 		}
		// 	} )
		// }
	}

</script>

<Form
	class="relative flex flex-col h-full {className}"
	onsubmit={submit}
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<Flex class="flex-1 overflow-hidden">

		<Stack class="border-r py-4 w-40">
			{#each [
				{ value: 'text',   label: 'Text',    icon: 'TextAa' },
				{ value: 'number', label: 'Number',  icon: 'Hash' },
				{ value: 'link',   label: 'Link',    icon: 'Link' },
				{ value: 'switch', label: 'Switch',  icon: 'ToggleRight' },
				{ value: 'select', label: 'Options', icon: 'RowsPlusBottom' },
				{ value: 'entity', label: 'Entity',  icon: 'Table' },
				{ value: 'upload', label: 'File',    icon: 'File' }
			] as type}
				<button type="button"
					class="flex gap-2 px-2 py-1 w-full {type.value == inputType ? 'text-emerald-500' : ''} hover:bg-slate-500/10"
					onclick={() => setType(type.value)}
				>
					<Icon name={type.icon} size="md" weight="regular" />
					<span>{type.label}</span>
				</button>
			{/each}

		</Stack>

		<Stack gap={1} class="px-6 py-3 h-full min-h-[420px] overflow-y-auto w-96">

			<!-- Name -->
	
			<Field
				type="text"
				required
				id="name"
				label="Name"
				placeholder="Custom field name"
				bind:value={$form.label}
				errors={$form.errors.label}
				autofocus
			/>

			<!-- Placeholder -->
	
			{#if ['text', 'textarea', 'link', 'number', 'select'].includes(inputType)}
				<Field
					type="text"
					id="placeholder"
					errors={$form.errors.placeholder}
					label="Placeholder"
					placeholder={inputType == 'number' ? "0" : "Empty"}
					bind:value={$form.placeholder}
				/>
			{/if}

			<!-- Description -->
	
			{#if ['text', 'textarea', 'number', 'select', 'upload', 'entity'].includes(inputType)}
				<Field
					type="text"
					id="description"
					label="Description"
					placeholder="Describe the field..."
					bind:value={$form.description}
					errors={$form.errors.description}
				/>
			{/if}

			<!-- Checkbox label -->
	
			{#if ['checkbox', 'radio', 'switch'].includes(inputType)}
				<Field
					required
					type="text"
					id="label"
					errors={$form.errors.label}
					label="Descriptive label"
					placeholder="Write a descriptive label"
					bind:value={$form.label}
				/>
			{/if}

			<!-- Options -->
	
			{#if inputType == 'select'}

				<!-- <pre>{JSON.stringify($form.options)}</pre> -->

				<div>
					<Field
						label="Field options"
						description="There must be at least two options available."
					/>
					<ReorderableList bind:items={$form.options}>
						{#snippet itemTemplate(item, index)}
							<li class="flex items-center gap-1 w-full mb-1">
								<DragHandle />
								<Input
									type="text"
									id="option_{index+1}"
									class="flex-grow"
									placeholder="Option {index+1}"
									bind:value={$form.options[index]}
									errors={$form.errors.options?.[index]}
								/>
								{#if $form.options.length > 2}
									<Button style="plain" theme="danger"
										icon="X" iconSize="md"
										onclick={() => removeOption(i)}
									/>
								{/if}
							</li>
						{/snippet}
					</ReorderableList>
					<div class="flex justify-center">
						<Button style="soft" theme="accent" class="h-10 mx-auto w-12" type="button" icon="Plus" onclick={addOption} />
					</div>
				</div>
			{/if}

			<!-- Min. & Max. -->
	
			{#if ['number', 'slider'].includes(inputType)}
				<div class="flex items-center gap-2">
					<Field
						type="number"
						id="min"
						label="Minimum"
						placeholder={0}
						bind:value={$form.min}
						errors={$form.errors.min}
					/>
	
					<Field
						type="number"
						id="default"
						label="Default"
						placeholder={1}
						bind:value={$form.default}
						errors={$form.errors.default}
					/>
	
					<Field
						type="number"
						id="max"
						label="Maximum"
						placeholder={255}
						bind:value={$form.max}
						errors={$form.errors.max}
					/>
				</div>
			{/if}

			<!-- Entity Type -->
	
			{#if ['entity'].includes(inputType)}
				<Field
					type="select"
					id="entitytype"
					label="Entity Type"
					placeholder="Select an entity type"
					bind:value={$form.filetype}
					errors={$form.errors.filetype}
					options={[
						{ icon: 'User',           label: 'Character', value: 'character' },
						{ icon: 'FlagBannerFold', label: 'Faction', value: 'faction' },
						{ icon: 'MapPinArea',     label: 'Location', value: 'location' }
					]}
				/>
			{/if}

			<!-- File Type -->
	
			{#if ['upload'].includes(inputType)}
				<Field
					type="select"
					id="filetype"
					label="File Type"
					bind:value={$form.filetype}
					errors={$form.errors.filetype}
					options={[
						{ icon: 'FileAudio', label: 'Audio',    value: 'audio'    },
						{ icon: 'FileText',  label: 'Document', value: 'document' },
						{ icon: 'FileImage', label: 'Image',    value: 'image'    },
						{ icon: 'FileVideo', label: 'Video',    value: 'video'    }
					]}
				/>
			{/if}

			<!-- Multiline -->
	
			<!-- {#if ['text', 'textarea'].includes($form.type)}
				<div class="grid grid-cols-2 items-center gap-2">
					<Field
						type="switch"
						id="multiline"
						class="pt-6"
						description="Set this to 'true' if you want the field to be taller to allow for more text."
						label="Multiline"
						bind:checked={multiline}
						onCheckedChange={toggleMultiline}
					/>
					{#if multiline}
						<Field
							type="number"
							id="rows"
							description="The number of rows that this text area will have."
							errors={$form.errors.rows}
							label="Number of rows"
							placeholder={3}
							bind:value={$form.rows}
							min={2}
							max={12}
						/>
					{/if}
				</div>
			{/if} -->

			<!-- Required -->
		
			<!-- {#if $form.type !== 'switch'}
				<Field
					type="switch"
					id="required"
					class="pt-8"
					description="Set this to 'true' if completing this field is necessary for the user to submit the form."
					errors={$form.errors.required}
					label="Required"
					bind:checked={$form.required}
				/>
			{/if} -->
			<!-- <div class="mt-auto flex-shrink-0">
				<div class="flex items-center justify-center gap-3 pt-2">
					<Button style="hard" theme="neutral"
						type="button"
						label="Cancel"
						onclick={oncancel}
					/>
					<Button style="hard" theme="accent"
						type="submit"
						label="Save Custom Field"
					/>
				</div>
			</div> -->
		</Stack>
		
	</Flex>

	<Flex gap={0} class="border-t flex-0 min-h-12">
		<Button style="hard" theme="neutral" class="border-none rounded-none px-4 w-1/2"
			type="button"
			icon="X"
			label="Cancel"
			onclick={oncancel}
		/>
		<Button style="hard" theme="accent" class="border-none rounded-none px-4 w-1/2"
			type="submit"
			icon="Check"
			label="Save"
		/>
	</Flex>

</Form>
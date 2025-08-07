<script>

	//  Imports
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'
	import Icon from '@/Components/Icon.svelte'

	//  Props
    let {
		class: className,
		data,
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
		placeholder: '',
		required: false,
		options: [{label:'',value:''},{label:'',value:''}],
		min: '',
		max: '',
		rows: ''
	}

	let multiline = $state(false)

	//  The form object needs to be reactive to changes in the data prop
	const form = useForm(data || blankData)
	$effect(() => {
		for (const [key, value] of Object.entries(data || blankData)) {
			$form[key] = value
		}
	})

	

	//  Methods
    

	function setData() {
		if (data == null) { resetData(); return }
		for (const [key, value] of Object.entries(data)) {
			$form[key] = value
		}
	}

	function resetData() {
		let freshData = {
			id: null,
			fieldable_type: $form.fieldable_type,
			...blankData
		}
		for (const [key, value] of Object.entries(freshData)) {
			$form[key] = value
		}
	}

	function addOption() {
		$form.options = [
			...$form.options,
			{ label: '', value: '' }
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

		//  Map prop data to form data
		for (const [key, value] of Object.entries(data)) {
			$form[key] = value
		}

		//  Map options to form data if applicable
		$form.options = $form.type == 'select'
			? $form.options.map(o => o.label)
			: null

		//  Post data to server and handle response
		if (data.id) {
			$form.post( route('customfields.update', { field: data.id }, {
				onSuccess: () => {
					oncancel()
				}
			}) )
		} else {
			$form.post( route('customfields.store'), {
				onSuccess: (a,b) => {
					oncancel()
				}
			} )
		}
	}

</script>

<Form
	class="relative {className}"
	onsubmit={submit}
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<div class="flex space-y-3">

		<div class="flex flex-col items-start border-r py-4 w-32">
			{#each [
				{ value: 'text',   label: 'Text',    icon: 'TextAa' },
				{ value: 'number', label: 'Number',  icon: 'Hash' },
				{ value: 'link',   label: 'Link',    icon: 'Link' },
				{ value: 'switch', label: 'Switch',  icon: 'ToggleRight' },
				{ value: 'select', label: 'Options', icon: 'RowsPlusBottom' },
				{ value: 'entity', label: 'Entity',  icon: 'Table' },
				{ value: 'upload', label: 'File',    icon: 'ImageSquare' }
			] as type}
				<Button
					class={type.value == $form.type ? 'text-emerald-500' : ''}
					onclick={() => $form.type = type.value}
					icon={type.icon}
					iconSize={20}
					iconWeight="regular"
					label={type.label}
				/>
			{/each}
		</div>

		<div class="flex flex-col gap-3 p-6 min-h-[420px] w-full overflow-y-auto">

			<div class="flex items-center justify-end -mt-6 -mr-4">

				<h4 class="font-style-h6 text-slate-500 w-full">Custom {$form.type} field</h4>

				<Button
					class="text-rose-500"
					onclick={oncancel}
					icon='X'
					iconSize={24}
					iconWeight="regular"
				/>
			</div>

			<!-- <pre>{JSON.stringify(data, null, 2)}</pre> -->

			<!-- Name -->
	
			<Form.Field
				type="text"
				required
				id="name"
				description="Name your custom field. This will be shown to the user when they fill out the form."
				errors={$form.errors.name}
				label="Name"
				placeholder="Custom field name"
				bind:value={$form.name}
				autofocus
			/>

			<!-- Placeholder -->
	
			<!-- {#if ['text', 'textarea', 'link', 'number', 'select'].includes($form.type)}
				<Form.Field
					type={$form.type == 'number' ? "number" : "text"}
					id="placeholder"
					description="The placeholder text that will be shown in the field as an example to the user. This can be left empty."
					errors={$form.errors.placeholder}
					label="Placeholder"
					placeholder={$form.type == 'number' ? "0" : "Empty"}
					bind:value={$form.placeholder}
				/>
			{/if} -->

			<!-- Description -->
	
			{#if ['text', 'textarea', 'number', 'select', 'upload', 'entity'].includes($form.type)}
				<Form.Field
					type="text"
					id="description"
					description="A short description of the field's purpose, that will be shown as a tooltip if the user hovers on the 'help' icon, like you are now."
					errors={$form.errors.description}
					label="Field description"
					placeholder="Write a description of this field's purpose..."
					bind:value={$form.description}
				/>
			{/if}

			<!-- Checkbox label -->
	
			<!-- {#if ['checkbox', 'radio', 'switch'].includes($form.type)}
				<Form.Field
					required
					type="text"
					id="label"
					description="The label that will be shown next to the toggle switch."
					errors={$form.errors.label}
					label="Descriptive label"
					placeholder="Write a descriptive label"
					bind:value={$form.label}
				/>
			{/if} -->

			<!-- Options -->
	
			{#if $form.type == 'select'}
				<div>
					<Form.Label
						required
						value="Field options"
						description="The available options for this field. There must be at least two options."
					/>
					<ul>
						{#each $form.options as option, i}
							<li class="flex items-center w-full mb-1">
								<button class="flex items-center p-2 cursor-move">
									<Icon name="DotsSixVertical" size={24} />
								</button>
								<Form.Field
									type="text"
									id="option_{i+1}"
									class="flex-grow"
									errors={$form.errors.options}
									placeholder="Option {i+1}"
									bind:value={option.label}
								/>
								{#if $form.options.length > 2}
									<button class="flex items-center p-2 text-rose-500" type="button" onclick={() => removeOption(i)}>
										<Icon name="X" size={24} />
									</button>
								{/if}
							</li>
						{/each}
					</ul>
					<div class="flex justify-center">
						<Button secondary class="h-10 mx-auto w-12" type="button" icon="Plus" onclick={addOption} />
					</div>
				</div>
			{/if}

			<!-- Min. & Max. -->
	
			{#if ['number', 'slider'].includes($form.type)}
				<div class="flex items-center gap-2">
					<Form.Field
						type="number"
						id="min"
						description="The smallest value that this field can have."
						errors={$form.errors.min}
						label="Minimum value"
						placeholder={0}
						bind:value={$form.min}
					/>
	
					<Form.Field
						type="number"
						id="default"
						errors={$form.errors.default}
						label="Default value"
						placeholder={1}
						bind:value={$form.default}
					/>
	
					<Form.Field
						type="number"
						id="max"
						description="The largest value that this field can have."
						errors={$form.errors.max}
						label="Maximum value"
						placeholder={255}
						bind:value={$form.max}
					/>
				</div>
			{/if}

			<!-- Multiline -->
	
			<!-- {#if ['text', 'textarea'].includes($form.type)}
				<div class="grid grid-cols-2 items-center gap-2">
					<Form.Field
						type="switch"
						id="multiline"
						class="pt-6"
						description="Set this to 'true' if you want the field to be taller to allow for more text."
						label="Multiline"
						bind:checked={multiline}
						onCheckedChange={toggleMultiline}
					/>
					{#if multiline}
						<Form.Field
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
				<Form.Field
					type="switch"
					id="required"
					class="pt-8"
					description="Set this to 'true' if completing this field is necessary for the user to submit the form."
					errors={$form.errors.required}
					label="Required"
					bind:checked={$form.required}
				/>
			{/if} -->
			<div class="mt-auto flex-shrink-0">
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
			</div>
		</div>
		
	</div>


</Form>
<script>

	//	Imports

	import { page, useForm } from '@inertiajs/svelte'

    import UserLayout from '@/Layouts/UserLayout.svelte'
	import CustomFieldForm from './Partials/CustomFieldForm.svelte'
	import Article from '@/Components/Article.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Form from '@/Components/Form'

	//	Page Props

	let project = $page.props.active_project
	let custom_fields = $page.props.custom_fields

	//	State / Derived

	let fieldIndex     = $state(null)
	let filteredFields = $derived(custom_fields.filter(field => {
		return field.entity_type == $form.entity_type
	}))

	//	Form

	let blankData = {
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

	const form = useForm({
		id: null,
		entity_type: '',
		// type: '',
		...blankData
	})

	//	Logic

	function changeEntity(entity) {
		if ($form.entity_type === entity) {
			closePanel()
			$form.entity_type = ''
			return
		}
		closePanel()
		$form.entity_type = entity
	}

	function updateActiveField(index) {

		if (index === fieldIndex) {
			resetData()
			fieldIndex = null
		} else {
			setData(index)
			fieldIndex = index
		}

	}

	function setData(index) {
		if (index == -1) { resetData(); return }
		for (const [key, value] of Object.entries(custom_fields[index])) {
			$form[key] = value
		}
	}

	function resetData() {
		let freshData = {
			id: null,
			entity_type: $form.entity_type,
			...blankData
		}
		for (const [key, value] of Object.entries(freshData)) {
			$form[key] = value
		}
	}

	function closePanel() {
		resetData()
		fieldIndex = null
	}

</script>

<svelte:head>
    <title>{project?.name} Custom Fields</title>
</svelte:head>

<UserLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project", href: "/" },
			{ title: "Custom Fields" }
		]} />
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-6">

			<Article
				title="Custom Fields"
				subtitle="Custom Fields allow you to expand your project's data however you want by defining your own data fields with your own settings."
				bodyclass="px-6"
			>
				<div class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-1 mt-8">
					{#each [
						{ label: 'Characters', value: 'character', icon: 'UsersThree',    },
						{ label: 'Dialogue'  , value: 'dialogue',  icon: 'Chats',         },
						{ label: 'Events'    , value: 'event',     icon: 'CalendarDots',  },
						{ label: 'Factions'  , value: 'faction',   icon: 'FlagBannerFold' },
						{ label: 'Items'     , value: 'item',      icon: 'Backpack',      },
						{ label: 'Locations' , value: 'location',  icon: 'MapPinArea',    },
						{ label: 'Lore'      , value: 'lore',      icon: 'Books',         },
						{ label: 'Mechanics' , value: 'mechanic',  icon: 'Wrench',        },
						{ label: 'Quests'    , value: 'quest',     icon: 'Trophy',        },
						{ label: 'Scenes'    , value: 'scene',     icon: 'FilmSlate',     },
						{ label: 'Spells'    , value: 'spell',     icon: 'Pentagram',     },
						{ label: 'Wildlife'  , value: 'wildlife',  icon: 'Butterfly',     }
					] as entity}
						<Button
							primary={$form.entity_type == entity.value}
							secondary={$form.entity_type != entity.value}
							onclick={() => changeEntity(entity.value)}
							icon={entity.icon}
							iconSize={20}
							iconWeight="regular"
							label={entity.label}
						/>
					{/each}
				</div>
	
				{#if $form.entity_type}
	
					<div class="space-y-6 mt-6">
	
						<Form class="flex flex-col gap-3 rounded-lg">
	
							{#each filteredFields as field, i}
								<div class="flex gap-1 items-center">
									{#if fieldIndex == i}
										<Form.Field
											type={$form.type}
											id={$form.name}
											class="w-full border border-emerald-400 px-4 py-3 rounded-lg"
											layout="block"
											description={$form.description}
											label={$form.label || $form.name || 'Custom field'}
											placeholder={$form.placeholder}
											required={$form.required}
											min={$form.min}
											max={$form.max}
											rows={$form.rows}
											options={$form.options}
										/>
										<Button secondary class="h-10 w-10" icon="X" type="button" onclick={closePanel} />
									{:else}
										<Form.Field
											type={field.type}
											class="w-full border px-4 py-3 rounded-lg"
											layout="block"
											description={field.description}
											label={field.label || field.name}
											placeholder={field.placeholder}
											required={field.required}
											options={field.options}
										/>
										<Button secondary class="h-10 w-10" icon="Pen" type="button" onclick={() => updateActiveField(i)} />
									{/if}
								</div>
							{/each}
	
							{#if $form.entity_type != '' && filteredFields.length == 0}
								<div>There are no Custom Fields yet for <strong class="text-lg font-black tracking-tight">{$form.entity_type}</strong>.</div>
							{/if}
	
							{#if fieldIndex == -1}
								<div class="flex gap-1 items-end">
									<Form.Field
										type={$form.type}
										id={$form.name}
										class="w-full border border-emerald-400 px-4 py-3 rounded-lg"
										layout="block"
										label={$form.label || $form.name || 'Custom field'}
										description={$form.description}
										placeholder={$form.placeholder}
										required={$form.required}
										min={$form.min}
										max={$form.max}
										rows={$form.rows}
										options={$form.options}
									/>
									<Button secondary class="h-10 w-10" icon="X" type="button" onclick={closePanel} />
								</div>
							{:else}
								<Button primary icon="Plus" label="Create a new custom field" type="button" onclick={() => updateActiveField(-1)} class="mt-[26px]" />
							{/if}
	
						</Form>
			
					</div>
					
					{/if}
					
				</Article>
			</div>

			<div class="col-span-2">
				{#if fieldIndex !== null}
					<Article
						title="Create a Custom Field"
						subtitle="Define a new custom field for your project."
						bodyclass="px-6"
					>
						<CustomFieldForm bind:data={$form} oncancel={closePanel} />
					</Article>
				{/if}
			</div>

	</section>
    
</UserLayout>
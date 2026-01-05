<script>
	import { page } from '@inertiajs/svelte';

	import { Flex, Stack } from '@/Components/Core'
    import Article    	from '@/Components/UI/Article.svelte'
	import Navigation 	from '@/Components/UI/Navigation.svelte'
    import Main       	from '@/Components/UI/Main.svelte'
    import Page       	from '@/Components/UI/Page.svelte'
	import Snackbar		from '@/Components/UI/Snackbar.svelte'
	import Toast		from '@/Components/UI/Toast.svelte'
	import ProjectObject from '@/services/ProjectObject'


	/**
	 * Modal Management
	 * 
	 * 1. Import all modal components
	 * 2. Create a modal registry map
	 * 3. Initial state for active modal component and props
	 * 4. Subscribe to modal store changes
	 * 5. Derived computed value for the current modal component
	 */

	//	1. Import all modal components

	import { modalStore } from '@/stores/modalStore';

    import CreateEntityModal		from '@/Modals/CreateEntity.svelte'
	import CustomFieldModal			from '@/Modals/CustomField.svelte'
	import CustomFieldValueModal	from '@/Modals/CustomFieldValue.svelte'

	import DeleteEntityModal	from '@/Modals/DeleteEntity.svelte'
    import DeleteProjectModal	from '@/Modals/DeleteProject.svelte'
    import DeleteUserModal		from '@/Modals/DeleteUser.svelte'

	import LinkEntitiesModal	from '@/Modals/LinkEntities.svelte'
	
	import SelectOneModal 			 	 from '@/Modals/SelectOne.svelte'
	import SelectManyModal 		 		 from '@/Modals/SelectMany.svelte'
    import SetCharacterRelationshipModal from '@/Modals/SetCharacterRelationship.svelte'
    import SetLocationModal 			 from '@/Modals/SetLocation.svelte'
    import SetTagsModal 			 	 from '@/Modals/SetTags.svelte'
	import SetValueModal 			 	 from '@/Modals/SetValue.svelte'
    import UploadMediaModal 			 from '@/Modals/UploadMedia.svelte'
    import { Tooltip } from 'bits-ui'
	
	//	2. Create a modal registry map

    const modals = {
        createEntity: 		CreateEntityModal,
		customField:		CustomFieldModal,
		customFieldValue:	CustomFieldValueModal,
		deleteEntity:		DeleteEntityModal,
		deleteProject:		DeleteProjectModal,
		deleteUser:			DeleteUserModal,
		linkEntities:		LinkEntitiesModal,
		selectOne:			SelectOneModal,
		selectMany:			SelectManyModal,
		setCharacterRelationship: SetCharacterRelationshipModal,
		setLocation:		SetLocationModal,
		setTags:			SetTagsModal,
		setValue:			SetValueModal,
		uploadMedia:		UploadMediaModal
    };

	const CurrentModal = $derived(modals[$modalStore.activeModal])


	/**
	 * Page & Component Props
	 * 
	 */

	const activeProject = $page.props.activeProject?.data
	const active = $derived(activeProject ? new ProjectObject(activeProject) : null);

    let {
		article,
		noscroll,
		sidebar
	} = $props()

	let cx = {
		gap:	['gap-0', 'gap-1', 'gap-2', 'gap-3', 'gap-4', 'gap-8', 'gap-20'],
		width:	['w-0', 'w-4', 'w-8', 'w-12', 'w-16', 'w-20', 'w-24', 'w-28', 'w-32', 'w-36', 'w-40', 'w-44', 'w-48', 'w-52', 'w-56', 'w-60', 'w-64']
	}

</script>



<Tooltip.Provider>
	<Page>
		<Navigation {active} />
		<Main>
			<Article {noscroll}>
				{@render article?.()}
			</Article>
			{@render sidebar?.()}
		</Main>
		{#if $page.props.flash}
			<Stack class="overlay fixed bottom-4 left-1/2 translate-x-[-50%]">
				{#if $page.props.flash.success}
					<Snackbar theme="accent" icon="CheckCircle" text={$page.props.flash.success} />
				{:else if $page.props.flash.error}
					<Snackbar theme="danger" icon="Warning" text={$page.props.flash.error} />
				{:else if $page.props.flash.message}
					<Snackbar theme="neutral" text={$page.props.flash.message} />
				{/if}
			</Stack>
		{/if}
	</Page>
	{#if CurrentModal}
		<CurrentModal {...$modalStore.modalProps} />
	{/if}
</Tooltip.Provider>
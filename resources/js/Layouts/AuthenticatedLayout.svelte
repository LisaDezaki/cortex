<script>
	import { page } from '@inertiajs/svelte';

	import { Flex, Stack } from '@/Components/Core'
    import Article    	from '@/Components/UI/Article.svelte'
	import Navigation 	from '@/Components/UI/Navigation.svelte'
    import Main       	from '@/Components/UI/Main.svelte'
    import Page       	from '@/Components/UI/Page.svelte'
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

	import CharacterFactionsModal		from '@/Modals/CharacterFactions.svelte'
	import CharacterRelationshipsModal	from '@/Modals/CharacterRelationships.svelte'

    import CreateCharacterModal  from '@/Modals/CreateCharacter.svelte';
    import CreateCollectionModal from '@/Modals/CreateCollection.svelte';
    import CreateFactionModal 	 from '@/Modals/CreateFaction.svelte';
    import CreateLocationModal 	 from '@/Modals/CreateLocation.svelte';
    import CreateProjectModal  	 from '@/Modals/CreateProject.svelte';

	import DeleteCharacterModal  from '@/Modals/DeleteCharacter.svelte';
    import DeleteCollectionModal from '@/Modals/DeleteCollection.svelte';
    import DeleteFactionModal 	 from '@/Modals/DeleteFaction.svelte';
    import DeleteLocationModal 	 from '@/Modals/DeleteLocation.svelte';
    import DeleteProjectModal 	 from '@/Modals/DeleteProject.svelte';
    import DeleteUserModal 	 from '@/Modals/DeleteUser.svelte';
	
    import RenameCharacterModal  from '@/Modals/RenameCharacter.svelte';
    import RenameCollectionModal from '@/Modals/RenameCollection.svelte';
    import RenameFactionModal 	 from '@/Modals/RenameFaction.svelte';
    import RenameLocationModal 	 from '@/Modals/RenameLocation.svelte';
    import RenameProjectModal 	 from '@/Modals/RenameProject.svelte';

	import CustomFieldModal      from '@/Modals/CustomField.svelte';
	
    import SelectLocationModal 			 from '@/Modals/SelectLocation.svelte';
    import SetCharacterRelationshipModal from '@/Modals/SetCharacterRelationship.svelte';
    import SetLocationModal 			 from '@/Modals/SetLocation.svelte';
    import SetTagsModal 			 	 from '@/Modals/SetTags.svelte';
    import UploadMediaModal 			 from '@/Modals/UploadMedia.svelte';
	
	//	2. Create a modal registry map

    const modals = {

		characterFactions:	CharacterFactionsModal,
		characterRelationships: CharacterRelationshipsModal,

        createCharacter: 	CreateCharacterModal,
        createCollection: 	CreateCollectionModal,
        createFaction: 		CreateFactionModal,
        createLocation: 	CreateLocationModal,
		createProject:		CreateProjectModal,

		deleteCharacter: 	DeleteCharacterModal,
		deleteCollection:	DeleteCollectionModal,
		deleteFaction:		DeleteFactionModal,
		deleteLocation:		DeleteLocationModal,
		deleteProject:		DeleteProjectModal,
		deleteUser:			DeleteUserModal,

		renameCharacter:	RenameCharacterModal,
		renameCollection:	RenameCollectionModal,
		renameFaction:		RenameFactionModal,
		renameLocation:		RenameLocationModal,
		renameProject:		RenameProjectModal,

		customField:				CustomFieldModal,

		selectLocation:				SelectLocationModal,
		setCharacterRelationship:	SetCharacterRelationshipModal,
		setLocation:				SetLocationModal,
		setTags:					SetTagsModal,
		uploadMedia:				UploadMediaModal
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

</script>



<Page>
	<Navigation {active} />
	<Main>
		<Article {noscroll}>
			{#if $page.props.flash}
				<Toast {...$page.props.flash} />
			{/if}
			{@render article?.()}
		</Article>
		{@render sidebar?.()}
	</Main>
</Page>

{#if CurrentModal}
	<CurrentModal {...$modalStore.modalProps} />
{/if}
/**
 * @typedef {import('@inertiajs/svelte')} router
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/CharacterList')} CharacterList
 * @typedef {import('@/services/FactionList')} FactionList
 * @typedef {import('@/services/LocationList')} LocationList
 */

import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import CharacterList from '@/services/CharacterList'
import FactionList from '@/services/FactionList'
import LocationList from '@/services/LocationList'

/**
 * Class: Project Object
 * Represents a single Project record
 * @class
 * @classdesc A Project entity as fetched from the database
 * with other functionality to make data handling easier
 */

export default class ProjectObject {

	/**
	 * Creates a new ProjectObject instance
	 * @param {Object} projectData
	 * @throws {TypeError} if projectData is not provided
	 */
	constructor(projectData) {
		Object.assign(this, projectData, {

			/**
			 * Laravel's Model location as printed by Project::class
			 * @type {string}
			 */
			laravelClass:	"App\Models\Project",

			/**
			 * A CharacterList instance
			 * @type {CharacterList}
			 * @readonly
			 */
			characters: projectData.characters ? new CharacterList(projectData.characters)	: null,
			
			/**
			 * A FactionList instance
			 * @type {FactionList}
			 * @readonly
			 */
			factions:   projectData.factions   ? new FactionList(projectData.factions)		: null,
			
			/**
			 * A LocationList instance
			 * @type {LocationList}
			 * @readonly
			 */
			locations:  projectData.locations  ? new LocationList(projectData.locations)	: null,
			
			/**
			 * API routes for project operations
			 * @type {Object}
			 * @property {string} activate   | Route for activating this project
			 * @property {string} deactivate | Route for deactivating this project
			 * @property {string} show    | Route for showing this project
			 * @property {string} update  | Route for updating this project
			 * @property {string} destroy | Route for destroying this project
			 */
			routes: {
				activate:	route('projects.activate',	{ project: projectData.id }),
				deactivate: route('projects.deactivate'),
				show:		route('projects.show',		{ project: projectData.id }),
				update:		route('projects.update',	{ project: projectData.id }),
				destroy:	route('projects.destroy',	{ project: projectData.id })
			}
		})
	}


	/**
	 * Open Modal
	 * Open any of the available modals with associated props
	 * @param {string} modalName | the name of the modal to open
	 * @param {Array}  props     | any additional props to be added
	 */
	openModal(modalName, props) {

		switch(modalName) {
			case 'delete':
				modalActions.open('deleteProject', { project: this }); break;
			case 'rename':
				modalActions.open('renameProject', { project: this }); break;
			case 'setBanner':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-[7/3]',
					endpoint: this.routes.update,
					media: this.getMedia('banner'),
					method: 'patch',
					reloadPageProps: ['activeProject.media', 'projects.media'],
					title: "Upload Project banner",
					type: 'banner',
				}); break;
			default:
				console.log('ProjectObject.openModal', modalName, props)
		}
	}

	// destroy() {
	// 	modalActions.open('deleteProject', 	{ project: this })
	// }

	// rename() {
	// 	modalActions.open('renameProject', 	{ project: this })
	// }



	/**
	 * Get Media
	 * @param {string} type | The "type" of media to filter
	 * @returns {Object} first media instance with specified type
	 */
	getMedia(type) {
		return type ? this.media?.filter(m => m.type === type)?.[0] : null
	}

	/**
	 * Get All Media
	 * @param {string} type | The "type" of media to filter
	 * @returns {Array} all media instances with specified type
	 */
	getAllMedia(type) {
		return type ? this.media?.filter(m => m.type === type) : null
	}


	
	/**
	 * Controller - Activate
	 * @param {Object} data | The data to ACTIVATE on the database
	 */
	activate() {
		router.post( this.routes.activate, {}, {
			onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
		})
	}

	/**
	 * Controller - Deactivate
	 * @param {Object} data | The data to DEACTIVATE on the database
	 */
	deactivate() {
		router.post( this.routes.deactivate, {}, {
			onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
		})
	}

	/**
	 * Controller - Store
	 * @param {Object} data | The data to STORE on the database
	 */
	_store(data) {
		router.post( this.routes.store, data, {
			onFinish: () => router.visit( router.page.url, { only: ['characters', 'character'] })
		})
	}

	/**
	 * Controller - Update
	 * @param {Object} data | The data to UPDATE on the database
	 */
	_update(data) {
		router.patch( this.routes.update, data, {
			onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
		})
	}

	/**
	 * Controller - Destroy
	 * @param {Object} data | The data to DESTROY on the database
	 */
	_destroy(data) {
		router.destroy( this.routes.destroy, data, {
			onFinish: () => router.visit( router.page.url, { only: ['characters', 'character'] })
		})
	}
}
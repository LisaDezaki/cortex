/**
 * @typedef {import('@inertiajs/svelte')} router
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/EntityObject')} EntityObject
 * @typedef {import('@/services/FactionObject')} FactionObject
 */

import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore'
import EntityList from '@/services/EntityList'

/**
 * Class: Entity Object
 * Represents a single Entity record
 * @class
 * @classdesc A Entity entity as fetched from the database
 * with other functionality to make data handling easier
 */

export default class EntityObject {

	/**
	 * Creates a new EntityObject instance
	 * @param {Object} entityData
	 * @throws {TypeError} if entityData is not provided
	 */
	constructor(entityData) {
		if (!entityData || (typeof entityData !== 'object')) {
			throw new TypeError('EntityObject constructor requires a valid entity object');
		}

		Object.assign(this, {
			laravelClass: "App\Models\\"+entityData.singular,	//	e.g, App\Models\Character
			items: list.map(i => new EntityObject(i)),
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
				modalActions.open('deleteEntity', {
					entity: this
				}); break;
			case 'rename':
				modalActions.open('setValue', {
					entity: this,
					endpoint: this.routes.update,
					field: {
						name: 'name',
						type: 'text',
					},
					title: 'Rename entity: ' + this.name,
					...props
				}); break;
			case 'description':
				modalActions.open('setValue', {
					entity: this,
					endpoint: this.routes.update,
					field: {
						name: 'description',
						label: 'Description',
						type: 'textarea',
						rows: 12
					},
					title: 'Describe entity: ' + this.name,
					...props
				}); break;
			case 'setMedia':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-square',
					endpoint: this.routes.update,
					media: this.getMedia(props.type),
					method: 'patch',
					reloadPageProps: ['entity.media', 'entitys.media'],
					title: 'Upload ' + props.type + ' for ' + this.name,
					type: props.type,
					...props
				}); break;
			case 'customField':
				modalActions.open('setCustomFieldValue', {
					entity: this,
					endpoint: this.routes.update,
					field: { fieldableType: this.laravelClass },
					reloadPageProps: ['activeProject', 'entity.customFieldValues', 'entitys.customFieldValues'],
					...props
				}); break;
			default:
				console.log('EntityObject.openModal', modalName, props)
		}
	}


	/**
	 * Find Faction
	 * Returns the FactionObject with the provided id,
	 * if it exists in this.factions
	 * @param {string} id - the UUID of the desired Faction
	 * @returns {FactionObject} if one is found
	 */
	findFaction(id) {
		return this.factions.items?.find(f => f.id === id) || null
	}


	/**
	 * Find Relationship
	 * Returns the EntityObject with the provided id,
	 * if it exists in this.relationships
	 * @param {string} id - the UUID of the desired Entity
	 * @returns {EntityObject} if one is found
	 */
	findRelationship(id) {
		return this.relationships.items?.find(r => r.id === id) || null
	}


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
	 * Star
	 * Toggle this Entity's "starred" field in the database
	 * @returns {void}
	 */
	star() {
		this._update({ starred: !Boolean(this.starred) })
	}


	/**
	 * Set Custom Field
	 * Sets a specific custom field to a specific available value
	 * for this Entity in the database
	 * @param {string} id - the UUID of the CustomField to update
	 * @param {string} value - the new value to set for this field
	 */
	setCustomField(id, value) {
		this._update({ custom_fields: [{ id, value }] })
	}


	/**
	 * Update Coordinates
	 * Set new location and coordinates for this Entity
	 * @param {Object} location 
	 * @param {Object} xy - a 2D vector with X and Y coordinates
	 */
	updateCoordinates(location, xy) {
		this._update({ mapItems: [{
			location_id: location.id,
			mappable_id: this.id,
			mappable_type: this.laravelClass,
			x: xy.x,
			y: xy.y
		}] })
	}


	/**
	 * Remove Coordinates
	 * Remove the location and coordinates for this Entity
	 * @returns {void} 
	 */
	removeCoordinates() {
		console.log('EntityObject.removeCoordinates')
	}







	/**
	 * Add Relationship
	 * @param {string} related_id - The UUID of the Entity
	 * @param {string} role 
	 * @param {string} related_role 
	 */
	addRelationship(related_id, role, related_role) {
		console.log(related_id, role, related_role)
	}

	/**
	 * Remove Relationship
	 * @param {string} id | The UUID of the Entity to remove
	 */
	removeRelationship(id) {
		console.log('remove specific relationship with id: ', id)
	}

	/**
	 * Clear Relationships
	 * Remove all relationships from this Entity
	 */
	clearRelationships() {
		console.log('clear all relationships from this entity')
	}

	/**
	 * Add Faction
	 * @param   {string} id | The UUID of the Faction to add
	 * @returns {void}
	 */
	addFaction(id) {
		this._update({ factions: [{ id }] })
	}

	/**
	 * 
	 * @param {Object} option | The Option
	 * @param {number} index  | The index of the Faction
	 */
	syncFactions(option, index) {
		let factionIds = this.factions.items?.map((f,i) => {
			return { id: i !== index ? f.id : opt.id }
		})
		this._update({ factions: factionIds })
	}





	/**
	 * Controller - Store
	 * @param {Object} data | The data to STORE on the database
	 */
	_store(data) {
		router.post( this.routes.store, data, {
			onFinish: () => router.visit( router.page.url, { only: ['entitys', 'entity'] })
		})
	}

	/**
	 * Controller - Update
	 * @param {Object} data | The data to UPDATE on the database
	 */
	_update(data) {
		router.patch( this.routes.update, data, {
			onFinish: () => router.visit( router.page.url, { only: ['entitys', 'entity'] })
		})
	}

	/**
	 * Controller - Destroy
	 * @param {Object} data | The data to DESTROY on the database
	 */
	_destroy(data) {
		router.destroy( this.routes.destroy, data, {
			onFinish: () => router.visit( router.page.url, { only: ['entitys', 'entity'] })
		})
	}
}
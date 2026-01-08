/**
 * @typedef {import('@inertiajs/svelte')} router
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/CharacterObject')} CharacterObject
 * @typedef {import('@/services/FactionList')} FactionList
 * @typedef {import('@/services/FactionObject')} FactionObject
 * @typedef {import('@/services/ItemObject')} ItemObject
 */

import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore'
import CharacterList from '@/services/CharacterList'
import FactionList from '@/services/FactionList'
import LocationObject from '@/services/LocationObject'

/**
 * Class: Item Object
 * Represents a single Item record
 * @class
 * @classdesc A Item entity as fetched from the database
 * with other functionality to make data handling easier
 */

export default class ItemObject {

	/**
	 * Creates a new ItemObject instance
	 * @param {Object} itemData
	 * @throws {TypeError} if itemData is not provided
	 */
    constructor(itemData) {
		if (!itemData || (typeof itemData !== 'object')) {
			throw new TypeError('ItemObject constructor requires a valid item object');
		}
        Object.assign(this, itemData, {
			
			/**
			 * Laravel's Model location as printed by Item::class
			 * @type {string}
			 * @readonly
			 */
			laravelClass: "App\Models\Item",

			/**
			 * A FactionList instance
			 * @type {FactionList}
			 * @readonly
			 */
			// factions: characterData.factions ? new FactionList(characterData.factions) : null,
			
			/**
			 * A LocationObject instance
			 * @type {LocationObject}
			 * @readonly
			 */
			// location: characterData.mapData?.location ? new LocationObject(characterData.mapData.location) : null,

			/**
			 * A ItemList instance
			 * @type {ItemList}
			 * @readonly
			 */
			// relationships: characterData.relationships ? new ItemList(characterData.relationships) : null,

		})
    }


	/**
	 * Open Modal
	 * Open any of the available modals with associated props
	 * @param {string} modalName | the name of the modal to open
	 * @param {Array}  props     | any additional props to be added
	 */
	openModal(modalName, props) {

		const updateProps  = { entity: this, endpoint: this.routes.update  }
		const destroyProps = { entity: this, endpoint: this.routes.destroy }

		switch(modalName) {
			case 'rename':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'name', type: 'text' },
					reloadPageProps: ['item.name'],
					title: 'Rename item: ' + this.name,
				...props }); break;
			case 'type':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'type', type: 'text' },
					reloadPageProps: ['item.type'],
					title: 'Set type: ' + this.name,
				...props }); break;
			case 'description':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'description', label: 'Description', type: 'textarea', rows: 12 },
					reloadPageProps: ['item.description'],
					title: 'Describe item: ' + this.name,
				...props }); break;
			case 'location':
				modalActions.open('setLocation', { ...updateProps,
					field: 'location',
					title: 'Set location: ' + this.name,
				...props }); break;
			case 'setMedia':
				modalActions.open('uploadMedia', { ...updateProps,
					aspect: 'aspect-square',
					media: this.getMedia(props.type),
					method: 'patch',
					reloadPageProps: ['character.media', 'characters.media'],
					title: 'Upload ' + props.type + ' for ' + this.name,
					type: props.type,
				...props }); break;
			case 'customField':
				modalActions.open('customFieldValue', { ...updateProps,
					field: { fieldableType: this.laravelClass },
					reloadPageProps: ['activeProject', 'item.customFieldValues', 'items.customFieldValues'],
					title: 'Set ' + props?.field?.name + ': ' + this.name,
				...props }); break;
			case 'delete':
				modalActions.open('deleteEntity', { ...destroyProps,
					entityName: 'item',
				...props }); break;
			default:
				console.log('ItemObject.openModal', modalName, props)
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
	 * Returns the CharacterObject with the provided id,
	 * if it exists in this.relationships
	 * @param {string} id - the UUID of the desired Character
	 * @returns {CharacterObject} if one is found
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
	 * Toggle this Character's "starred" field in the database
	 * @returns {void}
	 */
	star() {
		this._update({ starred: !Boolean(this.starred) })
	}


	/**
	 * Set Custom Field
	 * Sets a specific custom field to a specific available value
	 * for this Character in the database
	 * @param {string} id - the UUID of the CustomField to update
	 * @param {string} value - the new value to set for this field
	 */
	setCustomField(id, value) {
		this._update({ custom_fields: [{ id, value }] })
	}


	/**
	 * Update Coordinates
	 * Set new location and coordinates for this Character
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
	 * Remove the location and coordinates for this Character
	 * @returns {void} 
	 */
	removeCoordinates() {
		console.log('CharacterObject.removeCoordinates')
	}







	/**
	 * Add Relationship
	 * @param {string} related_id - The UUID of the Character
	 * @param {string} role 
	 * @param {string} related_role 
	 */
	addRelationship(related_id, role, related_role) {
		console.log(related_id, role, related_role)
	}

	/**
	 * Remove Relationship
	 * @param {string} id | The UUID of the Character to remove
	 */
	removeRelationship(id) {
		console.log('remove specific relationship with id: ', id)
	}

	/**
	 * Clear Relationships
	 * Remove all relationships from this Character
	 */
	clearRelationships() {
		console.log('clear all relationships from this character')
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
			onFinish: () => router.visit( router.page.url, { only: ['characters', 'character'] })
		})
	}

	/**
	 * Controller - Update
	 * @param {Object} data | The data to UPDATE on the database
	 */
	_update(data) {
		router.patch( this.routes.update, data, {
			onFinish: () => router.visit( router.page.url, { only: ['characters', 'character'] })
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
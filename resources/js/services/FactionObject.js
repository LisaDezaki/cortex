/**
 * @typedef {import('@inertiajs/svelte')} router
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/CharacterList')} CharacterList
 * @typedef {import('@/services/LocationObject')} LocationObject
 */

import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import CharacterList from '@/services/CharacterList'
import LocationObject from '@/services/LocationObject'

/**
 * Class: Faction Object
 * Represents a single Faction record
 * @class
 * @classdesc A Faction entity as fetched from the database
 * with other functionality to make data handling easier
 */

export default class FactionObject {

	/**
	 * Creates a new FactionObject instance
	 * @param {Object} factionData
	 * @throws {TypeError} if factionData is not provided
	 */
	constructor(factionData) {
		if (!factionData || (typeof factionData !== 'object')) {
			throw new TypeError('FactionObject constructor requires a valid faction object');
		}
		Object.assign(this, factionData, {

			/**
			 * Laravel's Model location as printed by Faction::class
			 * @type {string}
			 */
			laravelClass:	"App\Models\Faction",

			/**
			 * A LocationObject instance
			 * @type {LocationObject}
			 * @readonly
			 */
			headquarters: factionData.headquarters ? new LocationObject(factionData.headquarters) : null,

			/**
			 * A CharacterList instance
			 * @type {CharacterList}
			 * @readonly
			 */
			members: factionData.members ? new CharacterList(factionData.members) : null,
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
					title: 'Rename faction: ' + this.name,
				...props }); break;
			case 'type':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'type', type: 'text' },
					title: 'Set type: ' + this.name,
				...props }); break;
			case 'description':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'description', label: 'Description', type: 'textarea', rows: 12 },
					title: 'Describe faction: ' + this.name,
				...props }); break;
			case 'ideology':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'ideology', label: 'Ideology', type: 'textarea', rows: 12 },
					title: 'Describe ideology: ' + this.name,
				...props }); break;
			case 'headquarters':
				modalActions.open('setLocation', { ...updateProps,
					field: 'headquarters',
				...props }); break;
			case 'member':
				modalActions.open('setFactionMember', { character: this, ...props }); break;
			case 'members':
				modalActions.open('selectMany', { ...updateProps,
					field: 'members',
					selected: this.members.items?.map(m => m.id) || [],
					title: "Set members of the " + this.name + " faction",
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
			case 'delete':
				modalActions.open('deleteEntity', { ...destroyProps,
					entityName: 'faction',
				...props }); break;
			default:
				console.log('FactionObject.openModal', modalName, props)
		}

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
	 * Toggle this Faction's "starred" field in the database
	 * @returns {void}
	 */
	star() {
		this._update({ starred: !Boolean(this.starred) })
	}

	/**
	 * Set Custom Field
	 * Sets a specific custom field to a specific available value
	 * for this Faction in the database
	 * @param {string} id - the UUID of the CustomField to update
	 * @param {string} value - the new value to set for this field
	 */
	setCustomField(id, value) {
		this._update({ custom_fields: [{ id, value }] })
	}

	/**
	 * Add Member
	 * Adds a new Character to this Faction's list of members
	 * @param   {Object} opt - the option
	 * @returns {void}
	 */
	addMember(opt) {
		this._update({ members: [{ id: opt.id }] })
	}

	/**
	 * Star
	 * Toggle this Faction's "starred" field in the database
	 * @returns {void}
	 */
	star() {
		this._update({ starred: !Boolean(this.starred) })
	}





	/**
	 * Controller - Store
	 * @param {Object} data | The data to STORE on the database
	 */
	_store(data) {
		router.post( this.routes.store, data, {
			onFinish: () => router.visit( router.page.url, { only: ['factions', 'faction'] })
		})
	}

	/**
	 * Controller - Update
	 * @param {Object} data | The data to UPDATE on the database
	 */
	_update(data) {
		router.patch( this.routes.update, data, {
			onFinish: () => router.visit( router.page.url, { only: ['factions', 'faction'] })
		})
	}

	/**
	 * Controller - Destroy
	 * @param {Object} data | The data to DESTROY on the database
	 */
	_destroy(data) {
		router.destroy( this.routes.destroy, data, {
			onFinish: () => router.visit( router.page.url, { only: ['factions', 'faction'] })
		})
	}
}
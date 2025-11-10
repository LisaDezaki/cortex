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
import CharacterObject from '@/services/CharacterObject'
import FactionObject from '@/services/FactionObject'
import LocationList from '@/services/LocationList'

/**
 * Class: Location Object
 * Represents a single Location record
 * @class
 * @classdesc A Location entity as fetched from the database
 * with other functionality to make data handling easier
 */

export default class LocationObject {

	/**
	 * Creates a new LocationObject instance
	 * @param {Object} locationData
	 * @throws {TypeError} if locationData is not provided
	 */
	constructor(locationData) {
		if (!locationData || (typeof locationData !== 'object')) {
			throw new TypeError('LocationObject constructor requires a valid location object');
		}
		Object.assign(this, locationData, {

			/**
			 * Laravel's Model location as printed by Location::class
			 * @type {string}
			 */
			laravelClass:	"App\Models\Location",

			/**
			 * A collection of entities as MapItems
			 * @type {Array}
			 * @readonly
			 */
			mapItems: locationData?.mapItems ? {
				all:		locationData.mapItems,
				characters: locationData.mapItems.filter(i => i.type === 'character'),
				factions:   locationData.mapItems.filter(i => i.type === 'faction'  ),
				locations:	locationData.mapItems.filter(i => i.type === 'location' )
			} : [],

			/**
			 * API routes for location operations
			 * @type {Object}
			 * @property {string} show    | Route for showing this location
			 * @property {string} update  | Route for updating this location
			 * @property {string} destroy | Route for destroying this location
			 */
			routes: {
				show:    route('locations.show',    { location: locationData.slug }),
				update:  route('locations.update',  { location: locationData.slug }),
				destroy: route('locations.destroy', { location: locationData.slug })
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
				modalActions.open('deleteLocation', { location: this }); break;
			case 'rename':
				modalActions.open('renameLocation', { location: this }); break;
			case 'setBanner':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-[7/3]',
					endpoint: this.routes.update,
					media: this.getMedia('banner'),
					method: 'patch',
					reloadPageProps: ['location.media', 'locations.media'],
					title: 'Upload banner for ' + this.name,
					type: 'banner',
				}); break;
			case 'setMap':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-square',
					endpoint: this.routes.update,
					media: this.getMedia('map'),
					method: 'patch',
					reloadPageProps: ['location.media', 'locations.media'],
					title: 'Upload map for ' + this.name,
					type: 'map',
				}); break;
			default:
				console.log('LocationObject.openModal', modalName, props)
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
	 * Add Map Marker
	 * @param {Array} items | The items to add
	 */
	addMapMarker(items) {
		console.log('LocationObject.addMapMarker()', items.map(i => ({
			location_id: this.id,
			...i
		})))
		this._update({ mapItems: items.map(i => ({
			location_id: this.id,
			...i
		}))})
	}




	/**
	 * Controller - Store
	 * @param {Object} data | The data to STORE on the database
	 */
	_store(data) {
		router.post( this.routes.store, data, {
			onFinish: () => router.visit( router.page.url, { only: ['locations', 'location'] })
		})
	}

	/**
	 * Controller - Update
	 * @param {Object} data | The data to UPDATE on the database
	 */
	_update(data) {
		router.patch( this.routes.update, data, {
			onFinish: () => router.visit( router.page.url, { only: ['locations', 'location'] })
		})
	}

	/**
	 * Controller - Destroy
	 * @param {Object} data | The data to DESTROY on the database
	 */
	_destroy(data) {
		router.destroy( this.routes.destroy, data, {
			onFinish: () => router.visit( router.page.url, { only: ['locations', 'location'] })
		})
	}
}
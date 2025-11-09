/**
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/LocationObject')} LocationObject
 */

import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import LocationObject   from '@/services/LocationObject'

/**
 * Class: Location List
 * Represents a collection of Location records
 * @class
 * @classdesc A list of LocationObjects (this.items) with a collection
 * of other functionality to make data handling easier
 */

export default class LocationList {

	/**
	 * Creates a new LocationList instance
	 * @param {Array} list 
	 * @throws {TypeError} if list is not an array or object
	 */
	constructor(list) {
		if (!list || (typeof list !== 'object') || !Array.isArray(list)) {
			throw new TypeError('LocationList constructor requires an array or object');
		}
		Object.assign(this, {

			/**
			 * Array of LocationObject instances
			 * @type {Array<LocationObject}
			 * @readonly
			 */
			items: list.map(i => new LocationObject(i)),

			/**
			 * History stack for undo/redo functionality
			 * @type {Array<Object>}
			 * @private
			 */
			history: [],

			/**
			 * API routes for location operations
			 * @type {Object}
			 * @property {string} store | Route for storing new locations
			 */
			routes: {
				store:	route('locations.store')
			}
		})

		/** @private */
		this._saveToHistory(); // Save initial state to history
	}

	/**
	 * Create
	 * Open the modal for creating a new faction entity
	 * @returns {void}
	 */
	create() {
		modalActions.open('createLocation')
	}

	/**
	 * Filter
	 * Returns a filtered list of items based on the strings provided
	 * @param {string} query
	 * @param {string} filter
	 * @param {string} sort
	 * @returns {Array}
	 */
	filter(query, filter, sort) {
		return this.items
			.filter(item => item.name.toLowerCase().includes(query.toLowerCase()))
			.filter(filter).sort(sort)
	}

	/**
	 * Find
	 * Returns the item with the provided id, if it exists
	 * @param {string} id
	 * @returns {Object}
	 */
	find(id) {
		return this.items.find(item => item.id === id)
	}

	// getWorldMap() {
	// 	return this.items.find(item => item.isWorldMap)
	// }

	/**
	 * History / Undo
	 * Keep only the last 50 states to prevent memory issues
	 * @returns {void}
	 */
	_saveToHistory() {
		this.history.push([...this.items]);
		if (this.history.length > 50) {
			this.history.shift();
		}
	}
}
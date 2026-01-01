/**
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/CustomFieldObject')} CustomFieldObject
 */

import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import CustomFieldObject from '@/services/CustomFieldObject'

/**
 * Class: CustomField List
 * Represents a collection of CustomField records
 * @class
 * @classdesc A list of CustomFieldObjects (this.items) with a collection
 * of other functionality to make data handling easier
 */

export default class CustomFieldList {

	/**
	 * Creates a new CustomFieldList instance
	 * @param {Array} list
	 * @throws {TypeError} if list is not an array or object
	 */
	constructor(list) {
		if (!list || (typeof list !== 'object')) {
			throw new TypeError('CustomFieldList constructor requires an array or object');
		}
		Object.assign(this, {

			/**
			 * Array of CustomFieldObject instances
			 * @type {Array<CustomFieldObject>}
			 * @readonly
			 */
			items: list.map(i => new CustomFieldObject(i)),

			/**
			 * History stack for undo/redo functionality
			 * @type {Array<Object>}
			 * @private
			 */
			history: [],

			/**
			 * API routes for project operations
			 * @type {Object}
			 * @property {string} store | Route for storing new projects
			 */
			// routes: {
			// 	create:	route('projects.create'),
			// 	deactivate: route('projects.deactivate'),
			// }
		})

		/** @private */
		this._saveToHistory(); // Save initial state to history
	}

	/**
	 * Create
	 * Open the modal for creating a new project entity
	 * @returns {void}
	 */
	create() {
		modalActions.open('createCustomField')
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

	/**
	 * Get by Fieldable type
	 * Returns an array of Custom Fields based on the requested Laravel class
	 * @param {string} fieldable 
	 * @returns {Array<Object>}
	 */
	getByFieldable(fieldable) {
		return this.items.filter(item => item.fieldableType.toLowerCase() === `app\\models\\${fieldable}`)
	}

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
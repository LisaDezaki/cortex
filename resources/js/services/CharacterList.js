/**
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/CharacterObject')} CharacterObject
 */

import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import CharacterObject from '@/services/CharacterObject'

/**
 * Class: Character List
 * Represents a collection of Character records
 * @class
 * @classdesc A list of CharacterObjects (this.items) with a collection
 * of other functionality to make data handling easier
 */

export default class CharacterList {

	/**
	 * Creates a new CharacterList instance
	 * @param {Array} list
	 * @throws {TypeError} if list is not an array or object
	 */
	constructor(list) {
		if (!list || (typeof list !== 'object')) {
			throw new TypeError('CharacterList constructor requires an array or object');
		}
		Object.assign(this, {

			/**
			 * Array of CharacterObject instances
			 * @type {Array<CharacterObject>}
			 * @readonly
			 */
			items: list.map(i => new CharacterObject(i)),

			/**
			 * History stack for undo/redo functionality
			 * @type {Array<Object>}
			 * @private
			 */
			history: [],

			/**
			 * API routes for character operations
			 * @type {Object}
			 * @property {string} store | Route for storing new characters
			 */
			routes: {
				store:	route('characters.store')
			}
		})

		/** @private */
		this._saveToHistory(); // Save initial state to history
	}

	/**
	 * Create
	 * Open the modal for creating a new character entity
	 * @returns {void}
	 */
	create() {
		modalActions.open('createCharacter')
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
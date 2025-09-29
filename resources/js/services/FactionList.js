import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';
import FactionObject from '@/services/FactionObject'

export default class FactionList {
	constructor(list) {
		Object.assign(this, {
			items: Array.isArray(list) ? list.map(i => new FactionObject(i)) : [list],
			history: [], // Track changes for undo/redo
			filters: {}, // Store active filters
			sortOrder: null, // Current sort order
			routes: {
				store:	route('factions.store')
			}
		})
		this._saveToHistory(); // Save initial state to history
	}

	create() {
		modalActions.open('createFaction')
	}

	filter(query, filter, sort) {
		return this.items.filter(item => item.name.toLowerCase().includes(query.toLowerCase()))
			.filter(filter).sort(sort)
	}

	// History/Undo
	_saveToHistory() {
		this.history.push([...this.items]);
		// Keep only last 50 states to prevent memory issues
		if (this.history.length > 50) {
			this.history.shift();
		}
	}
}
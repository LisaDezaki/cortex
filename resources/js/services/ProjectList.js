import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';
import ProjectObject from '@/services/ProjectObject'

export default class ProjectList {
	constructor(list) {
		Object.assign(this, {
			items: Array.isArray(list) ? list.map(i => new ProjectObject(i)) : [list],
			history: [], // Track changes for undo/redo
			filters: {}, // Store active filters
			sortOrder: null, // Current sort order
			routes: {
				create:	route('projects.create')
			}
		})
		this._saveToHistory(); // Save initial state to history
	}

	create() {
		modalActions.open('createProject')
	}

	filter(query, filter) {
		console.log('ProjectList.filter()', query, filter)
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
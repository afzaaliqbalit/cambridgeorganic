const SessionStorage = {
    /**
     * Create/Update item
     * @param {string} key
     * @param {*} value
     */
    set(key, value) {
        sessionStorage.setItem(key, JSON.stringify(value));
        return value;
    },

    /**
     * Get item
     * @param {string} key
     * @param {*} defaultValue
     */
    get(key, defaultValue = null) {
        const value = sessionStorage.getItem(key);

        if (value === null) {
            return defaultValue;
        }

        try {
            return JSON.parse(value);
        } catch {
            return value;
        }
    },

    /**
     * Update existing object
     * @param {string} key
     * @param {object|function} updates
     */
    update(key, updates) {
        const current = this.get(key, {});

        const newValue = typeof updates === 'function'
            ? updates(current)
            : { ...current, ...updates };

        this.set(key, newValue);

        return newValue;
    },

    /**
     * Delete item
     * @param {string} key
     */
    remove(key) {
        sessionStorage.removeItem(key);
    },

    /**
     * Check if key exists
     * @param {string} key
     */
    has(key) {
        return sessionStorage.getItem(key) !== null;
    },

    /**
     * Clear all session storage
     */
    clear() {
        sessionStorage.clear();
    },

    /**
     * Push item to array
     * @param {string} key
     * @param {*} value
     */
    push(key, value) {
        const arr = this.get(key, []);

        if (!Array.isArray(arr)) {
            throw new Error(`${key} is not an array.`);
        }

        arr.push(value);
        this.set(key, arr);

        return arr;
    },

    /**
     * Remove array item
     * @param {string} key
     * @param {function} callback
     */
    removeFromArray(key, callback) {
        const arr = this.get(key, []);

        if (!Array.isArray(arr)) {
            throw new Error(`${key} is not an array.`);
        }

        const filtered = arr.filter((item, index) => !callback(item, index));

        this.set(key, filtered);

        return filtered;
    }
};
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

const Storage = {
    /**
     * Create/Update item
     * @param {string} key
     * @param {*} value
     */
    set(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
        return value;
    },

    /**
     * Get item
     * @param {string} key
     * @param {*} defaultValue
     */
    get(key, defaultValue = null) {
        const value = localStorage.getItem(key);

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
        let current;

        try {
            current = JSON.parse(localStorage.getItem(key));
        } catch (e) {
            current = null;
        }

        if (current === null) {
            current = Array.isArray(updates) ? [] : {};
        }

        let newValue;

        if (typeof updates === 'function') {
            newValue = updates(current);
        } else if (Array.isArray(current) && Array.isArray(updates)) {
            // Append array items
            newValue = [...current, ...updates];
        } else if (
            current &&
            typeof current === 'object' &&
            !Array.isArray(current) &&
            updates &&
            typeof updates === 'object' &&
            !Array.isArray(updates)
        ) {
            // Merge object properties
            newValue = { ...current, ...updates };
        } else {
            // Replace value
            newValue = updates;
        }

        localStorage.setItem(key, JSON.stringify(newValue));

        return newValue;
    },

    /**
     * Delete item
     * @param {string} key
     */
    remove(key) {
        localStorage.removeItem(key);
    },

    /**
     * Check if key exists
     * @param {string} key
     */
    has(key) {
        return localStorage.getItem(key) !== null;
    },

    /**
     * Clear all local storage
     */
    clear() {
        localStorage.clear();
    },

    /**
     * Push item to array
     * @param {string} key
     * @param {*} value
     */
    push(key, value) {
        const arr = localStorage.getItem(key);

        if (!Array.isArray(arr)) {
            throw new Error(`${key} is not an array.`);
        }

        arr.push(value);
        localStorage.setItem(key, arr);

        return arr;
    },

    /**
     * Remove array item
     * @param {string} key
     * @param {function} callback
     */
    removeFromArray(key, callback) {
        const arr = localStorage.getItem(key);

        if (!Array.isArray(arr)) {
            throw new Error(`${key} is not an array.`);
        }

        const filtered = arr.filter((item, index) => !callback(item, index));

        localStorage.setItem(key, filtered);

        return filtered;
    }
};

const php_session = {
    endpoint: window.ajax_url,


    /**
     * Send request to PHP
     * @param {string} action
     * @param {object} data
     * @returns {Promise<any>}
     */
    request(action, data = {}) {
        return $.ajax({
            url: this.endpoint,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'php_session',
                session_action: action,
                ...data
            }
        }).then(response => {
            if (!response.success) {
                throw new Error(response.data || 'Session request failed.');
            }

            return response.data;
        });
    },

    /**
     * Create/Update session value
     * @param {string} key
     * @param {*} value
     */
    set(key, value) {
        if(key === 'api_token') {
            return;
        }
        return this.request('set', {
            key,
            value: JSON.stringify(value)
        });
    },

    /**
     * Get session value
     * @param {string} key
     * @param {*} defaultValue
     */
    async get(key, defaultValue = null) {
        if(key === 'api_token') {
            return;
        }
        const value = await this.request('get', { key });

        return value === null ? defaultValue : value;
    },

    /**
     * Update existing object
     * @param {string} key
     * @param {object|function} updates
     */
    async update(key, updates) {
        if(key === 'api_token') {
            return;
        }
        const current = await this.get(key, {});

        const newValue = typeof updates === 'function'
            ? updates(current)
            : { ...current, ...updates };

        await this.set(key, newValue);

        return newValue;
    },

    /**
     * Delete session value
     * @param {string} key
     */
    remove(key) {
        return this.request('remove', { key });
    },

    /**
     * Check if key exists
     * @param {string} key
     */
    has(key) {
        return this.request('has', { key });
    },

    /**
     * Clear PHP session
     */
    clear() {
        return this.request('clear');
    },

    /**
     * Push item to array
     * @param {string} key
     * @param {*} value
     */
    async push(key, value) {
        const arr = await this.get(key, []);

        if (!Array.isArray(arr)) {
            throw new Error(`${key} is not an array.`);
        }

        arr.push(value);

        await this.set(key, arr);

        return arr;
    },

    /**
     * Remove array items
     * @param {string} key
     * @param {function} callback
     */
    async removeFromArray(key, callback) {
        const arr = await this.get(key, []);

        if (!Array.isArray(arr)) {
            throw new Error(`${key} is not an array.`);
        }

        const filtered = arr.filter((item, index) => !callback(item, index));

        await this.set(key, filtered);

        return filtered;
    }
};